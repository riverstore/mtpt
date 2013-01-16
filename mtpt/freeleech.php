<?php
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_ADMINISTRATOR)
	stderr("Error", "Permission denied.");

$action = isset($_POST['action']) ? htmlspecialchars($_POST['action']) : (isset($_GET['action']) ? htmlspecialchars($_GET['action']) : 'main');
if ($action == 'setallfree')
{
	sql_query("UPDATE torrents_state SET global_sp_state = 2");
	$Cache->delete_value('global_promotion_state');
	stderr('Success','All torrents have been set free..');
}
elseif ($action == 'setall2up')
{
	sql_query("UPDATE torrents_state SET global_sp_state = 3");
	$Cache->delete_value('global_promotion_state');
	stderr('Success','All torrents have been set 2x up..');
}
elseif ($action == 'setall2up_free')
{
	sql_query("UPDATE torrents_state SET global_sp_state = 4");
	$Cache->delete_value('global_promotion_state');
	stderr('Success','All torrents have been set 2x up and free..');
}
elseif ($action == 'setallhalf_down')
{
	sql_query("UPDATE torrents_state SET global_sp_state = 5");
	$Cache->delete_value('global_promotion_state');
	stderr('Success','All torrents have been set half down..');
}
elseif ($action == 'setall2up_half_down')
{
	sql_query("UPDATE torrents_state SET global_sp_state = 6");
	$Cache->delete_value('global_promotion_state');
	stderr('Success','All torrents have been set half down..');
}
elseif ($action == 'setallnormal') 
{
	sql_query("UPDATE torrents_state SET global_sp_state = 1");
	$Cache->delete_value('global_promotion_state');
	stderr('Success','All torrents have been set normal..');
}
elseif ($action == 'main')
{
	stderr($lang_freeleech['head_freeleech'],$lang_freeleech['text_free'].' <a class=altlink href=freeleech.php?action=setallfree>'.$lang_freeleech['text_go'].'</a> <br />'.$lang_freeleech['text_2xup'].' <a class=altlink href=freeleech.php?action=setall2up>'.$lang_freeleech['text_go'].'</a><br />'.$lang_freeleech['text_2xup_free'].' <a class=altlink href=freeleech.php?action=setall2up_free>'.$lang_freeleech['text_go'].'</a><br />'.$lang_freeleech['text_halfdown'].'<a class=altlink href=freeleech.php?action=setallhalf_down>'.$lang_freeleech['text_go'].'</a><br />'.$lang_freeleech['text_2xup_halfdown'].'<a class=altlink href=freeleech.php?action=setall2up_half_down>'.$lang_freeleech['text_go'].'</a><br />'.$lang_freeleech['text_normal'].'<a class=altlink href=freeleech.php?action=setallnormal>'.$lang_freeleech['text_go'].'</a>', false);
}
?>
