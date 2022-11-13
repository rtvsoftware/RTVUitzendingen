<?php

define('SYSTEM_DIR', '../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');
$moduleAut = 'programmering';

session_write_close();
session_start();

// Init vars
$err = "";
if (!isset($_POST['action']))
	$_POST['action'] = "";


// Form reset / first call
if ($_SERVER['REQUEST_METHOD']=="GET")
	if (isset($_GET['id']))
		$_SESSION['program'] = new Program($_GET['id']);
	else
	{
		$_SESSION['program'] = new Program(0);
		$_SESSION['program']->day = $_GET['day'];
	}

// post
if ($_POST['action']=="done")
{

	
	$_SESSION['program']->day = $_POST['day'];
	if (isset($_POST['starttime']))
		$_SESSION['program']->starttime = $_POST['starttime'];
	$_SESSION['program']->programname = $_POST['programname'];
	$_SESSION['program']->category = $_POST['category'];
	$_SESSION['program']->information = $_POST['information'];
	$_SESSION['program']->website = $_POST['website'];
	$_SESSION['program']->email = $_POST['email'];
	if (isset($_POST['ondemand']))
		$_SESSION['program']->ondemand = 1;
	else
		$_SESSION['program']->ondemand = 0;
	$_SESSION['program']->ondemand_weeks = $_POST['ondemand_weeks'];
	if ($_POST['ondemand_startdate_month'] == "" || $_POST['ondemand_startdate_day'] == "" || $_POST['ondemand_startdate_year'] == "" || $_POST['ondemand_startdate_year'] == "1970")
	{
		$_SESSION['program']->ondemand_startdate = 0;
	}
	else
	{
		$_SESSION['program']->ondemand_startdate = mktime(0, 0, 0, $_POST['ondemand_startdate_month'], $_POST['ondemand_startdate_day'], $_POST['ondemand_startdate_year']);
	}
	
	$err = $_SESSION['program']->Save();
	if ($err=="")
	{
		
		if (isset($_POST['imageRemove']) && strlen($_POST['imageRemove']) > 0) {
			$imageidfile = "id_".$_SESSION['program']->id;
			foreach (scandir($images) as $f) {
				$len = strlen($imageidfile); 
				if (substr($f, 0, strlen($imageidfile)) == $imageidfile) {
					$imagefile = $images . $f;
					unlink($imagefile);
				}
			}
		}

		if (!empty($_FILES['imagefile']['name'])) {
			$src = $_FILES['imagefile']['tmp_name'];
			$info = pathinfo($_FILES['imagefile']['name']);
			$dest = $images . "id_" . $_SESSION['program']->id . ".".$info['extension'];
			$errupload = move_uploaded_file($src, $dest);
			if (!$errupload) {
				$_POST['action'] = "";
				return;
			} 
		}	

		// if this is a subform, the set object in an return session
		if (isset($_SESSION['ReturnForm']))
		{
			$_SESSION['ReturnValue'] = $_SESSION['program'];
		}
		unset($_SESSION['program']);
		print "Uitgevoerd.";
	}
	
	if ($err!="")
		$_POST['action'] = "";
}

// post
if ($_POST['action']=="cancel")
{
	if ($err=="")
	{
		unset($_SESSION['program']);
		print "Niet uitgevoerd.";
	}
}

// return form
if ($_POST['action']=="cancel" || $_POST['action']=="done")
{
	// return to form?
	if (isset($_SESSION['ReturnForm']))
	{
		header('Location: '.$_SESSION['ReturnForm']);
		exit;
	}
	else
	{
		header('Location: programming.php?day='.$_POST['day']);
	}

	require(SYSTEM_DIR."/../admin/main/inc/footer.php");
	exit;
}

// reset action
$_POST['action'] = "";

// form
require("forms/program.php");	

require(SYSTEM_DIR."/../admin/main/inc/footer.php");
?>

