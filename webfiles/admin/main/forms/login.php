

<p class="title">
	&bull;&#32;Aanmelden&#32;&bull;
</p>

<p>
	Ongeautoriseerd gebruik is niet toegestaan.
</p>

<p>
	Voer uw gebruikersnaam en wachtwoord in...
</p>

<form method="post" action="<?php print $_SERVER['PHP_SELF']; ?>">
	<table  cellpadding="2">
		<tr>
			<td>
				Gebruikersnaam:
			</td>
			<td>
				<input class="text" type="text" name="loginUser" maxlength="20" value="<?php print  $_POST['loginUser']; ?>">
				&#32;<span class="red">+</span>
			</td>
		</tr>
		<tr>
			<td>
				Wachtwoord:
			</td>
			<td>
				<input class="text" type="password" name="loginPassword" maxlength="16">
				&#32;<span class="red">+</span>
			</td>
		</tr>
		<tr>
			<td>
				<br/>
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<input class="button" type="submit" value="Aanmelden">
			</td>
		</tr>
	</table>
</form>

<p>
	<span class="error"><?php print $err; ?></span>
</p>


