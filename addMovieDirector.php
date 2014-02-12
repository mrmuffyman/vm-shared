<!DOCTYPE html>
<html>

<h1> Add new Movie/Director relation: </h1>
<a href = "index.html"> Back to main page </a> <br><br><?php 

include 'validation.php';

function displayMovieAndDirector(){
 	$db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);
        
        $getMovies = "select title,year,id from Movie";
	$getDirectors = "select first,last,dob,id from Director";
	$rs = mysql_query($getMovies, $db_connection);
	echo '<form action="addMovieDirector.php" method="get">';
	echo 'Movies: <select name = "Movies">'; 
	while($row = mysql_fetch_row($rs)){	
        	echo "<option value=\"$row[2]\">$row[0] ($row[1]) </option>";
	}
	echo "</select> <br>";
	$rs = mysql_query($getDirectors, $db_connection);
	echo 'Directors: <select name = "Directors">';
	while($row = mysql_fetch_row($rs)){
		echo "<option value=\"$row[3]\"> $row[0] $row[1] ($row[2]) </option>";
	}
	echo "</select> <br>";
	echo "<input type=\"submit\" value=\"Add\">";
	echo "</form>";
	

	mysql_close($db_connection);
        return false;
}


function addMovieDirector($mid, $did){
	if(!$mid || ! $did){
		echo "Invalid Input";
		return false;
	}
	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);
	$insertQuery = "INSERT INTO MovieDirector VALUES($mid, $did)";
	$set = mysql_query($insertQuery, $db_connection);
	mysql_close($db_connection);
}

//main 
displayMovieAndDirector();



if($_GET)
{
	$movie = $_GET['Movies'];
	$director = $_GET['Directors'];
	
	addMovieDirector($movie, $director);
}

?>










</html>
