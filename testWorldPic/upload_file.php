<html>
<head>
<link rel="stylesheet" type="text/css" href="css/mystyle.css">
</head>
<?php

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 200000000)
&& in_array($extension, $allowedExts))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    echo "Type: " . $_FILES["file"]["type"] . "<br>";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("photos/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "photos/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "photos/" . $_FILES["file"]["name"];
      }
    }
	
	
	$OK = false;
	include('_includes/connection.php');
	if (isset($db) === true) 
	{
		// could use header redirection to error page
	}
	// create SQL statement which will insert any values that have been entered into the form text object
	//into the correct columns of the data table photographer, by using named parameters - see below
	$sql = 'INSERT INTO picture (PhotoName, LocationId, Comment, ID)
	VALUES(:photoname, :locationid, :comment, :id)';
	// prepare the statement to check for errors but do not execute the SQL statement yet
	$stmt = $db->prepare($sql);
	// bind the values in the forms text objects to named parameters and execute the statement
	$stmt->bindParam(':photoname', $_FILES["file"]["name"], PDO::PARAM_STR);
	$stmt->bindParam(':locationid', $_GET['LocationId'], PDO::PARAM_STR);
	$stmt->bindParam(':comment', $_POST['Comment'], PDO::PARAM_STR);
	$stmt->bindParam(':id', $_GET['id'], PDO::PARAM_STR);
	// execute and get number of affected rows
	$stmt->execute();
	$OK = $stmt->rowCount();
	// redirect if successful or display error
	if ($OK) 
	{
		header('Location: http://localhost/phpfiles/WDT-END-Semester-Assignment/testWorldPic/photographer.php?uploadsuc=yay');
		exit;
	} 
	else 
	{
		$error = $stmt->errorInfo();
		if (isset($error[2])) 
		{
			$errorMsg = $error[2];
		}
	}
  }
else
  {
  echo "Invalid file";
  }
?> 