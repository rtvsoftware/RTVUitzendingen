<?php

define('SYSTEM_DIR', '../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');

session_write_close();
session_start();

// Init vars
$err = "";
if (!isset($_POST['action']))
	$_POST['action'] = "";

// Form reset / first call
if ($_SERVER['REQUEST_METHOD']=="GET")
	if (isset($_GET['id']))
		$_SESSION['category'] = new ProgramCategory($_GET['id']);
	else
		$_SESSION['category'] = new ProgramCategory(0);


// post
if ($_POST['action']=="done")
{
	$_SESSION['category']->category = $_POST['category'];
	$_SESSION['category']->shortname = $_POST['shortname'];
	$_SESSION['category']->color = $_POST['color'];

	$err = $_SESSION['category']->Save();
	if ($err=="")
	{
		// if this is a subform, the set object in an return session
		if (isset($_SESSION['ReturnForm']))
		{
			$_SESSION['ReturnValue'] = $_SESSION['program'];
		}
		unset($_SESSION['category']);
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
		unset($_SESSION['category']);
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
		header('Location: programcategorys.php');
	}

	require(SYSTEM_DIR."/../admin/main/inc/footer.php");
	exit;
}

// reset action
$_POST['action'] = "";

// form
require("./forms/category.php");	

require(SYSTEM_DIR."/../admin/main/inc/footer.php");
?>

