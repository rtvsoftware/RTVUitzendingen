<?php



define('SYSTEM_DIR', '../system/');
require(SYSTEM_DIR.'functions.php');
require(SYSTEM_DIR.'init.php');




function SendFile($url, $distribution)
{


	if ($distribution == 'download')
	{
		header("Location: ".$url);
		exit;
	}
	else 
	{
		// Get program data
		$program = new Program($_GET['programid']);
		// Set broadcast name
		$_SESSION['stationname'] = $GLOBALS['main']['broadcaster'];
		// Program title
		$_SESSION['programtitle'] = $program->programname;
		// program item 020320081400
		$programtime = mktime(substr($_GET['item'], 8, 2), substr($_GET['item'], 10, 2), 0, substr($_GET['item'], 2, 2), substr($_GET['item'], 0, 2), substr($_GET['item'], 4, 4));
		$_SESSION['datehour'] = date('l d F Y, H:i', $programtime)." uur";
		// location
		$_SESSION['audiolocation'] = $url;
		// Call player
		if ($GLOBALS['main']['defaultdistribution'] == "html5") {
			header("Location: ./html5/default.php"); 
		}
		
		exit;
	}
	

}

if (isset($_GET['programid']))
{
	// distribution
	$distribution = $GLOBALS['main']['defaultdistribution'];
	
	// Change by parameter
	if (isset($_GET['download']))
		$distribution = 'download';
	else 
		$distribution = 'html5';

	// Check programid
	if (intval($_GET['programid']) > 0)
	{
		// Create url
		$url = $GLOBALS['main']['urlprograms'];
		if (substr($url, -1) != "/")
			$url .= "/";
		$url .= $_GET['programid'] . "/". $_GET['item'] . ".mp3";
		
		SendFile($url, $distribution);
		exit;
	}
}

print "<b>Error #APE0011</b> Incorrect input.";
exit;



