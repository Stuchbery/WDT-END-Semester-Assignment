<?php include('_includes/connection.php');
if (isset($db) === true) 
{
	// could use header redirection to error page
}
if(!empty($_GET['id']))
{
$id =$_GET['id'];
//echo "Countries:".$id;
	//$sql = "SELECT LocationName, Locationid FROM `location` where CountryCode = 'AU'";
	$sql = "SELECT LocationName, Locationid FROM `location` where CountryCode ='".$id."'";
}
else
{
//header("Location: http://localhost/testWorldPic/index.php");
exit();
}
//use an approach which mixes object oriented with mysql_ ... code
$query = $db->query($sql);
// testing loop which is similar to using php "mysql_..." functions in appearance - loops through the associative array
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
     echo'<a href="picture.php?id=' .$row['Locationid']. '">' .$row['LocationName']. '</a><br/>';
}

//uses PDO methods code
/*
foreach ($db->query($sql) as $row) {
     echo'<a href="locations.php?id=' .$row['CountryCode']. '">' .$row['CommonName']. '</a><br/>';
}
*/
?>