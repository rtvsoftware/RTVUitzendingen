<?php

define('SYSTEM_DIR', '../../system');
require(SYSTEM_DIR.'/functions.php');
require(SYSTEM_DIR.'/init.php');
require(SYSTEM_DIR.'/../admin/main/inc/header.php');

?>

<p>
	<b>Categorie aanpassen</b>
</p> 

<table> <?php
	$cats = ProgramCategoryFunctions::GetAllCategorys();
	if (count($cats) == 0)
	{ ?>
		<tr>
			<td>
				<i>Geen categorie ingevoerd.</i>
			</td>
		</tr> <?php
	}
	foreach ($cats as $key => $value)
	{ ?>
		<tr>
			<td>
				&bull;&#32;<a href="category.php?id=<?php print $key; ?>"><?php print $value->category; ?></a>
			</td>
		</tr> <?php
	} ?>
</table>

<p>
	<a href="./category.php">toevoegen nieuw categorie</a>
</p> 



<?php
require(SYSTEM_DIR."/../admin/main/inc/footer.php");
?>

