<?php
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_ADMINISTRATOR)
stderr("Sorry", "Access denied.");
stdhead("Add Upload", false);
?>
<table class=main width=737 border=0 cellspacing=0 cellpadding=0><tr><td class=embedded>
<div align=center>
<h1><?php echo $lang_amountupload['head_add_upload']?></a></h1>
<form method=post action=takeamountupload.php>
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
if ($_GET["sent"] == 1) {
?>
<tr><td colspan=2 class="text" align="center"><font color=red><b><?php echo $lang_amountupload['text_add_done']?></font></b></tr></td>
<?php
}
?>
<tr><td class="rowhead" valign="top"><?php echo $lang_amountupload['text_amount']?></td><td class="rowfollow"><input type=text name=amount size=10><?php echo $lang_amountupload['text_unit']?></td></tr>
<tr>
<td class="rowhead" valign="top"><?php echo $lang_amountupload['text_usergroup']?></td><td class="rowfollow">
  <table style="border: 0" width="100%" cellpadding="0" cellspacing="0">
    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="0">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_peasant']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="1">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="2">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_power_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="3">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_elite_user']?></td>
      </tr>
    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="4">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_crazy_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="5">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_insane_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="6">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_veteran_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="7">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_extreme_user']?></td>
      </tr>

    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="8">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_ultimate_user']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="9">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_nexus_master']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="10">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_vip']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="11">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_uploader']?></td>
      </tr>

    <tr>
             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="12">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_moderators']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="13">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_administrators']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="14">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_sysops']?></td>

             <td style="border: 0" width="20"><input type="checkbox" name="clases[]" value="15">
             </td>
             <td style="border: 0"><?php echo $lang_functions['text_staff_leader']?></td>
	
       <td style="border: 0">&nbsp;</td>
       <td style="border: 0">&nbsp;</td>
      </tr>
    </table>
  </td>
</tr>
<tr><td class="rowhead" valign="top"><?php echo $lang_amountupload['text_subject']?></td><td class="rowfollow"><input type=text name=subject size=82></td></tr>
<tr><td class="rowhead" valign="top"><?php echo $lang_amountupload['text_reason']?></td><td class="rowfollow"><textarea name=msg cols=80 rows=5><?php echo $body?></textarea></td></tr>
<tr>
<td class="rowfollow" colspan=2><div align="center"><b><?php echo $lang_amountupload['text_operator']?></b>
<?php echo $CURUSER['username']?>
<input name="sender" type="radio" value="self" checked>
&nbsp; System
<input name="sender" type="radio" value="system">
</div></td></tr>
<tr><td class="rowfollow" colspan=2 align=center><input type=submit value="<?php echo $lang_amountupload['submit_do']?>" class=btn></td></tr>
</table>
<input type=hidden name=receiver value=<?php echo $receiver?>>
</form>

 </div></td></tr></table>
<br />
<?php echo $lang_amountupload['text_note']?>
<?php
stdfoot();
