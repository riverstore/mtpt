<?php
session_start();
define('IN_TRACKER', true);
define("PROJECTNAME","MTPT");
define("NEXUSPHPURL","http://pt.nwsuaf6.edu.cn");
define("NEXUSWIKIURL","http://pt.nwsuaf6.edu.cn");
define("VERSION","Powered by <a href=\"aboutmtpt.php\">".PROJECTNAME."</a>");
define("THISTRACKER","General");
$showversion = " - Powered by ".PROJECTNAME;
$rootpath=realpath(dirname(__FILE__) . '/..');
set_include_path(get_include_path() . PATH_SEPARATOR . $rootpath);
$rootpath .= "/";
include($rootpath . 'include/core.php');
include_once($rootpath . 'include/functions.php');
