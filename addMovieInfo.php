<!DOCTYPE html>
<html>

<h1> Add new movie: </h1>
<a href = "index.html"> Back to main page </a> <br><br>
<form action = "addMovieInfo.php" method = "get">
Title: <input type="text" name="title"> <br>
Company: <input type="text" name="company"> <br>
Year: <input type="text" name="year"> <br>
Rating: <input type="text" name="rating"> <br>
<input type="checkbox" name="chckbox[]" value="Action"> Action
<input type="checkbox" name="chckbox[]" value="Adult"> Adult
<input type="checkbox" name="chckbox[]" value="Adventure"> Adventure
<input type="checkbox" name="chckbox[]" value="Animation"> Animation
<input type="checkbox" name="chckbox[]" value="Comedy"> Comedy
<input type="checkbox" name="chckbox[]" value="Crime"> Crime
<input type="checkbox" name="chckbox[]" value="Documentary"> Documentary
<input type="checkbox" name="chckbox[]" value="Drama"> Drama
<input type="checkbox" name="chckbox[]" value="Family"> Family
<input type="checkbox" name="chckbox[]" value="Fantasy"> Fantasy
<input type="checkbox" name="chckbox[]" value="Horror"> Horror
<input type="checkbox" name="chckbox[]" value="Musical"> Musical
<input type="checkbox" name="chckbox[]" value="Mystery"> Mystery
<input type="checkbox" name="chckbox[]" value="Romance"> Romance
<input type="checkbox" name="chckbox[]" value="Sci-Fi"> Sci-Fi
<input type="checkbox" name="chckbox[]" value="Short"> Short
<input type="checkbox" name="chckbox[]" value="Thriller"> Thriller
<input type="checkbox" name="chckbox[]" value="War"> War
<input type="checkbox" name="chckbox[]" value="Western"> Western <br> 
<input type="submit" value="Add Movie">
</form>

<?php 

include 'validation.php';

function addMovie($t, $c, $y, $r, $g){
	$title = validateName($t);
	$company = validateName($c);
	$year = validateDate($y);
	$rating = validateName($r);
	$genres = array();
	if (isset($g)){
		for ($i = 0; $i < count($g); $i++){
			array_push($genres, $g[$i]);
		}
	}
	else {
		echo "Did not enter genre <br>";
		return false;
	}
	print_r($genres);
	echo "$title $company $year $rating";	
        if(! $title || ! $year || ! $company || ! $rating){
                // One of the user input texts was invalid
                echo "Invalid input";
                return false;
        }
        // Input is valid, build query and insert into DB!
        $db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);
        
	echo "Putting new Movie in DB <br>";
        // Specified Director is not in the DB yet, so grab an ID for it
        $getID = mysql_query("select * from MaxMovieID");
        $tuple1= mysql_fetch_row($getID);
        $idToInsert = $tuple1[0] + 1;
        // Now increment the one in the DB
        $incrementID = "update MaxMovieID set id = $idToInsert";
        $setID = mysql_query($incrementID, $db_connection);
        // Now add the new movie to the DB
        $insertMovie = "insert into Movie values($idToInsert,\"$title\", $year, \"$rating\", \"$company\")";
        $putMovie = mysql_query($insertMovie,$db_connection);
	
	for ($i = 0; $i < count($genres); $i++){
		$insertGenre = "INSERT INTO MovieGenre VALUES($idToInsert, \"$genres[$i]\")";
		$putGenre = mysql_query($insertGenre, $db_connection);
	}

        echo "Successfully added $title to the DB";
        mysql_close($db_connection);
        return false;
}

if($_GET)
{
	$title = $_GET["title"];
	$company = $_GET["company"];
	$year = $_GET["year"];
	$rating = $_GET["rating"];
	$genres = $_GET["chckbox"];	
	
	addMovie($title, $company, $year, $rating, $genres);
}

?>










</html>
