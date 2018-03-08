<?php include('_includes/connection.php');
if (isset($db) === true) 
{
    // prepare the SQL query
    $sql = "SELECT * FROM worldregion ORDER BY WorldRegionName"; // could use header redirection to error page
}
$query = $db->query($sql);
/*
//test 1 = testing output of $query which shows a PDO statement

print_r($query);
$rows = $query->fetch(PDO::FETCH_ASSOC);
print_r($rows);
*/
//test 2 = testing loop which is similar to using php "mysql_..." functions in appearance - loops through the associative array
while ($row = $query->fetch(PDO::FETCH_ASSOC)){
     echo '<a href="countries.php?id=' .$row['WorldRegionID']. '">' .$row['WorldRegionName']. '</a><br/>';
}


//uses PDO methods code
/*
foreach ($db->query($sql) as $rows) {
     echo '<a href="countries.php?id=' .$rows['WorldRegionID']. '">' .$rows['WorldRegionName']. '</a><br/>';
}
*/
?>