<?php
define('SYSTEM_DIR', './system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');


?>

<!DOCTYPE html>
	<head> 
		<title>RTV Uitzendingen - <?php print $GLOBALS['main']['broadcaster']; ?></title>
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

				<p>
						<span style="font-size:14px"><b>&bull; RTV Uitzending</b></span>
					</p>

					<p>
						<b>Welkom op de RTV Uitzendingen start pagina.</b>
					</p>
					
					<p>
						RTV Uitzendingen is een basissysteem voor het aanbieden van radio uitzendingen.
					</p>
					

					<p>
						Dit is de hoofdpagina (/rtvuitzendingen/index.php).
					</p>

									
					<p>
						&bull;&#32;<a href="admin/index.php">Beheer</a><br/>
						&bull;&#32;<a href="programmering/index.php">Bekijk de programmering</a><br/>
						&bull;&#32;<a href="uitzendinggemist/index.php">Naar uitzending gemist</a>
					</p> 

				<td></td>

				<td style="border-left: 2px solid #000000;">
					<br/>
				</td>
			</tr>
		</table>

	</body>
</html>
