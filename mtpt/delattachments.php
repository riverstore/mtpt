<?php
/*
此段代码只适用于MTPT或包含有jQuery库的NexusPHP站点
*/
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_SYSOP)
	permissiondenied();
if ($_SERVER["REQUEST_METHOD"] == "POST")
{
	if ($_POST['sure'])
	{
		set_time_limit(0);
		sql_query("UPDATE attachments SET inuse = 0") or sqlerr(__FILE__, __LINE__);	//全部标记未使用
		$res = sql_query("SELECT descr FROM torrents WHERE `descr` LIKE '%attach%'") or sqlerr(__FILE__, __LINE__);	//对种子文章进行处理
		$atts = array();
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		$res = sql_query("SELECT body FROM posts WHERE `body` LIKE '%attach%'") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		$res = sql_query("SELECT descr FROM offers WHERE `descr` LIKE '%attach%'") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		$res = sql_query("SELECT text FROM comments WHERE  `text` LIKE  '%attach%'") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		
		$res = sql_query("SELECT body FROM fun WHERE  `body` LIKE  '%attach%'") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		
		$res = sql_query("SELECT msg FROM messages WHERE  `msg` LIKE  '%attach%'") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		
		$res = sql_query("SELECT msg FROM staffmessages WHERE  `msg` LIKE  '%attach%'") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		
		$res = sql_query("SELECT signature FROM users WHERE  `signature` LIKE  '%attach%'") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			$attstemp = array();
			preg_match_all('/\[attach\](.*?)\[\/attach\]/',$row[0],$attstemp);
			$atts = array_merge($atts,$attstemp[1]);
		}
		sql_query("UPDATE attachments SET inuse = 1 WHERE dlkey='".join("' OR dlkey='", $atts)."'") or sqlerr(__FILE__, __LINE__);
		$res=sql_query("SELECT count(*),SUM(filesize) AS filesizes FROM attachments WHERE inuse=0") or sqlerr(__FILE__, __LINE__);
		$row = mysql_fetch_array($res);
		$deletecount=$row[0];
		$filesizes=mksize($row[1]);
		echo "共有".$deletecount."个无用附件，总共大小：".$filesizes;
		die;
	}elseif($_POST['suredel']){
		$filepath = dirname(__FILE__)."/attachments/";
		$res = sql_query("SELECT location FROM attachments WHERE inuse = 0") or sqlerr(__FILE__, __LINE__);
		while($row = mysql_fetch_array($res)){
			if(file_exists($filepath.$row[0])){
				@unlink($filepath.$row[0]);
			}
			if(file_exists($filepath.$row[0].".thumb.jpg")){
				@unlink($filepath.$row[0].".thumb.jpg");
			}
		}
		sql_query("DELETE FROM attachments WHERE inuse = 0") or sqlerr(__FILE__, __LINE__);
	}
}
		$res=sql_query("SELECT count(*),SUM(filesize) AS filesizes FROM attachments") or sqlerr(__FILE__, __LINE__);
		$row = mysql_fetch_array($res);
		$deletecount=$row[0];
		$filesizes=mksize($row[1]);
stdhead($lang_deletedisabled['head_delete_diasabled']);
begin_main_frame();
?>
<h1 align="center"><?php echo $lang_deletedisabled['text_delete_diasabled']?></h1>
<script type="text/javascript">
$(document).ready(function(){
	$("#check").click(function(){
		$("#check").val("检测中..");
		$.post("delattachments.php",{sure:1},function(result){
			$("#check").val("检测完成");
			$("#delatt").removeAttr("disabled");
			$("#comp").html(result);
		});
	});
});
</script>
<div style="text-align: center;"><?php echo $lang_deletedisabled['text_delete_check_note']?></div>
<div style="text-align: center; margin-top: 10px;">
<input id="check" type="submit" value="<?php echo $lang_deletedisabled['submit_delete_check']?>" />
</div>
<p></p>
<div style="text-align: center;"><?php echo $lang_deletedisabled['text_delete_disabled_note']?></div>
<div style="text-align: center; margin-top: 10px;">
<form method="post" action="">
<input type="hidden" name="suredel" value="1" />
<input id="delatt" type="submit" disabled="disabled" value="<?php echo $lang_deletedisabled['submit_delete_all_disabled_users']?>" />
<?php echo "<br /><span id=\"comp\">共有".$deletecount."个附件，总共大小：".$filesizes."</span>"?>
</form>
</div>
<?php
end_main_frame();
stdfoot();
?>
