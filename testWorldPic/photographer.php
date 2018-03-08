<?php
$numRows = 0;
$msg = '';
  if (!isset($_SESSION)) {
    session_start();  //apply settings to allow the use of session variables
  }
  if ((!isset($_SESSION['Email'])) && (!isset($_SESSION['Password']))) {
    header("Location: http://localhost/testWorldPic/login.php" );
    exit;
  }
  else {
  include('_includes/connection.php');
  if (isset($db) === true) {
 // prepare the SQL query
  $sql = 'SELECT ID, FirstName, LastName, Email, Password, nickname  FROM photographer WHERE  Email = :email and Password = :password';
  $email = $_SESSION['Email'];  // assign form objects to variables
  $password = $_SESSION['Password'];
  $query = $db->prepare($sql);           //prepare method does not actually execute query
  //the bindColumn method binds the data returned in the columns of the SQL query to a variable - columns are case sensitive
  $query->bindColumn('ID', $id);
  $query->bindColumn('FirstName', $firstName);
  $query->bindColumn('LastName', $lastName);
  $query->bindColumn('nickname', $nickName);
 // $query->bindColumn('Email', $email);
 // $query->bindColumn('Password', $password);
  $query->bindParam(':email', $email, PDO::PARAM_STR);  //binding user input to named parameters/variable search
  $query->bindParam(':password', $password, PDO::PARAM_STR);  //binding user input to named parameters/variable search
  $query->execute();             // PDO method executes query statement when it has been prepared
/*************************************************************************************************************************************
//code below results in the same out put as above
  $email = $_SESSION['Email'];  // assign form objects to variables
  $password = $_SESSION['Password'];
  $sql = "SELECT FirstName, LastName, Email, Password, nickname  FROM photographer WHERE  Email='".$email."' AND Password='".$password."'";
  $query = $db->prepare($sql);
  $query->bindValue('Email', $email);
  $query->bindValue('Password', $password);
  //the bindColumn method binds the data returned in the columns of the SQL query to a variable
  $query->bindColumn('FirstName', $firstName);
  $query->bindColumn('LastName', $lastName);
  $query->bindColumn('nickname', $nickName);
  $query->execute();
*****************************************************************************************************************************/
  $row = $query->fetch(PDO::FETCH_ASSOC) ;
   if (empty($row)=== false){
       $msg = 'Hello '. $email .', '.$password;


      }//both form objects have been set
  } //connection to database is successful
}  // login details have been submitted
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Photographer</title>
</head>
<body>
<table border="1">
  <tr>
    <th scope="col">First Name</th>
    <th scope="col">Last Name</th>
    <th scope="col">Email</th>
    <th scope="col">Password</th>
    <th scope="col">Nick Name</th>
  </tr>
  <tr>
    <td><?php echo $firstName; ?></td>
    <td><?php echo $lastName; ?></td>
    <td><?php echo $email; ?></td>
    <td><?php echo $password; ?></td>
    <td><?php echo $nickName; ?></td>
  </tr>
</table>
<a href="updatePhotographer.php?id=<?php echo $id; ?>"> Modify Photographer Details </a><br/>
<a href="logout.php"> Logout </a><br/>
</body>
</html>