<!DOCTYPE html>
<html>
<h1>Add Director</h1>
<p> Director Format: (First Name, Last Name, DOB, DOD) </p>
<form action = "addActorDirector.php" method ="get">
<input type="text" name="FNAME">
<input type="text" name="LNAME">
<input type="text" name="DOB">
<input type="text" name="DOD">
<input type="submit" value="Submit New Director">
</form>
<br>

<?php
// This function should return a string with invalid characters removed
function validateName ($name)
{
	return $name;
	// if input can't be a name, return false
}
//Builds date out of input. Returns SQL formatted date or False;
function validateDate ($date)
{
	return $date;
}
function addDirector($fname,$lname,$dob,$dod)
{
	//start by making sure we can interperet input
	$FirstName = validateName($fname);
	$LastName  = validateName($lname);
	$DOB	   = validateDate($dob);
	$DOD	   = validateDate($dod);
	if(! $FirstName || ! $LastName || ! $DOB || ! $DOD)
	{
		// One of the user input texts was invalid
		echo "Invalid input";
		return false;
	}
	// Input is valid, build query and insert into DB!
	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);
	// Have to get the next valid ID for director
	// First check if the person is already in the DB
	$directorInDB = 'select * from Director where last="' . $LastName . '" and first= "' . "$FirstName" . '"';
	$getDirRows = mysql_query($directorInDB,$db_connection);
	$resDirector = mysql_fetch_row($getDirRows);
	if(! empty( $resDirector ))
	{
		echo "Director already exists! <br>";
		return false;
	}
	echo "Putting new Director in DB <br>";
	// Specified Director is not in the DB yet, so grab an ID for it
	$getID = mysql_query("select * from MaxPersonID");
	$tuple1= mysql_fetch_row($getID);
	$idToInsert = $tuple1[0] + 1;
	// Now increment the one in the DB
	$incrementID = "update MaxPersonID set id = $idToInsert";
	$setID = mysql_query($incrementID, $db_connection);
	// Now add the new director to the DB
	$insertDirector = "insert into Director values($idToInsert," . '"' . "$LastName" . '" ,"' . "$FirstName" . '" ,';
   	if($DOB != "NULL")
	{
		$insertDirector	.= '"' . "$DOB" . '",';
	}	
	else	// Don't need double quotes around NULL
	{
		$insertDirector	.= "$DOB ,";
	}
	if($DOD != "NULL")
	{
		$insertDirector	.= '"' . "$DOD" . '");';
	}	
	else	// Don't need double quotes around NULL
	{
		$insertDirector	.= "$DOD);";
	}
	$putDBDirector = mysql_query($insertDirector,$db_connection);
	echo "Successfully added $FirstName $LastName to the DB";
	mysql_close($db_connection);
	return false;
}

// Entry Point
if($_GET)
{
	// first name last name birthdate deathdate
	$F = $_GET["FNAME"];
	$L = $_GET["LNAME"];
	$B = $_GET["DOB"];
	$D = $_GET["DOD"];
	// Empty Dates parsed as "NULL"
	if($B == "")
	{
		$B = "NULL";
	}	
	if($D == "")
	{
		$D = "NULL";
	}
	echo "You entered First = $F, Last = $L, DOB = $B, DOD = $D<br>";
	addDirector($F,$L,$B,$D);
} 
?>

</html>

