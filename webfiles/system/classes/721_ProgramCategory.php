<?php


class ProgramCategory
{

	var $id = 0;
	var $category = "";
	var $color = "black";
	var $shortname = "";
	

	// Initialisation the class
	function __construct($id)
	{
		// new
		if ($id<1)
		{
			$this->id = 0;
			$this->category = "";
			$this->color = "black";
			$this->shortname = "";
		}

		// get up
		if ($id>0)
		{ 
			$result=$GLOBALS['mysql']->query("SELECT category, color, shortname FROM ".$GLOBALS['table']['categorys']." WHERE id=".$id);
			while ($row = $result->fetch_assoc()) 
			{
				$this->category = $row['category'];
				$this->color = $row['color'] ;
				$this->shortname = $row['shortname'];
				$this->id = $id;
			}
			
		} 
	}

	
	// Save 
	function Save()
	{
		// Toevoegen
		if ($this->id<1)
		{
			$qry  = "INSERT INTO ".$GLOBALS['table']['categorys']." ";
			$qry .= "(category, color, shortname) ";
			$qry .= "VALUES (";
			$qry .= "'".$GLOBALS['mysql']->real_escape_string($this->category)."', ";
			$qry .= "'".$this->color."', ";
			$qry .= "'".$this->shortname."') ";
			$result=$GLOBALS['mysql']->query($qry);
			if (!$result)
				return("Categorie is niet toegevoegd.<br/>Error: ".mysql_error());
			else
			{
				$this->id = $GLOBALS['mysql']->insert_id;
				return;
			}
		}

		// Modify
		if ($this->id>0)
		{
			$qry  = "UPDATE ".$GLOBALS['table']['categorys']." SET ";
			$qry .= "category = '".$GLOBALS['mysql']->real_escape_string($this->category)."', ";
			$qry .= "color = '".$this->color."', ";
			$qry .= "shortname = '".$this->shortname."' ";
			$qry .= "WHERE id=".$this->id;
			$result=$GLOBALS['mysql']->query($qry);
			if (!$result)
				return("Het is niet gelukt om de informatie te wijzigen.<br/>Error: ".mysqli_connect_error());
			else
				return;
		}
	}

}