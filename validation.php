<?php
function validateName ($name)
{
        return $name;
        // if input can't be a name, return false
}
//Builds date out of input. Returns SQL formatted date or False;
function validateDate ($date)
{
	if(preg_match ("/\d{4}\-\d{2}\-\d{2}/", $date) != 0 || $date == 'NULL'){
		return $date;
	}
	else
		return 0;
}
?>
