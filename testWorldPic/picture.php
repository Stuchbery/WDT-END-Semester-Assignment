<?php include('_includes/connection.php');
if (isset($db) === true) {
	// could use header redirection to error page
}
if(!empty($_GET['id'])){
$id = intval($_GET['id']);
    $sql = "SELECT `PictureID`, `PhotoName`, `Comment` FROM `picture` where `PictureID`='".$id."'";
}else{
//header("Location: http://localhost/testWorldPic/index.php");
exit();
}
//use an approach which mixes object oriented with mysql_ ... code
$query = $db->query($sql);
// testing loop which is similar to using php "mysql_..." functions in appearance - loops through the associative array
$row = $query->fetch(PDO::FETCH_ASSOC)
?>
<table border="1">
  <tr>
    <th scope="col"><h4>Photograph Name: <?php echo $row['PhotoName']; ?></h4></th>
  </tr>
  <tr>
  <td><img src="photos/<?php echo $row['PhotoName']; ?>"></td>
  </tr>
  <tr>
    <td><em>Details provided by phototgrapher</em></td>
  </tr>
  <tr>
    <td><?php echo $row['Comment']; ?></td>
  </tr>
  <tr>
  <td><?php echo '<a href="apageofyourchoice.php?id=' .$row['PictureID']. '">Add Comments</a>' ?></td>
  </tr>
  <?php /****************************************
  requires query to identify related comments in the public_comment table and a
  loop to diplay all comments about this picture
  ********************************************/
  ?>
  <tr>
  <td>Comments</td>
  </tr>
</table>


