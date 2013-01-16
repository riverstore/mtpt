<?
$aaa = "[img]http://pt.nwsuaf6.edu.cn/mybar.php?userid=208.png[/img]";
//echo TestIMG($aaa);
if(!TestIMG($aaa)) die;
echo $aaa;
function TestIMG($value){
preg_match_all('/\[img=(.*?)\]/',$value,$temp1);
foreach($temp1[1] as $temp11){
	preg_match_all('/(.*?).php/',$temp11,$temp2);
	foreach($temp2[1] as $temp22){
		if(strlen($temp22)>0 && substr(strrev($temp22),0,5) != "rabym") //mybar
			return false;
	}
}
preg_match_all('/\[img\](.*?)\[\/img\]/',$value,$temp1);
foreach($temp1[1] as $temp11){
	preg_match_all('/(.*?).php/',$temp11,$temp2);
	foreach($temp2[1] as $temp22){
		if(strlen($temp22)>0 && substr(strrev($temp22),0,5) != "rabym") //mybar
			return false;
	}
}
return $value;
}
?>
