<?php

define('SYSTEM_DIR', '../../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');

header("content-type:application/json"); 
if ($_GET['callback']) {
        print $_GET['callback']."(";
    }
print '{';



$newprogram = "";


$i = 0;
foreach(ProgramFunctions::GetNowAndNextPrograms(time(), 2) as $value)
{
	if ($i == 0)
	{
		print "\"now\": {";
		print "\"program\": \"".trim($value->programname) . "\",";
		print "\"starttime\": \"".trim($value->starttime) . "\",";
		print "\"info\": \"".trim($value->information) . "\",";
		print "\"info\": \"".$urlroot."/image.php?id=".$value->id . "\"";
		print "},";
		
		$i++;
	}
	else
	{
		
		print "\"next\": {";
		print "\"program\": \"".trim($value->programname) . "\",";
		print "\"starttime\": \"".trim($value->starttime) . "\",";
		print "\"info\": \"".trim($value->information). "\",";
		print "\"info\": \"".$urlroot."/image.php?id=".$value->id . "\"";
		print "}";

	}
} 

print "}";
if ($_GET['callback']) {
        print ")";
    }

?>