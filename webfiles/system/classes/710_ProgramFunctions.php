<?php

class ProgramFunctions
{

	// Oke
	static function GetProgrammingOfDay($day)
	{
		$ret=array();
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE day=".$day." ORDER BY starttime ASC");
		while ($row = $result->fetch_assoc()) {
			$ret[$row["id"]] = new Program($row['id']);
		}
		return($ret);
	}

	// Oke
	static function RemoveProgram($id)
	{
		$result=$GLOBALS['mysql']->query("DELETE FROM ".$GLOBALS['table']['programs']." WHERE id=".$id);
	}

	static function GetProgramsByCategory($cat)
	{
		$ret=array();
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE category=".$cat." ORDER BY day ASC,starttime ASC");
		while ($row = $result->fetch_assoc()) {
			$ret[$row['id']] = new Program($row['id']);
		}
		return($ret);
	}
	
	static function GetCategoryById($id)
	{
		$result=$GLOBALS['mysql']->query("SELECT category FROM ".$GLOBALS['table']['categorys']." WHERE id=".$id);
		$row = mysqli_fetch_assoc($result);
		return $row['category'];
	}

	static function GetProgramsByOnDemand()
	{
		$ret=array();
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE ondemand=1 ORDER BY programname, day, starttime");
		
		while ($row = $result->fetch_assoc()) {
			$ret[$row['id']] = new Program($row['id']);
		}
		return($ret);
	}

	static function GetProgramOnDemand($idprogram)
	{
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE ondemand=1 AND id=".$idprogram." ORDER BY programname, day, starttime");
		if ($result->num_rows == 1) {
			return new Program($idprogram);
		}
		return null;
	}

	static function GetProgramsOnDemandForRegioTV()
	{
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE ondemand=1 AND ondemand_startdate IS NULL OR ondemand_startdate <= Now() ORDER BY day, starttime");
	
		while ($row = $result->fetch_assoc()) {
			$ret[$row['id']] = new Program($row['id']);
		}
		return($ret);
	}

	static function RandomOnDemand()
	{
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE ondemand_startdate<=now() ORDER BY RAND() LIMIT 1");
		while ($row = $result->fetch_assoc()) {
			$ret[$row['id']] = new Program($row['id']);
		}
		return($ret);
	}

	static function GetEndTimeOfProgram($id)
	{
		$program = new Program($id);
		$result=$GLOBALS['mysql']->query("SELECT starttime FROM ".$GLOBALS['table']['programs']." WHERE day=".$program->day." AND starttime>'".$program->starttime.":00' ORDER BY day ASC, starttime ASC LIMIT 1");
		if ($result->num_rows != 1) 
			$ret = "00:00";
		else
		{
			$row = mysqli_fetch_assoc($result);
			$ret = substr($row['starttime'],0,5);
		}
		if ($ret == "00:00")
			$ret = "24:00";
		return($ret);
	}

	static function getHoursOfProgram($id, $day)
	{

		$program = new Program($id);
		$result=$GLOBALS['mysql']->query("SELECT starttime FROM ".$GLOBALS['table']['programs']." WHERE day=".$program->day." AND starttime>'".$program->starttime.":00' ORDER BY day ASC, starttime ASC LIMIT 1");
		if ($result->num_rows != 1) 
			$nprogram = 24;
		else
		{
			$row = mysqli_fetch_assoc($result);
			$arr=explode(":", $row['starttime']);
			$nprogram=$arr[0];
		}

		$arr = explode(":", $program->starttime);
		$sprogram = $arr[0];
		$ret = $nprogram-$sprogram;
		return($ret);
	}

	static function GetNowAndNextPrograms($time, $max)
	{
		$ret = array();
		$day=date("w", $time);
		$hour=date("H", $time).":00:00";

		// now program
		$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE day=".$day." AND starttime<='".$hour."' ORDER BY  starttime DESC LIMIT 1");
		if ($result->num_rows == 0) 
		{
			$day--;
			if ($day==-1)
				$day=6;
			$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE day=".$day." AND starttime<='23:59:59' ORDER BY starttime DESC LIMIT 1");
		}
		$row = mysqli_fetch_assoc($result);
		$ret[0] = new Program($row['id']);

		$day=date("w", $time);

		// next
		for($i=1; $i<$max; $i++)
		{
			$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE day=".$day." AND starttime>'".$hour."' ORDER BY  starttime ASC LIMIT 1");
			if ($result->num_rows == 0) 
			{
				$day++;
				if ($day==7)
					$day=0;
				$hour="00:00:00";
				$result=$GLOBALS['mysql']->query("SELECT id FROM ".$GLOBALS['table']['programs']." WHERE day=".$day." AND starttime>='".$hour."' ORDER BY  starttime ASC LIMIT 1");
			}
			$row = mysqli_fetch_assoc($result);
			$ret[$i] = new Program($row['id']);
			$hour = $ret[$i]->starttime."00";
		}

		return($ret);
	}

	

	static function ProgramsWithEmail()
	{
		$ret=array();
		$result=$GLOBALS['mysql']->query("SELECT DISTINCT programname, email FROM ".$GLOBALS['table']['programs']." WHERE email<>'' ORDER BY email ASC");
		$latestemail = "";
		while ($row = $result->fetch_assoc()) 
		{
			if ($latestemail!=$row['email'])
			{
				$ret[$row['programname']] = $row['email'];
				$latestemail = $row['email'];
			}
		}
		
		return($ret);
	}

	static function ProgramsWithWebsites()
	{
		$ret=array();
		$result=$GLOBALS['mysql']->query("SELECT DISTINCT programname, website FROM ".$GLOBALS['table']['programs']." WHERE website<>'' ORDER BY email ASC");
		$latestwebsite = "";
		while ($row = $result->fetch_assoc()) 
		{
			if ($latestwebsite!=$row['website'])
			{
				$ret[$row['programname']] = $row['website'];
				$latestwebsite = $row['website'];
			}
		}
		
		return($ret);
	}


}