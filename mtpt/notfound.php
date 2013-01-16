//<?php
// Set this for easier access 
$url = substr($REQUEST_URI,1); 

// Strip parameters 
if (($pos = strpos($url,"?"))>0) 
{ 
    $url_parameters = substr($url, $pos+1); 
    $url = substr($url, 0, $pos); 
} 
$url = trim(strtolower($url)); 

// Strip prefix and suffix '/' 
if ($url[0]=='/') $url = substr($url,1); 
if (strlen($url)>1) 
if ($url[strlen($url)-1]=='/') $url = substr($url, 0, strlen($url)-1); 

// If url starts with .. it's a hack attempt 
if (Strcasecmp(substr($url,0,2),"..")==0) 
{ 
  $url = str_replace("..","",$url); 
} 

// If we have a php script with this name 
if (file_exists($url.".php")) 
{ 
  // Set PHP_SELF and REQUEST_URI to point to the real script 
  $_SERVER['PHP_SELF'] = $PHP_SELF = $_SERVER['REQUEST_URI'] = $REQUEST_URI = "/".$url; 
  if (!empty($url_parameters)) $_SERVER['REQUEST_URI'] = $REQUEST_URI .= "?".$url_parameters; 

  // Load real php script 
  require($DOCUMENT_ROOT."/$url.php"); 
  return; 
}
//?>
