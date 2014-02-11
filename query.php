<!DOCTYPE html>
<html>

<h1> Query Page: CS143 </h1>
<p> Enter your query in the following form </p>
<form action = "query.php" method ="get">
<textarea name = "query" cols="60" rows = "8"> </textarea> <input type = "submit" value = "Submit">
</form>
<br>

<?php

if($_GET){

	$query = $_GET["query"]; 

	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);

	$rs = mysql_query($query, $db_connection);
	$numfields = mysql_num_fields($rs);
	$count = 0;
	echo '<table border = "1">';
	echo "<tr>"; 
	while ($count < $numfields){
		$info =  mysql_fetch_field($rs, $count);
		echo "<td>$info->name </td> ";
		$count++;
	}
	echo "</tr>";	
	while ($row = mysql_fetch_row($rs)) {
		echo "<tr>";
		$count = 0;
		while($count < $numfields){
			if($row[$count])
				echo  "<td> $row[$count] </td>";
			else
				echo "<td>N/A </td> ";
			$count++;
		}
		echo "</tr>";
	}
	echo "</table>";
	mysql_close($db_connection);
	}

?>

</html>
