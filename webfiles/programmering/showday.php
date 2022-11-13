<?php
define('SYSTEM_DIR', '../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');

?>

<?php
/*
  Use this script as follow:
  
  showday.php?day=0  = Sunday
  showday.php?day=1  = Monday
  ..
  showday.php?day=6  = Saturday
*/
?>
<!DOCTYPE HTML> 
	
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

					
					
					<table width="50%">
						<tr>
							<td colspan="4">
								<b><?php print RTVUitzendingen::DayofWeekNL($_GET['day']); ?></b>
							</td>
						</tr> <?php
						foreach (ProgramFunctions::GetProgrammingOfDay($_GET['day']) as $value)
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
					<p><br/></p> 

					
				</td>

				<td></td>

				<td style="border-left: 2px solid #000000;">
					<br/>
				</td>
			</tr>
		</table>

	</body>
</html>
