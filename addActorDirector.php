<!DOCTYPE html>
<html>
<h1>Add Director</h1>
<a href = "index.html"> Back to main page </a> <br><br>
<form action = "addActorDirector.php" method ="get">

<input type="radio" name="dora" value="dir"> Director
<input type="radio" name="dora" value="act"> Actor <br>
<p> Date of birth and death are in YYYY-MM-DD format. </p>
<p> Director Format: First Name, Last Name, DOB, DOD </p>
<input type="text" name="FNAME">
<input type="text" name="LNAME">
<input type="text" name="DOB">
<input type="text" name="DOD">
<input type="submit" value="Submit New Director">
<br><br>
<p> Actor Format: First Name, Last Name,Sex, DOB, DOD  </p>
<input type="text" name="aFNAME">
<input type="text" name="aLNAME">
<input type="text" name="aSEX">
<input type="text" name="aDOB">
<input type="text" name="aDOD">
<input type="submit" value="Submit New Actor">
</form>
<br>

<?php
include 'validation.php';

function addDirector($fname,$lname,$dob,$dod)
{
	//start by making sure we can interperet input
	$FirstName = validateName($fname);
	$LastName  = validateName($lname);
	if(!($DOB = validateDate($dob)) || !($DOD = validateDate($dod))){
		echo "Invalid Date!";
		return false;
	}
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
function addActor($fname,$lname,$sex,$dob,$dod)
{
	//start by making sure we can interperet input
	$FirstName = validateName($fname);
	$LastName  = validateName($lname);
	$Sex       = $sex;
	if(!($DOB = validateDate($dob)) || ! ($DOD = validateDate($dod))){
		echo "Invalid Date!";
		return false;
	}
	if(! $FirstName || ! $LastName || ! $DOB || ! $DOD)
	{
		// One of the user input texts was invalid
		echo "Invalid input";
		return false;
	}
	// Input is valid, build query and insert into DB!
	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);
	// Have to get the next valid ID
	// First check if the person is already in the DB
	$actorInDB = 'select * from Actor where last="' . $LastName . '" and first= "' . "$FirstName" . '"';
	$getDirRows = mysql_query($actorInDB,$db_connection);
	$resActor = mysql_fetch_row($getDirRows);
	if(! empty( $resActor ))
	{
		echo "Actor already exists! <br>";
		return false;
	}
	echo "Putting new Actor in DB <br>";
	// Specified Actor is not in the DB yet, so grab an ID for it
	$getID = mysql_query("select * from MaxPersonID");
	$tuple1= mysql_fetch_row($getID);
	$idToInsert = $tuple1[0] + 1;
	// Now increment the one in the DB
	$incrementID = "update MaxPersonID set id = $idToInsert";
	$setID = mysql_query($incrementID, $db_connection);
	// Now add the new Actor to the DB
	$insertActor = "insert into Actor 
			values($idToInsert," . '"' . "$LastName" . '" ,"' . "$FirstName" . '" ,"'. "$Sex" . '" ,';
   	if($DOB != "NULL")
	{
		$insertActor	.= '"' . "$DOB" . '",';
	}	
	else	// Don't need double quotes around NULL
	{
		$insertActor	.= "$DOB ,";
	}
	if($DOD != "NULL")
	{
		$insertActor	.= '"' . "$DOD" . '");';
	}	
	else	// Don't need double quotes around NULL
	{
		$insertActor	.= "$DOD);";
	}
	$putDBActor = mysql_query($insertActor,$db_connection);
	echo "Successfully added $FirstName $LastName to the DB";
	mysql_close($db_connection);
	return false;
}

// Entry Point
if($_GET)
{
	$DorA = $_GET["dora"];
	if($DorA == ""){
		echo "Please specify Actor or Director";
		return false;
	}
	// first name last name birthdate deathdate
	$F = $_GET["FNAME"];
	$L = $_GET["LNAME"];
	$B = $_GET["DOB"];
	$D = $_GET["DOD"];
	//actor vars
	$aF = $_GET["aFNAME"];
	$aL = $_GET["aLNAME"];
	$aS = $_GET["aSEX"];
	$aB = $_GET["aDOB"];
	$aD = $_GET["aDOD"];
	// Empty Dates parsed as "NULL"
	if($B == "")
	{
		$B = "NULL";
	}	
	if($D == "")
	{
		$D = "NULL";
	}
	//Actor null handling
	if($aB == "")
	{
		$aB = "NULL";
	}	
	if($aD == "")
	{
		$aD = "NULL";
	}
	if($DorA == "dir"){
	echo "For Director you entered First = $F, Last = $L, DOB = $B, DOD = $D<br>";}
	if($DorA == "act"){
	echo "For Actor you entered $aF, Last = $aL, Sex = $aS, DOB = $aB, DOD = $aD<br>";}
	if($DorA == "dir")
	addDirector($F,$L,$B,$D);
	if($DorA == "act")
	addActor($aF,$aL,$aS,$aB,$aD);
} 
?>

</html>

