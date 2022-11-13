<?php

class Program
{

	var $id;
	var $day;
	var $starttime;
	var $programname;
	var $information;
	var $email;
	var $website;
	var $category;
	var $ondemand;
	var $ondemand_weeks;
	var $ondemand_startdate;


	// Init the class
	function __construct($id)
	{
		// new
		if ($id == 0)
		{
			$this->id = 0;
			$this->day = -1;
			$this->starttime = "01:00";
			$this->programname = "";
			$this->information = "";
			$this->email = "";
			$this->website = "";
			$this->category = 0;
			$this->ondemand = 0;
			$this->ondemand_weeks = 2;
			$this->ondemand_startdate = 0;
		}

		// get data
		if ($id > 0)
		{ 
			$result=$GLOBALS['mysql']->query("SELECT day, starttime, programname, information, email, website, category, ondemand, ondemand_weeks, UNIX_TIMESTAMP(ondemand_startdate) AS ondemand_startdate FROM ".$GLOBALS['table']['programs']." WHERE id=".$id);
			while ($row = $result->fetch_assoc()) 
			{
				$this->id = $id;
				$this->day = $row['day'];
				$this->starttime = substr($row['starttime'],0,5);
				$this->programname = $row['programname'];
				$this->information = $row['information'];
				$this->email = $row['email'];
				$this->website = $row['website'];
				$this->category = $row['category'];
				$this->ondemand = $row['ondemand'];
				$this->ondemand_weeks = $row['ondemand_weeks'];
				$this->ondemand_startdate = $row['ondemand_startdate'];
			}
			
		} 
	}

	function CreateFile($hour, $day)
	{
		$file  = "programid=".$this->id."&item=";
		$file .= date("d", $day).date("m", $day).date("Y",$day);
		if (strlen($hour)==1)
			$hour = "0".$hour;
		$file .= $hour."00";

		return $file;
	}

	function Save()
	{
		// validate
		if ($this->day<0 || $this->day>6)
			return("Onjuiste weekdag geselecteerd.");
		if (strlen($this->starttime)!=5 || !preg_match("/[0-2][0-9]:[0-5][0-9]/", $this->starttime))
			return("Starttijd is niet correct.");
		if ($this->programname=="")
			return("Geen programmanaam.");

	
		// If 00:00, INSERT not possible
		if ($this->starttime == "00:00")
		{
			// Get id
			$result= $GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE day=".$this->day." AND starttime='".$this->starttime.":00'");

			// Check if
			$row = mysqli_fetch_assoc($result);
			if ($this->id != $row['id'])
			{
				return("Voor ingevoerde dag en tijdstip is al reeds een programma ingevoerd.");
			}
		}

		$ok = false;
	
		// Toevoegen
		if ($this->id==0)
		{		
			// already exists?
			$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE day=".$this->day." AND starttime='".$this->starttime.":00'");
			if ($result->num_rows > 0) 
				return("Voor ingevoerde dag en tijdstip is al reeds een programma ingevoerd.");

			$qry  = "INSERT INTO ".$GLOBALS['table']['programs']." ";
			$qry .= "(day, starttime, programname, information,  ";
			$qry .= " email, website, category, adminby_id, adminby_when, ";
			$qry .= " ondemand, ondemand_weeks, ondemand_startdate) ";
			$qry .= "VALUES (";
			$qry .= " ".$this->day.", ";
			$qry .= "'".$this->starttime.":00', ";
			$qry .= "'".$GLOBALS['mysql']->real_escape_string($this->programname)."', ";
			$qry .= "'".$GLOBALS['mysql']->real_escape_string($this->information)."', ";
			$qry .= "'".$this->email."', ";
			$qry .= "'".$GLOBALS['mysql']->real_escape_string($this->website)."', ";
			$qry .= " ".$this->category.", ";
			$qry .= " ".$_SESSION['loginId'].", ";
			$qry .= " NOW(), ";
			$qry .= " ".$this->ondemand.", ";
			$qry .= " ".$this->ondemand_weeks.", ";
			$qry .= " FROM_UNIXTIME(".$this->ondemand_startdate.")) ";
			$result=$GLOBALS['mysql']->query($qry);
			if ($GLOBALS['mysql']->affected_rows == 0)
				return("Toevoegen van programma is mislukt.<br/>Error: ".$GLOBALS['mysql']->mysqli_error);
			else
			{
				$this->id = $GLOBALS['mysql']->mysqli_insert_id;
				$ok = true;
			}
		}

		// Modify
		if ($this->id>0)
		{
			$qry  = "UPDATE ".$GLOBALS['table']['programs']." SET ";
			$qry .= "day = ".$this->day.", ";
			$qry .= "starttime = '".$this->starttime.":00', ";
			$qry .= "programname = '".$GLOBALS['mysql']->real_escape_string($this->programname)."', ";
			$qry .= "information = '".$GLOBALS['mysql']->real_escape_string($this->information)."', ";
			$qry .= "email = '".$this->email."', ";
			$qry .= "website = '".$GLOBALS['mysql']->real_escape_string($this->website)."', ";
			$qry .= "category = ".$this->category.", ";
			$qry .= "adminby_id = ".$_SESSION['loginId'].", ";
			$qry .= "adminby_when = NOW(), ";
			$qry .= "ondemand = ".$this->ondemand.", ";
			$qry .= "ondemand_weeks = ".$this->ondemand_weeks.", ";
			$qry .= "ondemand_startdate = FROM_UNIXTIME(".$this->ondemand_startdate.") ";
			$qry .= "WHERE id=".$this->id;
			$result=$GLOBALS['mysql']->query($qry);
			if ($GLOBALS['mysql']->affected_rows == 0)
				return("Toevoegen van programma is mislukt.<br/>Error: ".$GLOBALS['mysql']->mysqli_error);
			else
			{
				$ok = true;
			}
			
		}
		
		if ($ok)
		{
			$result=$GLOBALS['mysql']->query("UPDATE ".$GLOBALS['table']['main']." SET value = '".date("Y-m-d H:i:s O")."' WHERE name='updateprogram'");				
		}
	}

}