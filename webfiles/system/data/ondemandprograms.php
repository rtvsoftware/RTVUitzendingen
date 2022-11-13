<?php

define('SYSTEM_DIR', '../../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');

if (isset($_GET['xml']))
{
	header("content-type:text/xml"); 
	ob_clean();
	print '<?xml version="1.0" encoding="ISO-8859-15" ?>';


	print "<OnDemand status=\"True\">";

	foreach (ProgramFunctions::GetProgramsByOnDemand() as $value)
	{
		print "<Program id=\"".$value->id."\">";

		print "<Hours>".ProgramFunctions::getHoursOfProgram($value->id, $value->day)."</Hours>";
		print "<Day>".$value->day."</Day>";
		print "<Starttime>".$value->starttime."</Starttime>";
		print "<Weeks>".$value->ondemand_weeks."</Weeks>";
		print "<ProgramName><![CDATA[".$value->programname."]]></ProgramName>";

		print "</Program>";
	}
	print "</OnDemand>";
}
else if (isset($_GET['testconnection']))
{
	header("content-type:text/xml"); 
	ob_clean();
	print '<?xml version="1.0" encoding="ISO-8859-15" ?>';

	print "<OnDemand status=\"True\" />";
}
else
{ ?>

	<html>
		<head><title></title></head>
		<body>
			<p>Dit is het Internet adres voor de koppeling met de applicatie tool.</p>
			<p>Kopieer het Internet adres naar dit bestand naar de applicatie tool.</p>
		</body>
	</html>
<?php
}
?>