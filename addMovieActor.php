<!DOCTYPE html>
<html>

<h1> Add new Movie/Actor relation: </h1>

<?php 

include 'validation.php';

function displayMovieAndActor(){
 	$db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);
        
        $getMovies = "select title,year,id from Movie";
	$getActors = "select first,last,dob,id from Actor";
	$rs = mysql_query($getMovies, $db_connection);
	echo '<form action="addMovieActor.php" method="get">';
	echo 'Movies: <select name = "Movies">'; 
	while($row = mysql_fetch_row($rs)){	
        	echo "<option value=\"$row[2]\">$row[0] ($row[1]) </option>";
	}
	echo "</select> <br>";
	$rs = mysql_query($getActors, $db_connection);
	echo 'Actors: <select name = "Actors">';
	while($row = mysql_fetch_row($rs)){
		echo "<option value=\"$row[3]\"> $row[0] $row[1] ($row[2]) </option>";
	}
	echo "</select> <br>";
	echo "Role: <input type=\"text\" name=\"role\"> <input type=\"submit\" value=\"Add\">";
	echo "</form>";
	

	mysql_close($db_connection);
        return false;
}


function addMovieActor($mid, $aid, $r){
	$role = validateName($r);
	echo "$mid $aid $role";
	if(!$mid || ! $aid || ! $role){
		echo "Invalid Input";
		return false;
	}
	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);
	$insertQuery = "insert into MovieActor values($mid, $aid, $role)";
	$set = mysql_query($insertQuery, $db_connection);
}

//main 
displayMovieAndActor();



if($_GET)
{
	$movie = $_GET['Movies'];
	$actor = $_GET['Actors'];
	$role = $_GET['role'];
	
	addMovieActor($movie, $actor, $role);
}

?>










</html>
