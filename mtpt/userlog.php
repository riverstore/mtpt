<?php
require "include/bittorrent.php";
require_once(get_langfile_path());
dbconn();

$action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : (isset($_GET['action']) ? htmlspecialchars($_GET['action']) : '');
$allowed_actions = array("userlog","search");
if (!$action)
	$action='userlog';
if (!in_array($action, $allowed_actions))
stderr($lang_log['std_error'], $lang_log['std_invalid_action']);

function searchtable($title, $action, $opts = array()){
		global $lang_log;
		print("<table border=1 cellspacing=0 width=940 cellpadding=5>\n");
		print("<tr><td class=colhead align=left>".$title."</td></tr>\n");
		print("<tr><td class=toolbox align=left><form method=\"get\" action='" . $_SERVER['PHP_SELF'] . "'>\n");
		if ($opts) {
			print("<select name=search>");
			foreach($opts as $value => $text)
				print("<option value='".$value."'". ($value == $_GET['search'] ? " selected" : "").">".$text."</option>");
			print("</select>");
			}
		print("<input type=\"text\" name=\"query\" style=\"width:200px\" value=\"".$_GET['query']."\">\n");
		print("<input type=\"hidden\" name=\"action\" value='".$action."'>&nbsp;&nbsp;");
		print("<input type=submit value=" . $lang_log['submit_search'] . ">&nbsp;&nbsp;".$lang_log['text_other']."</form>\n");
		print("</td></tr></table><br />\n");
}

if (!in_array($action, $allowed_actions))
stderr($lang_log['std_error'], $lang_log['std_invalid_action']);
else {
	switch ($action){
	case "userlog":
		stdhead($lang_log['head_site_log']);
		$query = mysql_real_escape_string(trim($_GET["query"]));
		$search = $_GET["search"];

		$addparam = "";
		$wherea = "";

		if(!empty($query)){
			switch ($search)
			{
				case "username": 
					$wherea=" WHERE user_name LIKE '%".$query."%'";
					break;
				case "userid":
					$wherea=" WHERE user_id LIKE '%".$query."%'";
					break;
				case "reson":
					$wherea=" WHERE detail LIKE '%".$query."%'";
					break;
			}
		}

		$opt = array (username => $lang_log['text_username'], userid => $lang_log['text_userid'], reson => $lang_log['text_reson']);
		searchtable($lang_log['text_search_log'], 'userlog',$opt);

		$res = sql_query("SELECT COUNT(*) FROM users_log".$wherea);
		$row = mysql_fetch_array($res);
		$count = $row[0];

		$perpage = 50;

		list($pagertop, $pagerbottom, $limit) = pager($perpage, $count, "?".$addparam);

		$res = sql_query("SELECT * FROM users_log $wherea ORDER BY id DESC $limit") or sqlerr(__FILE__, __LINE__);
		if (mysql_num_rows($res) == 0)
		print($lang_log['text_log_empty']);
		else
		{

		//echo $pagertop;

			print("<table width=940 border=1 cellspacing=0 cellpadding=5>\n");
			print("<tr><td class=colhead align=center width=150px><img class=\"time\" src=\"pic/trans.gif\" alt=\"time\" title=\"".$lang_log['title_time_added']."\" /></td><td class=colhead align=left>".$lang_log['col_log']."</td><td class=colhead align=left>".$lang_log['col_reson']."</td></tr>\n");
			while ($arr = mysql_fetch_assoc($res))
			{
				$color = "";
				if ($arr['op'] == 'del') $color = "red";
				if ($arr['op'] == 'ban') $color = "blue";
				$log = "";
				$log .= $arr['op_id'] == 0?'系统':'管理员';
				$log .= $arr['op'] == 'del'?'删除了':'';
				$log .= $arr['op'] == 'ban'?'封禁了':'';
				$log .= '账号：';
				$log .= $arr['user_name']."($arr[user_id])";

				print("<tr><td class=\"rowfollow nowrap\" align=center>".$arr['op_time']."</td><td class=rowfollow align=left><font color='".$color."'>".htmlspecialchars($log)."</font></td><td class=rowfollow align=left><font color='".$color."'>".htmlspecialchars($arr['detail'])."</font></td></tr>\n");
			}
			print("</table>");
	
			echo $pagerbottom;
		}

		print($lang_log['time_zone_note']);
		stdfoot();
		die;
		break;
	}
}

?>
