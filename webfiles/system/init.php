<?php

// Version
$version = '3.7';

// Time zone and culture
date_default_timezone_set('Europe/Amsterdam');
setlocale(LC_ALL, 'nld_nld');

// Variables
$config  = SYSTEM_DIR.'/config/config.php';

// Start caching before output to client
ob_start();

// Register the function when ending loading the page
register_shutdown_function('Ending_Page');

// Check files
if (!file_exists($config))
{
	print '<b>Error #FIE0011<b> File not found: '.$config;
	exit;
}

// Database configuration
require($config);
require(SYSTEM_DIR.'/tables.php');

// image
if (isset($images) && substr($images, strlen($images)-1) != DIRECTORY_SEPARATOR) 
	$images .= DIRECTORY_SEPARATOR;

// Classes
if ($handle = @opendir(SYSTEM_DIR.'/classes'))
{
	while (false !== ($file = readdir($handle))) 
	{ 
		if (substr($file,-4) == ".php" && substr($file,0,1)!="$")
		   include(SYSTEM_DIR.'/classes/'.$file);
	}
	closedir($handle);
}

// Start session
session_start();

// ===== mySql Connection  ======
// -- BEGIN SSL -- Gebruik hieronder de volgende regels voor MySql SSL connectie
//$cert = ''; // Locatie SSL Certificaat
//$GLOBALS['mysql']  = mysqli_init();
//mysqli_ssl_set($GLOBALS['mysql'] ,NULL,NULL, SYSTEM_DIR.$cert, NULL, NULL) ; 
//mysqli_real_connect($GLOBALS['mysql'], $dbhost, $dbuser, $dbpasswd, $dbname, 3306, MYSQLI_CLIENT_SSL);
//if (mysqli_connect_errno($GLOBALS['mysql'] )) 
//{
//	print "<b>Error #DBE0011</b> Cannot connect with database. Check the config.php.";
//	exit;
//}
// -- END SSL --

// mySql Connection
$GLOBALS['mysql'] = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname);
if ($GLOBALS['mysql']->connect_error)
{
	print "<b>Error #DBE0011</b> Cannot connect with database. Check the config.php.";
	exit;
}

// Read global settings
$res = $GLOBALS['mysql']->query('SElECT name, value FROM '.$GLOBALS['table']['main']);
while ($row = $res->fetch_assoc()) {
	$GLOBALS['main'][$row['name']] = $row['value'];
}


// By ending of loading a page.
function Ending_Page()
{
	// closing datbaase
	if ($GLOBALS['mysql']) 
		$GLOBALS['mysql']->close();

	// output the buffer to the client
	@ob_end_flush();
}

