<?php
require "include/bittorrent.php";
dbconn();
loggedinorreturn();
require_once(get_langfile_path());
if (get_user_class() < UC_MODERATOR)
	stderr("Error", "Permission denied.");
$res2 = sql_query("SELECT agent,peer_id FROM peers  GROUP BY agent ") or sqlerr();
stdhead("All Clients");
print("<table align=center border=3 cellspacing=0 cellpadding=5>\n");
print("<tr><td class=colhead>".$lang_allagents['text_client']."</td><td class=colhead>".$lang_allagents['text_peerid']."</td></tr>\n");
while($arr2 = mysql_fetch_assoc($res2))
{
	print("</a></td><td align=left>$arr2[agent]</td><td align=left>$arr2[peer_id]</td></tr>\n");
}
print("</table>\n");
stdfoot();
