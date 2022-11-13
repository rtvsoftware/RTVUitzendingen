
<script type="text/javascript">
	
	// form submitten
	function submitForm()
	{
		document.forms['form'].action.value="done";
		document.forms['form'].submit();
	}

	// form cancel
	function cancelForm()
	{
		document.forms['form'].action.value="cancel";
		document.forms['form'].submit();
	}

</script>

<form method="post" name="form" action="<?php print $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="action" value="">

	<p>
		<b>Gebruikersinstellingen <?php print $_SESSION['loginName']; ?></b>
	</p>

	<p>
		<span class="error"><?php print $err; ?></span>
	</p>

	<p>
		<i>Toelichting:</i><br/>
		Dit zijn je eigen instellingen. Je wachtwoord wijzigen doe je via het menu item "Wachtwoord wijzigen". Voor een ander inlognaam neem je contact op met de webmaster.</i>
	</p>

	<table class="FullWidth">
		<tr>
			<td width="25%" class="vtop">
				Je e-mail adres:
			</td>
			<td>
				<input type="text" class="text" name="email" value="<?php print $_SESSION['usersettings']->email; ?>" size="40%" maxlength="100">
				&#32;<span class="red">+</span><br/>
				
			</td>
		<tr/>

		<tr>
			<td colspan="2">
				<br/>
			</td>
		</tr>

		

		<tr>
			<td colspan="2">
				<input type="button" class="button" value="OK" onclick="submitForm();">&#32;
				<input type="button" class="button" value="Annuleren" onclick="cancelForm();">&#32;
			</td>
		</tr>

	</table>

</form>

