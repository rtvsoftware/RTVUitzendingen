<?php

// XML bestand met programmering
// Er kan een GET-parameter aan het URL worden meegegeven voor filtering per dag
// name=day, value = 0 ... 6 waarbij 0 = zondag en 6 zaterdag
define('SYSTEM_DIR', '../../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');



header("content-type:text/xml"); 
ob_clean();
print '<?xml version="1.0" ?>';


print "<programming>";

if (isset($_GET['day']) && intval($_GET['day']) > 0)
{
	$day = $_GET['day'];
	if ($day >=0 && $day <= 6)
	{
		$startday = $day;
		$endday = $day;
	}
	else
	{
		$startday = 0;
		$endday = 6;
	}
}
else
{
	$startday = 0;
	$endday = 6;
}

for ($i = $startday; $i <= $endday; $i++)
{
	print "<day id=\"".$i."\">";
	foreach(ProgramFunctions::GetProgrammingOfDay($i) as $value)
	{
		print "<program>";
		print "<name>".$value->programname."</name>";
		print "<starttime>".$value->starttime."</starttime>";
		if ($value->information != "")
			print "<information><![CDATA[".$value->information."]]></information>";
		else
			print "<information />";
		if ($value->email != "")
			print "<email>".$value->email."</email>";
		else
			print "<email />";
		if ($value->website != "")
			print "<website>".$value->website."</website>";
		else
			print "<website />";
		print "<image>".$urlroot."/image.php?id=".$value->id."</image>";
		print "</program>";
	}
	print "</day>";
}

print "</programming>";



?>