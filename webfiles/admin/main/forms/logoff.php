<?php

$logoff = true;

define('SYSTEM_DIR', '../../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');



?>

<p class="title">
	&bull;&#32;Afmelden&#32;&bull;
</p>

<p>
	Je bent uitgelogd.
</p>

<p>
	Klik <a href="<?php print SYSTEM_DIR; ?>/../admin/index.php">hier</a> om je opnieuw aan te melden.
</p>

<p>
	Of klik <a href="<?php print $GLOBALS['main']['url']; ?>">hier</a> voor de site <?php print $GLOBALS['main']['url']; ?>.
</p>

<?php
require(SYSTEM_DIR."/../admin/main/inc/footer.php"); 
?>