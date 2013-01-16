<?php
if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"])
{
$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"];
}
elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"])
{
$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"];
}
elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"])
{
$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"];
}
elseif (getenv("HTTP_X_FORWARDED_FOR"))
{
$ip = getenv("HTTP_X_FORWARDED_FOR");
}
elseif (getenv("HTTP_CLIENT_IP"))
{
$ip = getenv("HTTP_CLIENT_IP");
}
elseif (getenv("REMOTE_ADDR"))
{
$ip = getenv("REMOTE_ADDR");
}
else
{
$ip = "Unknown";
}
echo "您的IP是:".$ip ;
$len=strlen($ip);
if ($len>15)
{
echo "<br>您当前正在使用IPV6访问";
}
else 
{
echo "<br>您当前正在使用IPV4访问";
}
?>
