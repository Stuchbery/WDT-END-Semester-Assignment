<?php
$numRows = 0;
if (isset($_GET['go']) && isset($_GET['search'])) {
include('_includes/connection.php');
if (isset($db) === true) {

    // prepare the SQL query

  $sql = 'SELECT ID, FirstName, LastName, Email, Password, nickname FROM photographer WHERE FirstName LIKE :search OR LastName LIKE :search';
  $searchterm = '%'. $_GET['search'] .'%';  // adding wild card characters
  $stmt = $db->prepare($sql);           //prepare method does not actually execute query
  $stmt->bindParam(':search', $searchterm, PDO::PARAM_STR);  //binding user input to parameter/variable search
  $stmt->bindColumn('ID', $id);
  $stmt->bindColumn('FirstName', $firstName);
  $stmt->bindColumn('LastName', $lastName);
  $stmt->bindColumn('Email', $email);
  $stmt->bindColumn('Password', $password);
  $stmt->bindColumn('NickName', $nickName);
  $stmt->execute();             // PDO method executes query statement when it has been prepared
  $numRows = $stmt->rowCount();
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Search For Photographer</title>
</head>

<body>
<form id="form1" method="get" action="">
  <input type="text" name="search" id="search">
  <input type="submit" name="go" id="go" value="Search">
</form>
<?php if (isset($_GET['search'])) { ?>
<p>Number of results for <b><?php echo htmlentities($_GET['search'], ENT_COMPAT, 'utf-8'); ?></b>: <?php echo $numRows; ?></p>
<?php if ($numRows>0) { ?>
<table border="1">
  <tr>
    <th scope="col">First Name</th>
    <th scope="col">Last Name</th>
    <th scope="col">Email</th>
    <th scope="col">Password</th>
    <th scope="col">Nick Name</th>
	<th scope="col">Update</th>
  </tr>
  <?php while ($stmt->fetch()) /* loop through associative array by getting the next row*/{ ?>
  <tr>
    <td><?php echo $firstName; ?></td>
    <td><?php echo $lastName; ?></td>
    <td><?php echo $email; ?></td>
    <td><?php echo $password; ?></td>
    <td><?php echo $nickName; ?></td>
	<td><a href ="updatePhotographer.php?id=<?php echo $id; ?>">Update Details</a></td>
  </tr>
  <?php } ?>
</table>
<?php }
}
} else {  ?>
<form id="form1" method="get" action="">
  <input type="text" name="search" id="search">
  <input type="submit" name="go" id="go" value="Search">
</form>
<?php }
?>
</body>
</html>