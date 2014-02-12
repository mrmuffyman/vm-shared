<!DOCTYPE html>
<html>
<a href = "index.html"> Back to main page </a> <br><br><?php

if($_GET){
	$entry = $_GET["aid"];
	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);
	
	$query = "SELECT first, last, sex, dob, dod FROM Actor WHERE id = $entry";
	$rs1 = mysql_query($query, $db_connection);
	if($rs1){
		$row = mysql_fetch_row($rs1);
		echo "Showing Actor Information: <br>";
		echo "Name: $row[0] $row[1] <br>";
		echo "Sex: $row[2] <br>";
		echo "Date of Birth: $row[3] <br>";
		if($row[4] == NULL)
			$dod = "Still Alive";
		else
			$dod = $row[4];
		echo "Date of Death: $dod <br><br>";
	}
	$query2 = "SELECT MA.role, M.title, M.id FROM MovieActor MA, Movie M WHERE MA.aid = $entry AND MA.mid = M.id";
	$rs2 = mysql_query($query2, $db_connection);
	if($rs2){
		echo "Showing movies this actor has been in:<br>";
		while($row = mysql_fetch_row($rs2)){
			echo "Act \"$row[0]\" in <a href=\"showMovieInfo.php?mid=$row[2]\"> $row[1] </a> <br>";
		}  
	}
	
}
	
?>
	<p> Search for other Actors/Movies </p>
	<form action = "search.php" method="get"> 
	<input type="text" name="query"> <input type="submit" value = "Search"> 
	</form> 	
</html>
