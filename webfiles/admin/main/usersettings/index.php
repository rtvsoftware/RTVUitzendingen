<?php

define('SYSTEM_DIR', '../../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');

session_write_close();
session_start();

// Init vars
$err = "";
if (!isset($_POST['action']))
{
	$_POST['action'] = "";
}

// Form reset / first call
if ($_SERVER['REQUEST_METHOD']=="GET")
{
	$_SESSION['usersettings'] = new Usersettings();
}

// Get the values from the form
if ($_SERVER['REQUEST_METHOD']=="POST")
{
	$_SESSION['usersettings']->email = $_POST['email'];
}

// Done with form
if ($_POST['action']=="done")
{

	
	$err = $_SESSION['usersettings']->Save();
	if ($err=="")
	{ ?>
		<p>
			<b><span class="green">[ok]</span> Je gegevens zijn aangepast.</b>
		</p> <?php
	}
	else
	{
		$_POST['action'] = "";
	}
}

// post
if ($_POST['action']=="cancel")
{ ?>
	<p>
		<b><span class="red">!</span> Je gegevens zijn niet aangepast.</b>
	</p> <?php
}

// return form
if ($_POST['action']=="cancel" || $_POST['action']=="done")
{
	unset($_SESSION['usersettings']);
	require(SYSTEM_DIR."/../admin/main/inc/footer.php");
	exit;
}

// reset action
$_POST['action'] = "";

// form
require("./forms/usersettings.php");	

require(SYSTEM_DIR."/../admin/main/inc/footer.php");
?>

