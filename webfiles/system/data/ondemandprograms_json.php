
<?php

define('SYSTEM_DIR', '../../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');
header("content-type:application/json"); 

setlocale(LC_ALL, 'nl_NL');

$url = $GLOBALS['main']['urlprograms'];
if (substr($url, -1) != "/")
	$url .= "/";

print '{';

print '"programs": [';
$first = 1;

foreach (ProgramFunctions::GetProgramsByOnDemand() as $value)
{
	$id = $value->id;
	$programname = $value->programname;
	$totalhours = ProgramFunctions::getHoursOfProgram($value->id, $value->day);
	$totalweeks = $value->ondemand_weeks;
	$dayweek = $value->day;
	$starthour = intval(substr($value->starttime,0,2));
	
	if ($first == 0) print ",";
	print "{"; 
	print '"id":"'.$id.'",';
	print '"programname":'.json_encode($programname).',';

	print '"weeks": [';
	{
		$broadcasttime = new DateTime();
			
		while ($broadcasttime->format('w') != $dayweek)
		{
			$broadcasttime->modify('-24 hours');
		}

		for ($week=1; $week<=$totalweeks; $week++) 
		{
			if ($week>1) print ",";
			print '{';

			if ($week>1)
				$broadcasttime->modify('-7 days');
			
			print '"date": "'.strftime('%A %e %B %Y', $broadcasttime->format('U')).'",';
			print '"weeknr": "'.$week.'",';
			print '"datehour": [';
			{
				for ($hour=1; $hour<=$totalhours; $hour++)
				{
					if ($hour>1) print ",";
					print '{';
					$broadcasttime->setTime($starthour+($hour-1), 0,0);
					$h = date_format($broadcasttime, 'H');
					print '"broadcasttime":"'.$h.':00",';
					print '"hour":"'.$hour.'",';
					print '"timestamp":"'.$broadcasttime->getTimestamp().'",';
					$audiofile = strftime('%d%m%Y%H', $broadcasttime->format('U'))."00.mp3";
					print '"url":"'.$url.$id.'/'.$audiofile.'",';
					$available = new DateTime();
					$available->modify('+30 minutes');
					$isavailable = $broadcasttime < $available ? "1" : "0";
					print '"available":"'.$isavailable .'"';
					print '}';				
				}
			}
			print ']';
			print '}';
		}
	}
	print ']';
	print "}";

	$first =0;
}

print ']';
print "}";

?>
