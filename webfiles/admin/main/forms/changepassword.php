<?php

define('SYSTEM_DIR', '../../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');

$err = "";							// error

// wachtwoord wijzigen?
if ($_SERVER['REQUEST_METHOD']=="POST")
{
	// everything filled in
	if ($_POST['oldPassword']=="" || $_POST['newPassword1']=="" || $_POST['newPassword2']=="")
	{
		$err = "Alle velden met een (+) zijn verplichte velden.";
	}

	// oldpassword not corrent?
	if ($err=="" && md5($_POST['oldPassword'])!=$_SESSION['loginPassword'])
	{
		$err = "Je huidige wachtwoord is niet correct.";
	}

	// new passowrd not different?
	if ($err=="" && ($_POST['newPassword1']!=$_POST['newPassword2']))
	{
		$err = "Het nieuw ingevoerde wachtwoorden zijn niet gelijk.";
	}

	// minimal password length
	if ($err=="" && (strlen($_POST['newPassword1'])<$GLOBALS['main']['password_length']))
	{
		$err = "Je nieuwe wachtwoord moet bestaan uit minimaal ".$GLOBALS['main']['password_length']." karakters.";
	}

	if ($err=="" && md5($_POST['newPassword1'])==$_SESSION['loginPassword'])
	{
		$err = "OK. Wachtwoord is aangepast.";
	}

	// change password
	if ($err=="")
	{
		$result=$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['admin_users']." SET password='".md5($_POST['newPassword1'])."' WHERE username='".$_SESSION['loginUser']."'");
		if ($GLOBALS['mysql']->affected_rows == 1)
		{
			// gelukt
			$passwordChangeOk = true;
			$_SESSION['loginPassword'] = md5($_POST['newPassword1']);
		}
		else
		{
			$err = "Helaas is het niet gelukt om je wachtwoord te wijzigen. Neem contact op met de webmaster.";
		}
	} 
}?>

<p class="title">
	&bull;&#32;Wijzigen wachtwoord&#32;&bull;
</p> 

<?php


// wachtwoord is goed gewijzigd
if (isset($passwordChangeOk))
{ ?>
	<p>
		Je wachtwoord is gewijzigd.
	</p> <?php
}
else
{ ?>
	<form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
		<table  cellpadding="2">
			<tr>
				<td>
					Wat is je huidige wachtwoord:
				</td>
				<td>
					<input class="text" type="password" name="oldPassword" maxlength="16">&#32;<span class="red">+</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<br/>
				</td>
			</tr>
			<tr>
				<td>
					Je nieuwe wachtwoord:<Br/>
					<span class="gray">Minimaal <?php print $GLOBALS['main']['password_length']; ?> karakters.</span>&#32;<span class="red">+</span>
				</td>
				<td>
					<input class="text" type="password" name="newPassword1" maxlength="16">
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<br/>
				</td>
			</tr>
			<tr>
				<td>
					Nogmaals je nieuwe wachtwoord:
				</td>
				<td>
					<input class="text" type="password" name="newPassword2" maxlength="16">&#32;<span class="red">+</span>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<br/>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input class="button" type="submit" value="Wijzigen">
				</td>
			</tr>
		</table>
	</form> <?php
} ?>

<p><span class="error"><?php print $err; ?></span></p>


<?php
require(SYSTEM_DIR."/../admin/main/inc/footer.php");
?>