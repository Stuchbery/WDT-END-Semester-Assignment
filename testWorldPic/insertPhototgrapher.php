<?php

if (isset($_POST['insert'])) {
  // initialize flag
  $OK = false;
include('_includes/connection.php');
if (isset($db) === true) {
	// could use header redirection to error page
}
  // create SQL statement which will insert any values that have been entered into the form text object
  //into the correct columns of the data table photographer, by using named parameters - see below
  $sql = 'INSERT INTO photographer (FirstName, LastName, Email, Password, nickname)
		  VALUES(:firstName, :lastName, :email, :password, :nickName)';
  // prepare the statement to check for errors but do not execute the SQL statement yet
  $stmt = $db->prepare($sql);
  // bind the values in the forms text objects to named parameters and execute the statement
  $stmt->bindParam(':firstName', $_POST['firstName'], PDO::PARAM_STR);
  $stmt->bindParam(':lastName', $_POST['lastName'], PDO::PARAM_STR);
  $stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
  $stmt->bindParam(':password', $_POST['password'], PDO::PARAM_STR);
  $stmt->bindParam(':nickName', $_POST['nickName'], PDO::PARAM_STR);
  // execute and get number of affected rows
  $stmt->execute();
  $OK = $stmt->rowCount();
  // redirect if successful or display error
  if ($OK) {
	header('Location: http://localhost/testWorldPic/searchPhotographer.php');
	exit;
  } else {
	$error = $stmt->errorInfo();
	if (isset($error[2])) {
	  $errorMsg = $error[2];
    }
  }
}
 if (isset($errorMsg)) {
  echo "<p>Error: $errorMsg</p>";
} 
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Insert Photographer Details</title>
<link href="" rel="stylesheet" type="text/css">
</head>

<body>
<h1>Insert New Photographer</h1>

<form id="form1" method="post" action="">
  <p>
    <label for="firstName">FirstName:</label>
    <input name="firstName" type="text" id="firstName">
  </p>
  <p>
    <label for="lastName">Last Name:</label>
    <input name="lastName" type="text" id="lastName">
  </p>
  <p>
    <label for="email">Email:</label>
    <input name="email" type="text" id="email">
  </p>
  <p>
    <label for="password">Password:</label>
    <input name="password" type="text" id="password">  </p>
  <p>
    <label for="nickName">Nickname:</label>
    <input name="nickName" type="text"  id="nickName">
  </p>
  <p>
    <input type="submit" name="insert" value="Insert New Entry" id="insert">
  </p>
</form>
</body>
</html>