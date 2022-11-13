
<script type="text/javascript">

	// form submitten
	function submitForm()
	{
		document.forms['program'].action.value="done";
		document.forms['program'].submit();
	}

	function cancelForm()
	{
		document.forms['program'].action.value="cancel";
		document.forms['program'].submit();
	}

</script>



<form method="post" name="program" enctype="multipart/form-data" action="<?php print $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="action" value="">
	<input type="hidden" name="id" value="<?php print $_SESSION['program']->id; ?>">

	<p>
		<b>Programma beheren</b>
	</p>

	<p>
		<span class="error"><?php print $err; ?></span>
	</p>

	<table class="fullWidth">
		<tr>
			<td>
				Dag:
			</td>
			<td>
				<select name="day" class="select"> <?php
					foreach (RTVUitzendingen::Weekdays() as $key => $value)
					{ ?>
						<option value="<?php print $key; ?>" <?php if ($key==$_SESSION['program']->day) { print " SELECTED"; } ?>><?php print $value; ?></option> <?php
					} ?>
				</select>
			</td>
		</tr>

		<tr>
			<td>
				Starttijd:
			</td>
			<td>
				<input name="starttime" class="text" value="<?php print $_SESSION['program']->starttime; ?>" size="5" maxlength="5" <?php if ($_SESSION['program']->starttime=="00:00") { ?> disabled="true" <?php } ?>>&#32;(00:01 - 23:59)
			</td>
		</tr>

		<tr>
			<td>
				Programmanaam:
			</td>
			<td>
				<input type="text" class="text" name="programname" value="<?php print $_SESSION['program']->programname; ?>" maxlength="100" size="75%">
			</td>
		</tr>

		<tr>
			<td>
				Categorie:
			</td>
			<td>
				<select name="category" class="select">
					<option value="0" <?php if ($_SESSION['program']->category == 0) { print " SELECTED"; } ?>>- geen categorie - </option> <?php
					foreach (ProgramCategoryFunctions::GetAllCategorys() as $key => $value)
					{ ?>
						<option value="<?php print $key; ?>" <?php if ($key==$_SESSION['program']->category) { print " SELECTED"; } ?>><?php print $value->category; ?></option> <?php
					} ?>
				</select>
			</td>
		</tr>
				
		<tr>
			<td class="vtop">
				Programma informatie:
			</td>
			<td>
				<textarea name="information" class="textarea" rows="5" cols="60"><?php print $_SESSION['program']->information; ?></textarea>
			</td>
		</tr>

		<tr>
			<td>
				Website:
			</td>
			<td>
				<input type="text" class="text" name="website" value="<?php print $_SESSION['program']->website; ?>" maxlength="100" size="75%">
			</td>
		</tr>

		<tr>
			<td>
				E-mail:
			</td>
			<td>
				<input type="text" class="text" name="email" value="<?php print $_SESSION['program']->email; ?>" maxlength="30" size="50%">
			</td>
		</tr>

		<tr>
			<td>
				Afbeelding: 
			</td>
			<td> <?php
				if (!isset($images) || strlen($images) == 0) { ?>
					<i><b>Niet mogelijk.</b> Er is geen locatie voor afbeeldingen in 'config.php' geconfigureerd. </i> <a href="https://www.rtvsoftware.nl/redirect?id=703" target="_blank">Meer informatie.</a> <?php
				} else { ?>
					<input type="file" name="imagefile"> <?php
				} ?>
			</td>
		</tr>

		<tr>
			<td>
			</td>
			<td>
				<?php if ($_SESSION["program"]->id > 0) {
					$img = SYSTEM_DIR.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'image.php?id='.$_SESSION["program"]->id; ?>
					<img src="<?php print $img; ?>" alt="" style="max-height:100px" />
					<br/>
					<input type="checkbox" name="imageRemove" />Verwijder afbeelding bij opslaan <?php
				} ?>
			</td>
		</tr>

		<tr>
			<td colspan="2">
				<br/>
					<b>Uitzending gemist (on-demand)</b><br/>
				<br/>
			</td>
		</tr>

		<tr>
			<td>
				Programma on-demand:
			</td>
			<td>
				<input type="checkbox" class="check" name="ondemand" <?php if ($_SESSION['program']->ondemand) { print " CHECKED "; } ?>>Programma beschikbaar stellen voor uitzending gemist
			</td>
		</tr>

		<tr>
			<td>
				Aantal weken:
			</td>
			<td>
				<input type="text" class="text" name="ondemand_weeks" value="<?php print $_SESSION['program']->ondemand_weeks; ?>" maxlength="2" size="2"> (1 - 52)
			</td>
		</tr>

		<tr>
			<td>
				Start datum:
			</td>
			<td>
				<input type="text" class="text" name="ondemand_startdate_day" value="<?php print date('d', $_SESSION['program']->ondemand_startdate); ?>" maxlength="2" size="2">&#32;-&#32;
				<input type="text" class="text" name="ondemand_startdate_month" value="<?php print date('m', $_SESSION['program']->ondemand_startdate); ?>" maxlength="2" size="2">&#32;-&#32;
				<input type="text" class="text" name="ondemand_startdate_year" value="<?php print date('Y', $_SESSION['program']->ondemand_startdate); ?>" maxlength="4" size="4"> (dd-mm-jjjj)
			</td>
		</tr>


		
		
	</table>

	<p>		
		<input type="button" class="button" value="OK" onclick="submitForm();">&#32;
		<input type="button" class="button" value="Annuleren" onclick="cancelForm();">
	</p>

</form>

					

