<?php

// 
// Pas deze variabel aan met de absolute verwijzing naar het bestand 'listen.php'
//
$listen = "http://.../uitzendinggemist/listen.php";


define('SYSTEM_DIR', '../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');


$installdate = strtotime( $GLOBALS['main']['installDate']);

if (intval($_GET['programid']) == 0)

{

	header("Location: index.php");

	exit;

}

ob_clean();
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";



?>
<rss version="2.0">
<channel>
<?php

	

						$value = ProgramFunctions::GetProgramOnDemand($_GET['programid']);

						if ($value->id == 0)

						{

							exit;

						} ?>
<title><?php print $value->programname; ?></title>
<link><?php print $GLOBALS['main']['url']; ?></link>
<description><?php print $value->information; ?></description>
<lastBuildDate><?php print $GLOBALS['main']['updateprogram']; ?></lastBuildDate>
<?php
						$wk = 1;



						if ($value->ondemand_startdate > time())

						{

							$nextprogram = strtotime("+".($value->ondemand_weeks)." week", time());
							 ?><?php

						}

						else

						{

							// today?

							$day = time();

							if (date('w', $day) == $value->day)

							{  

								$programtoday = 1;

								$wk ++;

								// uitrekenen of er al een uur beschikbaar kan zijn

								?><?php

									// all hours 

									for ($i=0; $i<ProgramFunctions::getHoursOfProgram($value->id, $day); $i++)

									{

										$hour = mktime(substr($value->starttime, 0, 2)+$i, substr($value->starttime, 3, 2), 0, date('n', $day), date('j', $day), date('Y', $day));

										// Wait time

										$chktime = strtotime("+".$GLOBALS['main']['waitminutes']." minute", $hour);

										$chktime = strtotime("+1 hour", $chktime);

										if ($chktime<$day)

										{

											$f = $value->CreateFile(date('G', $hour), $day); ?><item><title><?php print $value->programname; ?></title><description><?php print $value->information; ?></description><pubDate><?php print date("c",$hour); ?></pubDate><link><![CDATA[<?php print $listen; ?>?<?php print $f; ?>]]></link></item><?php

										}

										else

										{

											$f = $value->CreateFile(date('G', $hour), $day); 
											?><?php

										}

									}	?><?php

							}

							else

							{

								$programtoday = 0;

							}





							$day = strtotime("last ".RTVUitzendingen::DayofWeekEN($value->day), time());

							$day = strtotime("+1 hour" ,$day);	

							$stopday = strtotime("-".($value->ondemand_weeks-1)." week", $day);

							if ($stopday < $value->ondemand_startdate)

								$stopday = $value->ondemand_startdate;

						

							while ($day>=$stopday && $wk<=$value->ondemand_weeks)

							{  

								$wk++; 	?><?php

									// all hours 

									for ($i=0; $i<ProgramFunctions::getHoursOfProgram($value->id, $day); $i++)

									{

										$hour = mktime(substr($value->starttime, 0, 2)+$i, substr($value->starttime, 3, 2), 0, date('n', $day), date('j', $day), date('Y', $day));

										$f = $value->CreateFile(date('G', $hour), $day);?><item><title><?php print $value->programname; ?></title><description><?php print $value->information; ?></description><pubDate><?php print date("c",$hour); ?></pubDate><link><![CDATA[<?php print $listen; ?>?<?php print $f; ?>]]></link></item><?php

									}	?><?php

								// next week

								$day = strtotime("-1 week", $day); 

							}  

						}

				?></channel></rss>