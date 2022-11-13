<?php
define('SYSTEM_DIR', '../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');

?>
	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
	
	<head> 
		<title>Programmering - <?php print $GLOBALS['main']['broadcaster']; ?></title>
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
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.3/jquery.min.js"></script>
		<script type="text/javascript">
		
			$(document).ready(function() {
			
				$("a[href^='#']").click(function() {
					var showday = $("#showday").prop("checked");
					if (showday)
					{
						var day = $(this).attr('day');
						window.open("showday.php?day=" + day);
						return false;
					}
				});
				
			});
		
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

					<!-- Info tekst -->
					<p>
						<b>De programmering</b><br/>
						Hieronder wordt de hele weekprogrammering weergegeven. U kunt dit bestand gebruiken en aanpassen voor uw website.<br/>
						Zie map /programmering.
					</p>


					<p>
						

						Bekijk de programmering van:<br/> <?php
						foreach (RTVUitzendingen::Weekdays() as $key => $value)
						{
							print "&bull;&#32;<a href='#" . $value . "' day='".$key."'>".$value."</a><br/>";

						} ?>
					</p>
						
					<p>
						<input type="checkbox" id="showday" name="showday" />Open de weekdag in een aparte pagina. (zie PHP script showday.php in dze map)

					</p>

					<?php
					foreach (RTVUitzendingen::Weekdays() as $key => $value)
					{ ?>
						<table width="50%">
							<tr>
								<td colspan="4">
									<a name="<?php print $value; ?>"></a><b><?php print $value; ?></b>
								</td>
							</tr> <?php
							foreach (ProgramFunctions::GetProgrammingOfDay($key) as $value)
							{ ?>
								<tr>
									<td width="5%">
										<?php print $value->starttime; ?>
									</td>
									<td width="5%"> <?php
										if ($value->ondemand)
										{ ?>
											<a href="<?php print SYSTEM_DIR ?>../uitzendinggemist/program.php?programid=<?php print $value->id ?>" title="Beluister eerder uitgezonden afleveringen.">
											<img src="<?php print SYSTEM_DIR; ?>../uitzendinggemist/images/speaker.gif" alt="Uitzending gemist" title="Beluister eerder uitgezonden afleveringen." width="16" height="16"></a> <?php
										} ?>
									</td>
									<td>
										<?php print $value->programname; ?>
									</td>
									<td width="10%"> <?php
										if ($GLOBALS['main']['useCategorys'] == "1" && $value->category>0)
										{
											$cat = new ProgramCategory($value->category); ?>
											<div style="background-color:<?php print $cat->color; ?>" title="<?php print $cat->category; ?>"><a  href="categorys.php?show=<?php print $cat->id; ?>"><?php print $cat->shortname; ?></div> <?php
										} ?>
									</td>
								</tr> <?php
								// indien geen extra informatie, geen tr elementen plaatsen
								// anders krijg je extra enters.
								if ($value->information!="" || $value->website!="" || $value->email!="") 
								{ ?>
									<tr>
										<td></td>
										<td></td>
										<td> <?php
											if ($value->information!="")
											{
												print $value->information; ?><br /><?php
											} ?>
											<i><?php
											if ($value->website!="")
											{ ?>
												Website: <a href="<?php print $value->website; ?>" title="Klik hier om naar de website van <?php print $value->programname; ?> te gaan."><?php print $value->website; ?></a>&#32; <?php
											}
											if ($value->email!="")
											{ 
												if ($value->website!="")
													print "<br/>"; ?>

												Email: <a href="mailto:<?php print $value->email; ?>" title="Klik hier om te mailen naar <?php print $value->programname; ?>."><?php print $value->email; ?></a>&#32; <?php
											} ?>
											</i>
										</td>
										<td></td>
									</tr> <?php
								}
							} ?>
						</table>
						<p><br/></p> <?php
					} ?>

					
				</td>

				<td></td>

				<td style="border-left: 2px solid #000000;">
					<br/>
				</td>
			</tr>
		</table>

	</body>
</html>
