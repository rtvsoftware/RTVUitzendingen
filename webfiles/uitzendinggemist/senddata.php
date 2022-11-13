<?php

if (isset($_GET['direct']) && $_GET['direct'] == "1")
{
	// Direct data
	header("Location: " . $_GET['file']);
}
else
{
	// Stream vanaf server waar dit bestand op is geplaatst.
	header("Content-Type: audio/mpeg;");  
	readfile($_GET['file']);
}

?>
	