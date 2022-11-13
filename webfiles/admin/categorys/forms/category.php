
<script>

	// form submitten
	function submitForm()
	{
		document.forms['category'].action.value="done";
		document.forms['category'].submit();
	}

	function cancelForm()
	{
		document.forms['category'].action.value="cancel";
		document.forms['category'].submit();
	}

</script>



<form method="post" name="category" action="<?php print $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="action" value="">
	<input type="hidden" name="id" value="<?php print $_SESSION['category']->id; ?>">

	<p>
		<b>Beheer categorie</b>
	</p>

	<p>
		<span class="error"><?php print $err; ?></span>
	</p>

	<table class="fullWidth">
		<tr>
			<td>
				Categorie (uitgebreide omschrijving):
			</td>
			<td>
				<input name="category" class="text" value="<?php print $_SESSION['category']->category; ?>" size="30" maxlength="30">
			</td>
		</tr>

		<tr>
			<td>
				Categorie (kort):
			</td>
			<td>
				<input name="shortname" class="text" value="<?php print $_SESSION['category']->shortname; ?>" size="6" maxlength="6">
			</td>
		</tr>

		<tr>
			<td>
				Kleur:
			</td>
			<td>
				<input name="color" class="text" value="<?php print $_SESSION['category']->color; ?>" size="10" maxlength="10">&#32;<span style="background-color:<?php print $_SESSION['category']->color; ?>;color:white">123456</span>
			</td>
		</tr>

		
	</table>

	<p>		
		<input type="button" class="button" value="OK" onclick="submitForm();">&#32;
		<input type="button" class="button" value="Annuleren" onclick="cancelForm();">
	</p>

</form>

					

