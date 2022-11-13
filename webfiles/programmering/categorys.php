<?php

define('SYSTEM_DIR', '../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
	
	<head> 
		<title>Programmering::categorien - <?php print $GLOBALS['main']['broadcaster']; ?></title>
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

						<!-- Info tekst -->
						<p>
							<b>Categori�n</b><br/>
							Programma's kunnen verdeeld worden in categorie�n. Hieronder ziet u de lijst van opgegeven categorie�n. Door te klikken op een categorie ziet u de lijst van programma's die aan het categorie zijn verbonden.
						</p>
							

						<table width="50%"> <?php
							foreach (ProgramCategoryFunctions::GetAllCategorys() as $value)
							{ ?>
								<tr>
									<td width="10%">
										<div style="background-color:<?php print $value->color; ?> text-align:center;" title="<?php print $value->category; ?>"><?php print $value->shortname; ?></div>
									</td>
									<Td width="30%">
										<?php print $value->category; ?>
									</td>
									<Td>
										<a href="<?php print $_SERVER['PHP_SELF']; ?>?show=<?php print $value->id; ?>">programma's</a>
									</td>
								</tr> <?php
							} ?>
						</table>

						<?php
						if (isset($_GET['show']) && intval($_GET['show']) > 0)
						{ 
							$cat = new ProgramCategory($_GET['show']); ?>
							<p>
								<b>Programma's <?php print $cat->category; ?></b>
							</p>
							<table border="0"> <?php
								foreach (ProgramFunctions::GetProgramsByCategory($_GET['show']) as $value)
								{ ?>
									<tr>
										<td width="15%">
											<?php print RTVUitzendingen::DayofWeekNL($value->day); ?>
										</td>
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
										<td> <?php
											if ($value->website!="")
											{ ?>
												<a href="<?php print $value->website; ?>">
													<?php print $value->programname; ?>
												</a> <?php
											}
											else
											{ ?>
												<?php print $value->programname;
											} ?>
										</td>
									</tr> <?php
								} ?>
							</table> <?php
						} ?>
						
									
						
				</td>

				<td></td>

			
			</tr>
		</table>

	</body>
</html>

