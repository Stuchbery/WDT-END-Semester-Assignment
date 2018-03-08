<?php
include('_includes/connection.php');
if (isset($db) === true) {
    // prepare the SQL query
$OK = false;
$done = false;
// get details of selected record
//if (isset($_GET['id']) && !$_POST) {
  if (isset($_GET['id'])) {
  // prepare SQL query
  $sql = 'SELECT ID, FirstName, LastName, Email, Password, nickname FROM photographer
		  WHERE ID = ?';
  $stmt = $db->prepare($sql);
  // bind the results using numbers to reference the columns used in the select statement
  $stmt->bindColumn(1, $id);
  $stmt->bindColumn(2, $firstName);
  $stmt->bindColumn(3, $lastName);
  $stmt->bindColumn(4, $email);
  $stmt->bindColumn(5, $password);
  $stmt->bindColumn(6, $nickname);
  // execute query by passing array of variables
  $OK = $stmt->execute(array($_GET['id']));
  $stmt->fetch();
}
// if form has been submitted, update record
if (isset($_POST['update'])) {
 
 /***********************************************************************************
If the submit button has been clicked prepare update query.
Assign named parameters to the contents of the posted form objects
Note that some columns and related named parameters are not present
***********************************************************************************/
 $sql = 'UPDATE photographer SET FirstName = :firstName, LastName = :lastName WHERE ID = :id';
  $stmt = $db->prepare($sql);
  $stmt->bindParam(':firstName', $_POST['firstname'], PDO::PARAM_STR);
  $stmt->bindParam(':lastName', $_POST['lastname'], PDO::PARAM_STR);
  $stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);		    
  // execute query by passing array of variables
  $stmt->execute();  
  print_r($stmt);
  $done = $stmt->rowCount();
}
// redirect if $_GET['id'] not defined
if ($done || !isset($_GET['id'])) {
  header('Location: http://localhost/testWorldPic/searchPhotographer.php');
  exit;
}
// display error message if query fails
if (isset($stmt) && !$OK && !$done) {
  $error = $stmt->errorInfo();
  if (isset($error[2])) {
	$error = $error[2];
  }
}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Modify Photographer Details</title>

</head>

<body>
<h1>Update Blog Entry</h1>
<p><a href="searchPhotographer.php">Check modify success </a></p>
<?php 
if (isset($error)) {
  echo "<p>Error: $error</p>";
}
if($id == 0) { ?>
  <p>Invalid request: record does not exist.</p>
<?php } else { ?>
<form id="form1" method="POST" action="">
  <p>
    <label for="firstname">First Name:</label>
    <input name="firstname" type="text" id="firstname" value="<?php echo htmlentities($firstName, ENT_COMPAT, 'utf-8'); ?>">
  </p>
  <p>
    <label for="lastname">First Name:</label>
    <input name="lastname" type="text" id="lastname" value="<?php echo htmlentities($lastName, ENT_COMPAT, 'utf-8'); ?>">
  </p> 
  <p>
    <input type="submit" name="update" value="Update Entry" id="update">
    <input name="id" type="hidden" value="<?php echo $id; ?>">
  </p>
</form>
<?php } ?>
</body>
</html>