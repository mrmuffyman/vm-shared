<!DOCTYPE html>
<html>

<?php

$mid = $_GET["mid"];
$db_connection = mysql_connect("localhost","cs143","");
mysql_select_db("CS143", $db_connection);
$query = "SELECT title FROM Movie WHERE id = $mid";
$rs = mysql_query($query, $db_connection);
$row = mysql_fetch_row($rs);
$movie = $row[0];


?>


<h1> Add new review for <?php echo "$movie" ?>: </h1>
 
<a href = "index.html"> Back to main page </a> <br><br>
<form action = "addReview.php" method = "get">
Movie: <select name = "mid">
<?php 
	echo "<option value = \"$mid\"> $movie </option>";
?>
	</select><br> 
Name: <input type="text" name="name"> <br>
Rating: <select name="rating"> 
	<option value="1"> 1 </option>
	<option value="2"> 2 </option>
	<option value="3"> 3 </option>
	<option value="4"> 4 </option>
	<option value="5"> 5 </option>
	</select>
Comment: <br>
<textarea name = "comment" cols="60" rows = "8"> </textarea>
<input type="submit" value="Add Review">
</form>

<?php 
if($_GET["comment"] && $_GET["name"] && $_GET["rating"]){
        $comment = $_GET["comment"];
        $name = $_GET["name"];
        $rating = $_GET["rating"];
        $time = time();
        $sqldate = date( 'Y-m-d H:i:s' , $time);
        $insert = "INSERT INTO Review VALUES (\"$name\", \"$sqldate\", $mid, $rating, \"$comment\")";
        $rs = mysql_query($insert, $db_connection);


echo "Review submitted! <br>";

}
echo "Return to movie information <a href=\"showMovieInfo?mid=$mid\"> here </a> <br>";


?>


</html>
