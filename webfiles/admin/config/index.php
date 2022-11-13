<?php
define('SYSTEM_DIR', '../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');

if (!isset($_POST['action']))
	$_POST['action'] = "";

if ($_POST['action']=="save")
{
	
	$passwd = md5($_POST['password']);

	// Validate password
	$result = $GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['admin_users']." WHERE password='".$passwd."' AND username='admin'");
	if ($result->num_rows == 0)
	{
		$err .= "Wachtwoord is niet correct.";
	}
	else
	{
		$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value='".trim($_POST['broadcaster'])."' WHERE name='broadcaster'");
		if ($GLOBALS['mysql']->affected_rows == -1)
			$err .= "Configureren van naam is mislukt.<br/>";

		$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value='".trim($_POST['url'])."' WHERE name='url'");
		if ($GLOBALS['mysql']->affected_rows == -1)
			$err .= "Configureren van URL is mislukt.<br/>";

		$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value='".trim($_POST['urlprograms'])."' WHERE name='urlprograms'");
		if ($GLOBALS['mysql']->affected_rows == -1)
			$err .= "Configureren van lokatie uitzendingen is mislukt.<br/>";

		$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value='".$_POST['defaultdistribution']."' WHERE name='defaultdistribution'");
		if ($GLOBALS['mysql']->affected_rows == -1)
			$err .= "Configureren standaard distributie is mislukt.<br/>";

		$cat = 0;
		if (isset($_POST['useCategorys'])) $cat = 1;
		$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value='".$cat."' WHERE name='useCategorys'");
		if ($GLOBALS['mysql']->affected_rows == -1)
			$err .= "Configureren van categorien is mislukt.<br/>";

		// Start datum instellen
		$startdate = "";
		$result = $GLOBALS['mysql']->query("SELECT value FROM ".$GLOBALS['table']['main']." WHERE name='installDate'");
		if ($result->num_rows > 0) 
		{
			$row = mysqli_fetch_assoc($result);
			$startdate = $row['value'];
		}
		if ($startdate == "")
		{
			$startdate = date('d-m-Y');
			$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value='".$startdate."' WHERE name='installDate'");
		}
		
		$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value='0' WHERE name='mustconfig'");
		if ($GLOBALS['mysql']->affected_rows == -1)
			$err .= "Configureren van standaard distributie is mislukt.<br/>";
		
			
	}
}

?>
<style>
			body
			{
				font-family:			verdana, sans-serif;
				font-size:				11px;
			}
			.text
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
				font-family:	verdana, sans-serif;
				font-size:		12px;
			}
		</style>
		
		<table width="100%">
			<colgroup>
				<col width="50px" />
				<col width="5px" />
				<col />
				<col width="5px" />
				<col width="50px" />
			</colgroup>
			<tr>
				<td>
					<br/>
				</td>

				<td></td>

				<td>

					<p>
						<span style="font-size:14px"><b>&bull; Configuratie RTV Uitzending</b></span>
					</p> <?php

					if ($_POST['action']=="save" && isset($err))
					{ ?>
						<p style="color:red">
							<?php print $err; ?>
						</p> <?php

						if ($err == "")
						{ ?>
							<p>
								De instellingen zijn opgelagen.
							</p>
							
							<p>
								Klik <a href="<?php print SYSTEM_DIR; ?>/../admin/index.php">hier</a> om verder te gaan...
							</p>
							
							
							<?php
						}
						else
						{ ?>
							<p>
								Configureren mislukt.
							</p> <?php
						}
					} 
					else
					{ ?>

						<form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
							<input type="hidden" name="action" value="save">
							<p>
								<b>Algemeen</b><br/>
								Dit zijn de algemene instellingen.
							</p>

							<p>
								Installatie datum RTV Uitzendingen:<br/> <?php
								if ($GLOBALS['main']['installDate'] == "")
								{ ?>
									(eerste installatie) <?php
								} else {
									print $GLOBALS['main']['installDate'];
								} ?>
							</p>

							<p>
								Naam radio/tv station:<br/>
								<input type="text" class="text" maxlength="100"  name="broadcaster" value="<?php print $GLOBALS['main']['broadcaster']; ?>"><br/>
								<i>De roepnaam van het radiostation.</i>
							</p>

							<p>
								Internet adres radio/tv station:<br/>
								<input type="text" class="text" maxlength="100"  name="url" value="<?php print $GLOBALS['main']['url']; ?>"><br/>
								<i>De internet site van de omroep.</i>
							</p>

							<p>
								<b>Programmering</b><br/>
								De volgende instellingen hebben betrekking tot de programmering.
							</p>

							<p>
								Verdeling van categorienn van programma's:<br/>
								<input type="checkbox" class="checkbox" <?php if ($GLOBALS['main']['useCategorys'] == "1") { print "CHECKED"; } ?> name="useCategorys">Ingeschakeld
							</p>					

							<p>
								<b>Uitzending gemist</b><br/>
								De volgende instellingen hebben betrekking tot het aanbieden van uitgezonden radioprogramma's.
							</p>

							<p>
								Internet lokatie van audiobestanden:<br/>
								<input type="text" class="text" maxlength="100"  name="urlprograms" value="<?php print $GLOBALS['main']['urlprograms']; ?>"><br/>
								<i>Dit is de lokatie (HTTP-adres/URL) naar de hoofdmap (root) met alle audiobestanden. Meestal is dit de root naar een FTP server.</i>
							</p>

							<p>
								Standaard player:<br/>
								<select name="defaultdistribution" class="text">
									<option value="html5" <?php if ($GLOBALS['main']['defaultdistribution'] == "html5") { print "SELECTED"; } ?>>HTML5 Web player</option>									
								</select>
							</p>

							<p>
								<b>Bevestigen instellingen</b><br/>
								Tik het 'admin' wachtwoord in om te bevestigen.<br/>
								<input type="password" class="password" maxlength="100"  name="password">
							</p>
							
							<p>
								<input type="submit" class="button" value="Opslaan">
							</p>
						</form> <?php
					} ?>
				</td>

				<td></td>

				<td>
					<br/>
				</td>
			</tr>
		</table>
