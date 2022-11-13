<?php


class Usersettings
{

	// variables
	var $email = "";

	// Initialisation the class
	function __construct()
	{
		$result=$GLOBALS['mysql']->query("SELECT email FROM ".$GLOBALS['table']['admin_users']." WHERE id=".$_SESSION['loginId']);
		if ($result->num_rows == 1)
		{
			$row = $result->fetch_assoc();
			$this->email = $row['email'];
		}
		
	}

	// Saving
	function Save()
	{
		// validate
		if ($this->email=="")
		{
			return("Geen email opgegeven.");
		}
		if (!preg_match("/^([a-zA-Z0-9])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-]+)+/", $this->email))
		{
			return("Syntax e-mail is incorrect.");
		}

		$qry  = "UPDATE ".$GLOBALS['table']['admin_users']." SET ";
		$qry .= "email = '".$this->email."' ";
		$qry .= "WHERE id=".$_SESSION['loginId'];
		$GLOBALS['mysql']->query($qry);
		
		if ($GLOBALS['mysql']->affected_rows == -1)
		{
			return("Je gegevens aanpassen is mislukt. Neem contact op met de webmaster.<br\>Error: ".$GLOBALS['mysql']->error);
		}
	}

	

	
	
}


