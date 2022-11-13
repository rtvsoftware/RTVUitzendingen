<?php

define('SYSTEM_DIR', '../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');
$moduleAut = 'programmering';
?>

<p>
	<b>Programmering aanpassen</b>
</p> 

<?php
// Ask weekday
if (!isset($_GET['day']))
{ ?>
	<p>
		Selecteer een weekdag:<br/>
		<br/> <?php
		foreach (RTVUitzendingen::Weekdays() as $key => $value)
		{ ?>
			<a href="<?php print $_SERVER['PHP_SELF']; ?>?day=<?php print $key; ?>"><?php print $value; ?></a><br/>
			<br/> <?php
		} ?>
	</p> <?php
}

// Show programming of weekday
if (isset($_GET['day']))
{ ?>
	<p>
		Geselecteerde dag: <b><?php print RTVUitzendingen::DayofWeekNL($_GET['day']) ?></b>&#32;<a href="<?php print $_SERVER['PHP_SELF']; ?>">selecteer een andere dag</a>
	</p> 
	<table width="40%"> <?php
		$programs = ProgramFunctions::GetProgrammingOfDay($_GET['day']);
		if (count($programs) == 0)
		{ ?>
			<i>Er is voor deze weekdag geen programmering ingevoerd.</i> <?php
		}

		foreach ($programs as $value)
		{ ?>
			<tr>
				<td width="5%">
					<a href="program.php?id=<?php print $value->id; ?>" title="id <?php print $value->id; ?>"><?php print $value->starttime; ?></a>
				</td>
				<td> 
					<?php print $value->programname; ?>
				</td>
				<td>  <?php
					
					if ($value->starttime != "00:00")
					{ ?>
						<a href="removeprogram.php?id=<?php print $value->id; ?>">verwijder</a>  <?php
					} ?>
				</td>
			</tr> <?php
		} ?>
	</table>

	<p>
		<a href="program.php?day=<?php print $_GET['day'] ?>">toevoegen nieuw programma</a>
	</p> <?php
} ?>

<p>Tip: houd de muis op het startuur voor het ID van het programma.</p> <?php



require(SYSTEM_DIR."/../admin/main/inc/footer.php");
?>

