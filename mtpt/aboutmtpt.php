<?php
require "include/bittorrent.php";
dbconn();

stdhead(PROJECTNAME);
print ("<h1>".PROJECTNAME."</h1>");
begin_main_frame();

print("<h1 align=center><a href=http://code.google.com/p/mtpt/ target=_blank>MTPT</a>  modified from <a href=http://sourceforge.net/projects/nexusphp/ target=_blank>Nexusphp</a><br />By 独行虾,星星 from<a href=http://www.xnlinux.cn target=_blank> XNLUG</a></h1>");
end_main_frame();
stdfoot();  
?>
