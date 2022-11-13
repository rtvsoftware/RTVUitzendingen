<?php

// reset password exists?
$resetpasswordfile = SYSTEM_DIR."/../admin/resetpassword.php";
if (file_exists($resetpasswordfile)) { ?>
	<p>resetpassword.php aanwezig. Verwijder deze eerst om verder te gaan.</p> <?php
	exit;
}

// By login, save information about loginuser and password in SESSION
if (isset($_POST['loginUser']) && isset($_POST['loginPassword']))
{
	
	$_SESSION['loginUser'] = $_POST['loginUser'];
	$_SESSION['loginPassword'] = md5($_POST['loginPassword']);
	$_POST['loginPassword'] = "";
	
	
}

// check login
$whichPageShow = "";	// show another page
$err = "";				// error

if (isset($_SESSION['loginUser']) && isset($_SESSION['loginPassword'])) 
{
	if ($_SESSION['loginUser']=="") // no username
	{							
		$err = "Je vergeet je gebruikersnaam in te voeren.";
		$whichPageShow = SYSTEM_DIR."/../admin/main/forms/login.php";
		unset($_SESSION['loginPassword']);
	} 
	if ($err=="" && $_SESSION['loginPassword']=="") // no password
	{						
		$err = "Je vergeet je wachtwoord in te tikken.";
		$_POST['loginUser'] = $_SESSION['loginUser'];
		$whichPageShow = SYSTEM_DIR."/../admin/main/forms/login.php";
		unset($_SESSION['loginUser']);
	}
	if ($err=="") 
	{								
		$query = sprintf("SELECT username,lockout,modules,name,id,isadmin FROM ".$GLOBALS['table']['admin_users']." WHERE username='%s' AND password='%s'", 
			$_SESSION['loginUser'],
			$_SESSION['loginPassword']
			);
		$result=$GLOBALS['mysql']->query($query);
		if ( $result->num_rows > 0)// user is known.
		{				
			$row = $result->fetch_assoc();
			if ($row['lockout'] =='0') 		// not lockout?
			{
				// -----------------------------------------------------------------------
				// availble vars for another the scripts
				$_SESSION['loginId'] =$row['id'];		// unieke id gebruiker
				$_SESSION['loginModules'] = $row['modules'];	// modules
				$_SESSION['loginName'] = $row['name'];		// voornaam
				$_SESSION['loginIsAdmin'] = $row['isadmin'] == 1 ? true : false;	// Is Admin 
				// -----------------------------------------------------------------------
				$result=$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['admin_users']." SET lastLogin=NOW(), lastIP='".$_SERVER['REMOTE_ADDR']."' WHERE username='".$_SESSION['loginUser']."'");
			}
			else 
			{	// useraccount locket
				unset($_SESSION['loginUser']);
				unset($_SESSION['loginPassword']);
				$whichPageShow = SYSTEM_DIR."/../admin/main/forms/lockout.php";
			}
		}
		else // user is unkown
		{				
			unset($_SESSION['loginUser']);
			unset($_SESSION['loginPassword']);
			$err = "Je gebruikersnaam of wachtwoord is niet goed. Probeer het opnieuw...";
			$whichPageShow = SYSTEM_DIR."/../admin/main/forms/login.php";
		}	
	} 
}
else
{	
	// show login form. init the vars
	$_POST['loginUser'] = "";
	$_POST['loginPassword'] = "";
	$whichPageShow = SYSTEM_DIR."/../admin/main/forms/login.php";
}

// access to module?
if (isset($moduleAut) && $moduleAut != "" &&  $whichPageShow == "" && !$_SESSION['loginIsAdmin'])
{
	if (stristr($_SESSION['loginModules'],$moduleAut) == "")	// no access
	{
		$whichPageShow = SYSTEM_DIR."/../admin/main/forms/noaccess.php";
	}
}

