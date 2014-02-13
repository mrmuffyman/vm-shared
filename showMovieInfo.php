<!DOCTYPE html>
<html>
<a href = "index.html"> Back to main page </a> <br><br><?php

if($_GET){
        $entry = $_GET["mid"];
        $db_connection = mysql_connect("localhost", "cs143", "");
        mysql_select_db("CS143", $db_connection);
        $query1 = "SELECT M.title, M.year, M.rating, M.company FROM Movie M WHERE M.id = $entry";
	$query2 = "SELECT D.first, D.last, D.dob FROM MovieDirector MD, Director D WHERE $entry = MD.mid AND MD.did = D.id";
	$genreQuery = "SELECT MG.genre FROM MovieGenre MG WHERE MG.mid = $entry";
        $rs1 = mysql_query($query1, $db_connection);
        if($rs1){
                $row = mysql_fetch_row($rs1);
                echo "Showing Movie Information: <br>";
                echo "Title: $row[0] <br>";
                echo "Producer: $row[3] <br>";
                echo "Year: $row[1] <br>";
		echo "MPAA Rating: $row[2] <br>";
        }
	$genreRS = mysql_query($genreQuery, $db_connection);
	if($genreRS){
		echo "Genre: ";
		while($row = mysql_fetch_row($genreRS)){
			echo "$row[0] ";
		}
		echo "<br>";
	}
	$rs2 = mysql_query($query2, $db_connection);
	if($rs2){
		echo "Directors: ";
		while ($row = mysql_fetch_row($rs2)){
			echo "$row[0] $row[1] ($row[2]) ";
		}
		echo "<br><br>";
	}
        $query3 = "SELECT MA.role, A.first, A.last, A.id FROM MovieActor MA, Actor A WHERE MA.mid = $entry AND MA.aid = A.id";
        $rs3 = mysql_query($query3, $db_connection);
        if($rs3){
                echo "Showing Actors in this Movie:<br>";
                while($row = mysql_fetch_row($rs3)){
                        echo "<a href=\"showActorInfo?$row[3]\">$row[1] $row[2]</a> as \"$row[0]\" <br>";
                }
        }
	echo "<br><br>";
	
	$query4 = "SELECT name, time, rating, comment FROM Review WHERE mid = $entry;";
	$avg = "SELECT AVG(rating) FROM Review WHERE mid = $entry;";
	$rs4 = mysql_query($query4, $db_connection);
	$rs5 = mysql_query($avg, $db_connection);
	$temp = mysql_fetch_row($rs5);
	if($rs4){
		echo "Average rating for this movie $temp[0]         <a href=\"addReview.php?mid=$entry\"> Add a review </a><br>";
		while($row = mysql_fetch_row($rs4)){
			echo "Review by $row[0]: <br>";
			echo "Rating: $row[2] Time: $row[1] <br>";
			echo "$row[3] <br> ---------<br>";
		}
	} 
}

?>
	
        <p> Search for other Actors/Movies </p>
        <form action = "search.php" method="get">
        <input type="text" name="query"> <input type="submit" value = "Search">
        </form>
</html>

