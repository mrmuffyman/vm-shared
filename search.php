<!DOCTYPE html>
<html>

<h1> Search Page</h1>
<p> Search for Actor/Movie </p>
<form action = "search.php" method ="get">
<input type="text" name="query"><input type="submit" value="Search">
</form>
<br>

<?php

function constructActorQuery($params){
	$list = array();
	for($i = 0; $i < count($params);$i++){
		$query = "SELECT DISTINCT A.first, A.last, A.dob,A.id FROM Actor A WHERE (A.last LIKE '%$params[$i]%' OR A.first LIKE '%$params[$i]%')";
		array_push($list, $query);
	}
//	print_r($list);
	$result = $list[0];
	for($i = 1; $i < count($list); $i++){
		$result .= " AND (A.first,A.last,A.dob,A.id) IN ";
		$result .= "(" .  $list[$i];
	}
	for($i = 1; $i < count($list); $i++){
		$result .= ")";
	}
	$result .= ";";
	return $result;
}

function constructMovieQuery($params){
        $list = array();
        for($i = 0; $i < count($params);$i++){
                $query = "SELECT DISTINCT M.title,M.year,M.id FROM Movie M WHERE M.title LIKE '%$params[$i]%'";
                array_push($list, $query);
        }
  //    print_r($list);
        $result = $list[0];
        for($i = 1; $i < count($list); $i++){
                $result .= " AND (M.title,M.year,M.id) IN ";
                $result .= "(" .  $list[$i];
        }
        for($i = 1; $i < count($list); $i++){
                $result .= ")";
        }
        $result .= ";";
        return $result;
}
	 
if($_GET){

	$entry = $_GET["query"]; 
	$params = explode(" ", $entry);

	$db_connection = mysql_connect("localhost", "cs143", "");
	mysql_select_db("CS143", $db_connection);
	
	$ActorQuery = constructActorQuery($params); 
	$MovieQuery = constructMovieQuery($params);		
//	echo "$ActorQuery<br><br>";
//	echo "$MovieQuery<br>";
	$rs1 = mysql_query($ActorQuery, $db_connection);
	if($rs1){
		processActorQuery($rs1);
	}
	$rs2 = mysql_query($MovieQuery, $db_connection);
	if($rs2){
		processMovieQuery($rs2);
	}

	mysql_close($db_connection);
	}

function processActorQuery($rs){
	echo "Searching matching records in Actor database.. <br>";
        while ($row = mysql_fetch_row($rs)) {
 		echo "Actor: <a href = \"showActorInfo.php?aid=$row[3]\"> $row[0] $row[1] ($row[2]) </a> <br>";               }
}

function processMovieQuery($rs){
	echo "Searching matching records in Movie database.. <br>";
	while($row = mysql_fetch_row($rs)){
		echo "Movie: <a href = \"showMovieInfo.php?mid=$row[2]\"> $row[0] ($row[1]) </a> <br>";
	}
} 
?>

</html>
