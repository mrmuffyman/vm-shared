<!DOCTYPE html>
<html>

<h1> Kevin Lin: CS143 Calculator </h1> 
<p> Type an expression in the following box </p>
<form action="calculator.php" method="get">
<input type="text" name="expr"><input type="submit" value="Calculate">
</form>

<br>
<?php

$subject = $_GET["expr"];
$subject = preg_replace('/\s+/', '', $subject);
$pattern = "/(-?)([0-9\.]+)([\*\/])(-?)([0-9\.]+)/";
$paddern = "/(-?)([0-9\.]+)([\+\-])(-?)([0-9\.]+)/";
$invalid = "/[A-Za-z]|\-{2,}/";



function matchall($pattern,$subject){
while(preg_match($pattern, $subject, $matches)){	
	if($matches[1] != NULL){
		$matches[2] = -$matches[2];
	}
	if($matches[4] != NULL){
		$matches[5] = -$matches[5];
	}
#	echo "$matches[0] <br>";
#	echo "$matches[1] <br>";
#	echo "$matches[2] <br>";
#	echo "$matches[3] <br>";
#	echo "$matches[4] <br>";
#	echo "$matches[5] <br>";
	if($matches[3] == '/'){
		if($matches[5] == 0){
			$subject = NULL;
			return $subject;
		}
	}
	$result = eval("return $matches[2]$matches[3]$matches[5];");
	$subject = preg_replace($pattern, $result, $subject, 1);
}
return $subject;
}
if(preg_match($invalid, $subject)){
	echo "Invalid expression $subject <br>";
}
else{
$subject = matchall($pattern, $subject);
$subject = matchall($paddern, $subject);
echo "$subject<br>";
}

?>

</html>
