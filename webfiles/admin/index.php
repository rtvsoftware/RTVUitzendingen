<?php

// Root is /admin
define('SYSTEM_DIR', '../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');

?>

<p>
	<b>Welkom op de beheer pagina van RTV Uitzendingen.</b>
</p>

<?php
if ($GLOBALS['main']['mustconfig'] == "1")
{ ?>
	<p>
		U dient RTVUitzendingen eerst te configureren. Klik links op het scherm voor 'configureren'.
	</p> <?php
}
else
{ ?>
	
<p>
	<b>Introductie</b><Br/>
	Om te starten selecteert u links in het menu voor <b>aanpassen</b> (onder 'Programmering'). Daarna selecteer u een weekdag om te wijzigen. U kunt dan een programma toevoegen, wijzigen of verwijderen.<br/>
	Let op: het uur "00:00" kan niet worden verwijderd.
</p>

<?php
} 
?>


<?php
require(SYSTEM_DIR.'/../admin/main/inc/footer.php');
?>