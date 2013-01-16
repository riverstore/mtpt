<?php
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_SYSOP)
stderr("Sorry", "Access denied.");
stdhead("Add Upload", false);
?>
<table class=main width=737 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
<div align=center>
<h1><?php echo $lang_searchuser['head_search']?></a></h1>
<form method=post action=searchuser.php>
<?php

if ($_GET["returnto"] || $_SERVER["HTTP_REFERER"])
{
?>
<input type=hidden name=returnto value="<?php echo htmlspecialchars($_GET["returnto"]) ? htmlspecialchars($_GET["returnto"]) : htmlspecialchars($_SERVER["HTTP_REFERER"])?>">
<?php
}
?>
<table cellspacing=0 cellpadding=5>
<?php
if (isset($_POST["sear"]) && !empty($_POST["sear"])) {
$username = explode(";",$_POST["username"]);
$clases = $_POST["clases"];
for($i=0;$username[$i];$i++){
$res = sql_query("SELECT * FROM users WHERE username like '%".mysql_real_escape_string($username[$i])."%'");
while($a = mysql_fetch_assoc($res)){
$count++;
?>
<tr><td colspan=2 class="text" width="300" align="left"><b><a href=userdetails.php?id=<?=$a["id"]?>><?=$a["username"]?></a></b></td></tr>
<? }}
for($i=0;$clases[$i];$i++){
$res = sql_query("SELECT * FROM users WHERE class = '".mysql_real_escape_string($clases[$i])."'");
while($a = mysql_fetch_assoc($res)){
$count++;
?>
<tr><td colspan=2 class="text" width="300" align="left"><b><a href=userdetails.php?id=<?=$a["id"]?>><?=$a["username"]?></a></b></td></tr>
<? }}
if($count<=0){ ?>
<tr><td colspan=2 class="text" width="300" align="left"><b><?php echo $lang_searchuser['text_noresult']?></b></td></tr>
<? } ?>
<tr><td><p align=center><a href=searchuser.php><?php echo $lang_searchuser['submit_return']?></a></p></td></tr>
<tr><td>
</td></tr>
<? }else{ ?>
<tr><td class="rowhead" valign="top"><?php echo $lang_searchuser['text_username']?></td><td class="rowfollow"><input type=text name=username size=20><?php echo $lang_searchuser['text_notice']?></td></tr>
<tr>
<td class="rowhead" valign="top"><?php echo $lang_searchuser['text_usergroup']?></td><td class="rowfollow">
  <table style="border: 0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="1">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_peasant']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="2">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="3">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_power_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="4">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_elite_user']?></td>
      </tr>
    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="5">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_crazy_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="6">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_insane_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="7">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_veteran_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="8">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_extreme_user']?></td>
      </tr>

    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="9">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_ultimate_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="10">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_nexus_master']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="11">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_vip']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="12">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_uploader']?></td>
      </tr>

    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="13">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_moderators']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="14">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_administrators']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="15">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_sysops']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="16">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_staff_leader']?></td>
	
       <td style="border: 0">&nbsp;</td>
       <td style="border: 0">&nbsp;</td>
      </tr>
    </table>
  </td>
</tr>
<tr><td class="rowfollow" colspan=2 align=center>
<input name="sear" type="hidden" value="1" />
<input type=submit value="<?php echo $lang_searchuser['submit_search']?>" class=btn></td></tr>
</table>
<? } ?>
</form>

 </div></td></tr></table>
<br />
<?php
stdfoot();
