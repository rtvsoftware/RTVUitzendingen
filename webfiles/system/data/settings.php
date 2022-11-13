<?php

// Een XML bestand welke laat zien welk radioprogramma nu bezig is, 
// en wat daarna komt.

define('SYSTEM_DIR', '../../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');



header("content-type:text/xml"); 
ob_clean();
print '<?xml version="1.0" ?>';


print "<RTVUitzendingen>";
print "<Settings>";

$i = 0;
foreach($GLOBALS['main'] as $key => $value)
{
	print "<Setting name=\"".$key."\">";
	print $value;
	print "</Setting>";

} 
print "</Settings>";
print "</RTVUitzendingen>";



?>