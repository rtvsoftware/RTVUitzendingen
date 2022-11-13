<?php

define('SYSTEM_DIR', '../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');
$moduleAut = 'programmering';

?>

<p>
	<b>Programmering aanpassing</b>
</p> <?php

if (!isset($_GET['confirm']))
{ ?>
	<p>
		Verwijder programma:<br/>
		<br/>  <?php
		$program = new Program($_GET['id']);
		print RTVUitzendingen::DayofWeekNL($program->day)." ".$program->starttime." ".$program->programname; ?><br/>
		<br/>
		<input type="button" class="button" value="Ja, verwijderen." onclick="window.open('<?php print $_SERVER['PHP_SELF']; ?>?id=<?php print $_GET['id']; ?>&confirm=true','_self')">&#32;&#32;
		<input type="button" class="button" value="Nee, niet verwijderen." onclick="window.open('programming.php?day=<?php print $program->day; ?>','_self')">
	</p> <?php
}

if (isset($_GET['confirm']))
{
	ProgramFunctions::RemoveProgram($_GET['id']);
	header("Location: programming.php");
}

require(SYSTEM_DIR."/../admin/main/inc/footer.php");

?>

