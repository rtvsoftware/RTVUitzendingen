<?php
session_start();
?>
<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>RTVUitzendingen HTML 5 speler - <?php print $_SESSION['stationname']; ?></title>

	
	
</head>

<body>


	<form method="post" name="inputdata">
		<input type="hidden" name="stationname" value="<?php print $_SESSION['stationname']; ?>" />
		<input type="hidden" name="programtitle" value="<?php print $_SESSION['programtitle']; ?>" />
		<input type="hidden" name="datehour" value="<?php print $_SESSION['datehour']; ?>" />
		<input type="hidden" name="audiolocation" value="<?php print $_SESSION['audiolocation']; ?>" />
	</form>


	<div style="text-align:center">
		<table>
			<tr style="vertical-align:top">
				<td><b>Programma:</b></td>
			</tr>
			<tr>
				<td><?php print $_SESSION['programtitle']; ?><br/>
				<?php print $_SESSION['datehour']; ?>
				</td>
			</tr>
			<tr>
				<td>
					<br/>
				</td>
			</tr>
			<tr>
				<td>
					<audio src="<?php print $_SESSION['audiolocation']; ?>" controls autoplay></audio>
				</td>
			</tr>
			<tr>
				<td>
					
					<p style="font-family:verdana; font-size:11px; color:white">
						&bull;&#32;<a href="../index.php" style="color:black">lijst uitzendingen</a>
					</p>

					<p style="font-family:verdana; font-size:11px; color:gray">
						HTML5 Simple player</a>
					</p>
					
					</td>
			</tr>
		</table>
	</div>



	
</body>
</html>
