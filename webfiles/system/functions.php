<?php
class RTVUitzendingen {
	public static function Weekdays() {
		setlocale(LC_ALL, 'nl_NL');

		$ret = array();

		for ($i = 2; $i<=8;  $i++)
		{
			$ret[$i - 2] = strftime('%A', mktime(0, 0, 0, 1, $i, 2000));
		}

		return($ret);
	}

	// give short dutchday of week
	public static function DayofWeekNL($int)
	{
		$arrDays = RTVUitzendingen::Weekdays();
		return($arrDays[$int]);
	}

	public static function DayofWeekEN($int)
	{
		$ret = array();
		$ret[0] = "Sunday";
		$ret[1] = "Monday";
		$ret[2] = "Tuesday";
		$ret[3] = "Wednesday";
		$ret[4] = "Thursday";
		$ret[5] = "Friday";
		$ret[6] = "Saturday";
		
		return($ret[$int]);
	}


	
}
?>