// logoff
if (isset($logoff) && $logoff)
{
	unset($_SESSION['loginUser']);
	unset($_SESSION['loginPassword']);
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd"> 
	
	<head> 
		<title>Beheer <?php print $GLOBALS['main']['broadcaster']; ?></title>
		<meta http-equiv="Expires" content="0">
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
		<link rel="stylesheet" type="text/css" href="<?php print SYSTEM_DIR; ?>/../admin/main/css/main.css"> <?php
		if (isset($css))
		{
			foreach ($css as $value)
			{ ?>
				<link rel="stylesheet" type="text/css" href="<?php print $value; ?>"> <?php
			}
		} ?>
		<!-- menu -->
		<script type="text/javascript" src="<?php print SYSTEM_DIR; ?>/../admin/main/scripts/menu.js"></script>
	</head>

	
	<body>

		<!-- page -->
		<table class="mainPage" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<!--head -->
				<td colspan="2" class="tdPageHead">
					<table class="tableHead">
						<tr>
							<td>
							<div class="pageHeadTitle">
								RTV Uitzendingen beheer <?php print $GLOBALS['main']['broadcaster']; ?>
							</div>
							</td>
							
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<!-- menu -->
				<td class="tdPageLeft">
					<!-- login data -->
					<p> <?php
					
						if (IsSet($_SESSION['loginUser']) && IsSet($_SESSION['loginPassword']))	// logged in
						{ ?>
							<div class="inlogUser">
								Ingelogd:<br/><?php print $_SESSION['loginName']; ?> <?php
								if ($_SESSION['loginIsAdmin'])
								{ ?>
									<Br/><span class="Administrator">Administrator</span></div>
									<?php
								} 
								if ($GLOBALS['main']['mustconfig'] == "0") { ?>
									</div><p><b>Persoonlijk</b><br/>
									&bull;&#32;<span onMouseOver="mouseOverItem(this,'Persoonlijke gegevens');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItem('<?php print SYSTEM_DIR; ?>/../admin/main/usersettings/index.php');">Persoonlijke gegevens</span><br/>
									&bull;&#32;<span onMouseOver="mouseOverItem(this,'Wachtwoord wijzigen');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItem('<?php print SYSTEM_DIR; ?>/../admin/main/forms/changepassword.php');">Wachtwoord wijzigen</span><br/> <?php
								} 
						}
						else	// niet ingelogd
						{ ?>
							&bull;&#32;<span onMouseOver="mouseOverItem(this,'Klik hier om je aan te melden.');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItem('<?php print SYSTEM_DIR; ?>/../admin/index.php');" title="Klik hier om je aan te melden.">Aanmelden</span> 
							<br/><br/><?php
						} 
					?>

					 <?php
					// indien ingelogd, menu weergeven
					if (IsSet($_SESSION['loginUser']) && IsSet($_SESSION['loginPassword']))
					{ 
						if ($GLOBALS['main']['mustconfig'] == "0")
						{
							$result=$GLOBALS['mysql']->query("SELECT name,uri,description,module FROM ".$GLOBALS['table']['admin_menu']." WHERE showItem=1 ORDER BY position");
							while ($row = $result->fetch_assoc()) 
							{
								// check autorisation for module
								if ($_SESSION['loginIsAdmin'] || ($module!="" && stristr($_SESSION['loginModules'],$row['module'])))
								{
									if ($row['uri']=="")	// head
									{ ?>
										<br/><b><?php print $row['name']; ?></b><br/> <?php
									}
									else
									{ 
										$uri = $row['uri'];
										// make url
										if (strpos($uri,"http://")>-1)
										{
											$url = $uri;
										}
										else if (substr($uri, 0, 1) == ".")
										{
											$url = SYSTEM_DIR."/../".$uri;
										}
										else
										{
											$url = SYSTEM_DIR."/../admin".$uri;
										} ?>
										&bull;&#32;<span onMouseOver="mouseOverItem(this,'<?php print $row['description']; ?>');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItem('<?php print $url; ?>');" title="<?php print $row['description']; ?>"><?php print $row['name']; ?></span><br/> <?php
									} 
								}
							}
							
						} ?>
						
						<p><b>Publieke sites</b><br/>
						&bull;&#32;<span onMouseOver="mouseOverItem(this,'Programmering');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItemAnotherBrowser('<?php print SYSTEM_DIR; ?>/../programmering/index.php');">Programmering</span><br/>
						&bull;&#32;<span onMouseOver="mouseOverItem(this,'Uitzending gemist');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItemAnotherBrowser('<?php print SYSTEM_DIR; ?>/../uitzendinggemist/index.php');">Uitzending gemist</span>	
						
						<br/>
						<p><b>RTVUitzendingen</b><br/>
						&bull;&#32;<span onMouseOver="mouseOverItem(this,'Configureren');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItem('<?php print SYSTEM_DIR; ?>/../admin/config/index.php');">Configureren</span><br/>
						
						<br/>
						<b>Afmelden</b><br/>
						&bull;&#32;<span onMouseOver="mouseOverItem(this,'afmelden');" onMouseOut='mouseOutItem(this);' class="menuItemMouseOut" onclick="clickItem('<?php print SYSTEM_DIR; ?>/../admin/main/forms/logoff.php');">Afmelden</span><br/>
						</p> <?php
					} ?>
					
				

					<p class="copyright">
						RTV Uitzendingen
					</p>
				</td>
				<!-- main --> 
				<td class="tdPageMain">
					<?php
					// show another page?
					if ($whichPageShow!="")
					{
						require($whichPageShow);
						require(SYSTEM_DIR."/../admin/main/inc/footer.php");
						exit;	// dont show the rest
					}

?>
