<?php

define('SYSTEM_DIR', '../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');

$installdate = strtotime($GLOBALS['main']['installDate']);

?>

<!DOCTYPE> 
<html>
	<head> 
		<title>RTVUitzendingen - <?php print $GLOBALS['main']['broadcaster']; ?></title>
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
		<script type="text/javascript" src="./scripts/jquery-1.6.1.min.js">
		</script>
		<script type="text/javascript" src="./scripts/jquery.popupWindow.js">
		</script>
	</head>
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

				<p>
					<span>&bull; RTV Uitzendingen &bull;</span>
				</p>
			

				<table  cellpadding="0" width="60%"> 
					<colgroup>
						<col width="50%" />
						<col />
					</colgroup>
					<tr>
						<Td colspan="2">
							<b>Selecteer een radioprogramma.</b>
						</td>
					</tr> 
					

					<?php
					foreach (ProgramFunctions::GetProgramsByOnDemand() as $value)
					{ if ($value->programname != "") { ?>
						<tr>
							<td> 			
								&bull;&#32;<a href="program.php?programid=<?php print $value->id; ?>"><?php print $value->programname; ?></a> 
							</td> 
							<td>
								<i><?php print RTVUitzendingen::DayofWeekNL($value->day); ?>, &#32;<?php print $value->starttime; ?> tot <?php
								print ProgramFunctions::GetEndTimeOfProgram($value->id); ?> uur</i>
						</tr> <?php }
					} ?>
					</tr>
				</table>

				<p><hr/></p>

				<table width="95%">
					<colgroup>
						<col />
						<col />
					</colgroup>
				<?php
					
					
					foreach (ProgramFunctions::GetProgramsByOnDemand() as $value)
					{
						// head ?>
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
										<b><?php print $value->programname; ?></b>&nbsp;<a href="programxml.php?programid=<?php print $value->id ?>"><img src="./images/rss.png" width="24" height="25" alt="rss" /></a>
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
							$nextprogram = strtotime("+".($value->ondemand_weeks)." week", $stopday); ?>
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
											<a href="listen.php?<?php print $f; ?>" class="player"><?php print (date('H:i', $hour)." uur"); ?></a>&#32;<img src="images/new.gif" alt="Nieuw programma"> <?php
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
											<a href="listen.php?<?php print $f; ?>" class="player"><?php print (date('H:i', $hour)." uur"); ?></a>
										 <?php
									}	?>
									</td>
								</tr> <?php
								// next week
								$day = strtotime("-1 week", $day); 
							}  
						}

					}
				?>
				</table>

					
				</td>

				<td></td>

				<td style="border-left: 2px solid #000000;">
					<br/>
				</td>
			</tr>
		</table>
		
		<a href="" class="startplayer"></a>

		<script type="text/javascript"> 
		

		$('.player').live('click', function() {
		   
			var thelink = $(this);
		  
		   	<?php
			if ($GLOBALS['main']['defaultdistribution'] == "html5") { ?>			
				
				var hreflink = thelink.attr('href');
				$('.startplayer').attr('href', hreflink);
				$('.startplayer').popupWindow({ 
					height:290, 
					width:425,
				 centerBrowser:1
				}); 
			   $('.startplayer').click();
			   $('.startplayer').unbind();
			   return false;  <?php
			} 
		   ?>
		   
		});

		</script>

	</body>
</html>
