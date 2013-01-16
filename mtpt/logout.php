<?php
require_once("include/bittorrent.php");
dbconn();
if($_SERVER['REQUEST_URI']=='/logout.php')logoutcookie();
//logoutsession();
//header("Refresh: 0; url=./");
Header("Location: " . get_protocol_prefix() . "$BASEURL/");
?>
