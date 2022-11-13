<?php



class ProgramCategoryFunctions
{

	static function GetAllCategorys()
	{
		$ret=array();
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['categorys']." ORDER BY id DESC");
		while ($row = $result->fetch_assoc()) 
		{
			$ret[$row['id']] = new ProgramCategory($row['id']);
		}

		return($ret);
	}

	
}