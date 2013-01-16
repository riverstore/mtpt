<?php
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_SYSOP)
 stderr("Error", "Permission denied.");
 
$action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : (isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'showlist');
$id = isset($_POST['id']) ? htmlspecialchars($_POST['id']) : (isset($_GET['id']) ? htmlspecialchars($_GET['id']) : '');
$update = isset($_POST['update']) ? htmlspecialchars($_POST['update']) : (isset($_GET['update']) ? htmlspecialchars($_GET['update']) : '');

function check ($id) {	
	if (!is_valid_id($id))
		return stderr("Error","Invalid ID");
	else
		return true;
}
function safe_query ($query,$id,$where = '') {
	$query = sprintf("$query WHERE id ='%s'",
	mysql_real_escape_string($id));
	$result = sql_query($query);
	if (!$result)
		return sqlerr(__FILE__,__LINE__);
	redirect("maxlogin.php?update=".htmlspecialchars($where));
}
$countrows = number_format(get_row_count("loginattempts")) + 1;
$page = 0 + $_GET["page"];

$order = $_GET['order'];
if ($order == 'id')
	$orderby = "id";
elseif ($order == 'ip')
	$orderby = "ip";
elseif ($order == 'added')
	$orderby = "added";	
elseif ($order == 'attempts')
	$orderby = "attempts";
elseif ($order == 'type')
	$orderby = "type";
elseif ($order == 'status')
	$orderby = "banned";
else
	$orderby = "attempts";
			
$perpage = 5;
list($pagertop, $pagerbottom, $limit) = pager($perpage, $countrows, "maxlogin.php?order=$order&");

