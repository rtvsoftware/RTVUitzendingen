<?php

define('SYSTEM_DIR', '../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');

$installdate = strtotime( $GLOBALS['main']['installDate']);


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
	
	<head> 
		<title>Uitzending Gemist::programma - <?php print $GLOBALS['main']['broadcaster']; ?></title>
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<style>
			body
			{
				font-family:			verdana, sans-serif;
				font-size:				11px;
			}
			INPUT.text
			{	
				font-family:		verdana, sans-serif;
				font-size:			11px;
				border-style:		solid;
				border-width:		1px;
				border-color:		black;
				background-color:	white;
				color:				black;
				width:				50%;
			}
			INPUT.password
			{	
				font-family:		verdana, sans-serif;
				font-size:			11px;
				border-style:		solid;
				border-width:		1px;
				border-color:		black;
				background-color:	white;
				color:				black;
				width:				25%;
			}
			INPUT.check
			{	
				font-family:		verdana, sans-serif;
				font-size:			12px;
			}
			IMG
			{
				border-style:		none;
			}
		</style>
	</head>
	<body>

<body>

		<table width="100%">
			<colgroup>
				<col width="50px" />
				<col width="5px" />
				<col />
				<col width="5px" />
				<col width="50px" />
			</colgroup>
			<tr>
				<td style="border-right: 2px solid #000000;">
					<br/>
				</td>

				<td></td>

				<td>

					<!-- boventitel -->
					<p>
						<span>&bull; Uitzending gemist &bull;</span>
					</p>


					<table width="95%">
						<colgroup>
							<col width="25%">
							<col />
						</colgroup>
					<?php
	
						$value = ProgramFunctions::GetProgramOnDemand($_GET['programid']);
						
						if ($value->id == 0)
						{
							header("Location: index.php");
							exit;
						} ?>
						<tr>
							<td colspan="2">
								<p><br/></p>
								<table width="100%">
									<colgroup>
										<col width="10%" />
										<col width="60%" />
										<col width="30%" />
									</colgroup>
								<tr>
									<td>
										<a name="<?php print $value->programname; ?>"></a><img src="images/speaker.gif" alt="uitzending gemist">
									</td>
									<td>
										<b><?php print $value->programname; ?></b>
									</td>
									<td style="text-align:left">
										<i><?php print RTVUitzendingen::DayofWeekNL($value->day); ?>&#32;<?php print $value->starttime; ?> tot <?php
										print ProgramFunctions::GetEndTimeOfProgram($value->id); ?> uur
									</td>
								</tr>
								</table>
							</td>
						</tr>  <?php

						$wk = 1;

						if ($value->ondemand_startdate > time())
						{
							$nextprogram = strtotime("+".($value->ondemand_weeks)." week", time()); ?>
							<tr><td colspan="2">Uitzendingen van dit programma zullen vanaf <?php print strftime("%d/%m/%Y", $value->ondemand_startdate); ?> beschikbaar zijn.</td></tr> <?php
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
								?>
								<tr>
									<td> <?php
										print strftime("%A", $day). " " .strftime("%d", $day)." ".strftime("%B", $day)." '".strftime("%y",$day); ?>
									</td>
									<td> <?php
									// all hours 
									for ($i=0; $i<ProgramFunctions::getHoursOfProgram($value->id, $day); $i++)
									{
										$hour = mktime(substr($value->starttime, 0, 2)+$i, substr($value->starttime, 3, 2), 0, date('n', $day), date('j', $day), date('Y', $day));
										// Wait time
										$chktime = strtotime("+".$GLOBALS['main']['waitminutes']." minute", $hour);
										$chktime = strtotime("+1 hour", $chktime);
										if ($chktime<$day)
										{
											$f = $value->CreateFile(date('G', $hour), $day); ?>
											&bull;&#32;
											<a href="listen.php?<?php print $f; ?>"><?php print (date('H:i', $hour)." uur"); ?></a>&#32;<img src="images/new.gif" alt="Nieuw programma"> <?php
										}
										else
										{
											$f = $value->CreateFile(date('G', $hour), $day); ?>
											&bull;&#32;
												<span title="Vanaf <?php print date('H:i', $chktime) ?>u beschikbaar."><?php print  (date('H:i', $hour))." uur"; ?></span>
											<?php
										}
									}	?>
									</td>
								</tr> <?php
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
								$wk++; 	?>
								<tr>
									<td> <?php
										print strftime("%A", $day). " " .strftime("%d", $day)." ".strftime("%B", $day)." '".strftime("%y",$day); ?>
									</td>
									<td> <?php
									// all hours 
									for ($i=0; $i<ProgramFunctions::getHoursOfProgram($value->id, $day); $i++)
									{
										$hour = mktime(substr($value->starttime, 0, 2)+$i, substr($value->starttime, 3, 2), 0, date('n', $day), date('j', $day), date('Y', $day));
										$f = $value->CreateFile(date('G', $hour), $day);?>
										&bull;&#32;
											<a href="listen.php?<?php print $f; ?>"><?php print (date('H:i', $hour)." uur"); ?></a>
										 <?php
									}	?>
									</td>
								</tr> <?php
								// next week
								$day = strtotime("-1 week", $day); 
							}  
						}
				?>
					</table>

					<p>
						&bull;&#32;<a href="index.php">Lijst alle uitzendingen gemist</a>
					</p>

					
				</td>

				<td></td>

				<td style="border-left: 2px solid #000000;">
					<br/>
				</td>
			</tr>
		</table>

	</body>
</html>
