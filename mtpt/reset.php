<?php
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
// Reset Lost Password ACTION
if (get_user_class() < UC_ADMINISTRATOR)
stderr("Error", "Permission denied, Administrator Only.");

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
 $username = trim($_POST["username"]);
 $newpassword = trim($_POST["newpassword"]);
 $newpasswordagain = trim($_POST["newpasswordagain"]);
 
 if (empty($username) || empty($newpassword) || empty($newpasswordagain))
	stderr("Error","Don't leave any fields blank.");

 if ($newpassword != $newpasswordagain)
	stderr("Error","The passwords didn't match! Must've typoed. Try again.");

 if (strlen($newpassword) < 6)
	stderr("Error","Sorry, password is too short (min is 6 chars)");
	
   $res = sql_query("SELECT * FROM users WHERE username=" . sqlesc($username) . " ") or sqlerr();
$arr = mysql_fetch_assoc($res);


$id = $arr['id'];
$wantpassword=$newpassword;
$secret = mksecret();
$wantpasshash = md5($secret . $wantpassword . $secret);
sql_query("UPDATE users SET passhash=".sqlesc($wantpasshash).", secret= ".sqlesc($secret)." where id=$id");
write_log("Password Reset For $username by $CURUSER[username]");
 if (mysql_affected_rows() != 1)
   stderr("Error", "Unable to RESET PASSWORD on this account.");
 stderr("Success", "The password of account <b>$username</b> is reset , please inform user of this change.",false);
}
stdhead("Reset User's Lost Password");
?>
<table border=1 cellspacing=0 cellpadding=5>
<form method=post>
<tr><td class=colhead align="center" colspan=2><?php echo $lang_reset['head_reset']?></td></tr>
<tr><td class=rowhead align="right"><?php echo $lang_reset['text_username']?></td><td class=rowfollow><input size=40 name=username></td></tr>
<tr><td class=rowhead align="right"><?php echo $lang_reset['text_passwd']?></td><td class=rowfollow><input type="password" size=40 name=newpassword><br /><font class=small><?php echo $lang_reset['text_minimum']?></font></td></tr>
<tr><td class=rowhead align="right"><?php echo $lang_reset['text_repasswd']?></td><td class=rowfollow><input type="password" size=40 name=newpasswordagain></td></tr>
<tr><td class=toolbox colspan=2 align="center"><input type=submit class=btn value='<?php echo $lang_reset['submit_reset']?>'></td></tr>
</form>
</table>
<?php
stdfoot();