if ($action == 'showlist') {
stdhead ("Max. Login Attemps - Show List");
print("<h1>".$lang_maxlogin['head_failed']."</h1>");
print("<table border=1 cellspacing=0 cellpadding=5 width=100%>\n");
if ($update)
	$msg = "<tr><td colspan=6><b>".htmlspecialchars($update)." Successful!</b></td></tr>\n";
$res = sql_query("SELECT * FROM  loginattempts ORDER BY $orderby DESC $limit") or sqlerr(__FILE__,__LINE__);
if (mysql_num_rows($res) == 0)
	  print("<tr><td colspan=2><b>Nothing found</b></td></tr>\n");
else
{  
  print("<tr><td class=colhead><a href=?order=id>".$lang_maxlogin['text_id']."</a></td><td class=colhead align=left><a href=?order=ip>".$lang_maxlogin['text_ip']."</a></td><td class=colhead align=left><a href=?order=added>".$lang_maxlogin['text_action_time']."</a></td>".
    "<td class=colhead align=left><a href=?order=attempts>".$lang_maxlogin['text_attempts_time']."</a></td><td class=colhead align=left><a href=?order=type>".$lang_maxlogin['text_attempts_type']."</a></td><td class=colhead align=left><a href=?order=status>".$lang_maxlogin['text_status']."</a></td></tr>\n");

  while ($arr = mysql_fetch_assoc($res))
  {
  	$r2 = sql_query("SELECT id,username FROM users WHERE ip=".sqlesc($arr[ip])) or sqlerr(__FILE__,__LINE__);
  	$a2 = mysql_fetch_assoc($r2);	
 	  print("<tr><td align=>$arr[id]</td><td align=left>$arr[ip] " . ($a2[id] ? get_username($a2['id']) : "" ) . "</td><td align=left>$arr[added]</td><td align=left>$arr[attempts]</td><td align=left>".($arr[type] == "recover" ? $lang_maxlogin['type_recover'] : $lang_maxlogin['type_login'])."</td><td align=left>".($arr[banned] == "yes" ? "<font color=red><b>".$lang_maxlogin['status_banned']."</b></font> <a href=maxlogin.php?action=unban&id=$arr[id]><font color=green>[<b>".$lang_maxlogin['action_unban']."</b>]</font></a>" : "<font color=green><b>".$lang_maxlogin['status_notbanned']."</b></font> <a href=maxlogin.php?action=ban&id=$arr[id]><font color=red>[<b>".$lang_maxlogin['action_ban']."</b>]</font></a>")."  <a OnClick=\"return confirm('".$lang_maxlogin['text_notice']."');\" href=maxlogin.php?action=delete&id=$arr[id]>[<b>".$lang_maxlogin['action_delete']."</b></a>] <a href=maxlogin.php?action=edit&id=$arr[id]><font color=blue>[<b>".$lang_maxlogin['action_edit']."</b></a>]</font></td></tr>\n");
  }
  
}
print($msg);
print("</table>\n");
if ($countrows > $perpage)
	echo '<tr><td colspan=2>'.$pagerbottom.'</td></tr>';
searchform();
stdfoot();
}elseif ($action == 'ban') {
	check($id);
	stdhead ("Max. Login Attemps - BAN");	
	safe_query("UPDATE loginattempts SET banned = 'yes'",$id,"Ban");
	header("Location: maxlogin.php?update=Ban");
}elseif ($action == 'unban') {
	check($id);
	stdhead ("Max. Login Attemps - UNBAN");
	safe_query("UPDATE loginattempts SET banned = 'no'",$id,"Unban");
	
}elseif ($action == 'delete') {
	check($id);
	stdhead ("Max. Login Attemps - DELETE");
	safe_query("DELETE FROM loginattempts",$id,"Delete");	
}elseif ($action == 'edit') {
	check($id);	
	stdhead ("Max. Login Attemps - EDIT (".htmlspecialchars($id).")");	
	$query = sprintf("SELECT * FROM loginattempts WHERE id ='%s'",
	mysql_real_escape_string($id));
	$result = sql_query($query) or sqlerr(__FILE__,__LINE__);
	$a = mysql_fetch_array($result);
	print("<table border=1 cellspacing=0 cellpadding=5 width=100%>\n");
	print("<tr><td><p>".$lang_maxlogin['text_ip']."：<b>".htmlspecialchars($a[ip])."</b></p>");
	print("<p>".$lang_maxlogin['text_action_time'].": <b>".htmlspecialchars($a[added])."</b></p></tr></td>");
	print("<form method='post' action='maxlogin.php'>");
	print("<input type='hidden' name='action' value='save'>");
	print("<input type='hidden' name='id' value='$a[id]'>");
	print("<input type='hidden' name='ip' value='$a[ip]'>");
	if ($_GET['return'] == 'yes')
		print("<input type='hidden' name='returnto' value='viewunbaniprequest.php'>");
	print("<tr><td>".$lang_maxlogin['text_attempts_time']."<input type='text' size='33' name='attempts' value='$a[attempts]'>");
	print("<tr><td>".$lang_maxlogin['text_attempts_type']."<select name='type'><option value='login' ".($a["type"] == "login" ? "selected" : "").">".$lang_maxlogin['type_login']."</option><option value='recover' ".($a["type"] == "recover" ? "selected" : "").">".$lang_maxlogin['type_recover']."</option></select></tr></td>");	
	print("<tr><td>".$lang_maxlogin['text_status']."<select name='banned'><option value='yes' ".($a["banned"] == "yes" ? "selected" : "").">".$lang_maxlogin['status_banned']."</option><option value='no' ".($a["banned"] == "no" ? "selected" : "").">".$lang_maxlogin['status_notbanned']."</option></select></tr></td>");	
	print("<tr><td><input type='submit' name='submit' value='".$lang_maxlogin['submit_save']."' class=btn></tr></td>");
	print("</table>");
	stdfoot();
	
}elseif ($action == 'save') {
	$id = sqlesc(0+$_POST['id']);
	$ip = sqlesc($_POST['ip']);
	$attempts = sqlesc($_POST['attempts']);
	$type = sqlesc($_POST['type']);
	$banned = sqlesc($_POST['banned']);
		check($id);
		check($attempts);
	sql_query("UPDATE loginattempts SET attempts = $attempts, type = $type, banned = $banned WHERE id = $id LIMIT 1") or sqlerr(__FILE__,__LINE__);
	if ($_POST['returnto']){
		$returnto = $_POST['returnto'];
		header("Location: $returnto");
	}
	else
		header("Location: maxlogin.php?update=Edit");
}elseif ($action == 'searchip') {
	$ip = mysql_real_escape_string($_POST['ip']);	
	$search = sql_query("SELECT * FROM loginattempts WHERE ip LIKE '%$ip%'") or sqlerr(__FILE__,__LINE__);
	stdhead ("Max. Login Attemps - Search");
	print("<h2>".$lang_maxlogin['head_failed']."</h2>");
	print("<table border=1 cellspacing=0 cellpadding=5 width=100%>\n");
	if (mysql_num_rows($search) == 0)
	  print("<tr><td colspan=2><b>".$lang_maxlogin['text_nothing']."</b></td></tr>\n");
	else
		{  
 			print("<tr><td class=colhead><a href=?order=id>".$lang_maxlogin['text_id']."</a></td><td class=colhead align=left><a href=?order=ip>".$lang_maxlogin['text_ip']."</a></td><td class=colhead align=left><a href=?order=added>".$lang_maxlogin['text_action_time']."</a></td>".
    		"<td class=colhead align=left><a href=?order=attempts>".$lang_maxlogin['text_attempts_time']."</a></td><td class=colhead align=left><a href=?order=type>".$lang_maxlogin['text_attempts_type']."</a></td><td class=colhead align=left><a href=?order=status>".$lang_maxlogin['text_status']."</a></td></tr>\n");

			while ($arr = mysql_fetch_assoc($search))
				  {
				  	$r2 = sql_query("SELECT id,username FROM users WHERE ip=".sqlesc($arr[ip])) or sqlerr(__FILE__,__LINE__);
				  	$a2 = mysql_fetch_assoc($r2);	
				 	print("<tr><td align=>$arr[id]</td><td align=left>$arr[ip] " . ($a2[id] ? get_username($a2[id]) : "" ) . "</td><td align=left>$arr[added]</td><td align=left>$arr[attempts]</td><td align=left>".($arr[type] == "recover" ? $lang_maxlogin['type_recover'] :$lang_maxlogin['type_login'])."</td><td align=left>".($arr[banned] == "yes" ? "<font color=red><b>".$lang_maxlogin['status_banned']."</b></font> <a href=maxlogin.php?action=unban&id=$arr[id]><font color=green>[<b>".$lang_maxlogin['action_unban']."</b>]</font></a>" : "<font color=green><b>".$lang_maxlogin['status_notbanned']."</b></font> <a href=maxlogin.php?action=ban&id=$arr[id]><font color=red>[<b>".$lang_maxlogin['action_ban']."</b>]</font></a>")."  <a OnClick=\"return confirm('".$lang_maxlogin['text_notice']."');\" href=maxlogin.php?action=delete&id=$arr[id]>[<b>".$lang_maxlogin['action_delete']."</b></a>] <a href=maxlogin.php?action=edit&id=$arr[id]><font color=blue>[<b>".$lang_maxlogin['action_edit']."</b></a>]</font></td></tr>\n");
				  }
	}
	print("</table>\n");
	searchform();
	stdfoot();
}
else
	stderr("Error","Invalid Action");

function searchform () {
	global $lang_maxlogin;
?>
<br />
<form method=post name=search action=maxlogin.php?>
<input type=hidden name=action value=searchip>
<p class=success align=center><? print($lang_maxlogin['text_searchip']);?><input type=text name=ip size=25> <input type=submit name=submit class=btn></p>
</form>
<?php
}
?>
