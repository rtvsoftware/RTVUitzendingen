<?php

// Een XML bestand welke laat zien welk radioprogramma nu bezig is, 
// en wat daarna komt.

define('SYSTEM_DIR', '../../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');



header("content-type:text/xml"); 
ob_clean();
print '<?xml version="1.0" ?>';


print "<NowNextProgram>";

$i = 0;
foreach(ProgramFunctions::GetNowAndNextPrograms(time(), 2) as $value)
{
	if ($i == 0)
	{
		print "<now>";
		print "<program>".$value->programname."</program>";
		print "<starttime>".$value->starttime."</starttime>";
		print "<info>".$value->information."</info>";
		print "<image>".$urlroot."/image.php?id=".$value->id."</image>";
		print "</now>";
		$i++;
	}
	else
	{
		print "<next>";
		print "<program>".$value->programname."</program>";
		print "<starttime>".$value->starttime."</starttime>";
		print "<info>".$value->information."</info>";
		print "<image>".$urlroot."/image.php?id=".$value->id."</image>";
		print "</next>";
	}
} 
print "</NowNextProgram>";



?>