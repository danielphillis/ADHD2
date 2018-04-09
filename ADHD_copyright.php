<?php
	if( ! ini_get('date.timezone') )
	{
		date_default_timezone_set('GMT');
	}
	#Starting year
	$initialYear = 2015;
	#Current year;
	$currentYear = date("Y");
		 
	#Set the date to the start year by default
	$printYear = $initialYear;

	$end = 'Australasian Digital Heritage Database. All rights reserved.';
		 
	#Add a hyphen if the starting and current year are not the same
	if($initialYear != $currentYear){
		$printYear = "Copyright ©" . $initialYear . "-" . $currentYear . ' '.$end;
	}
	else {
		$printYear = "Copyright ©" . $initialYear . ' '.$end;
	}
	echo '<small>'.$printYear.'</small>';
?>