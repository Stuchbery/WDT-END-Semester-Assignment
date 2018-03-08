<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/mystyle.css">
</head> 
<body>
<h1 align="center"> Search Photographs </h1>

<p align="center"> <a href="insertPhototgrapher.php">Register as a photographer here</a> </p>
<p align="center"> <a href="searchPhotographer_v2.php"> Search for a photographers details here</a> </p>

<?php
  if (!isset($_SESSION)) {
    session_start();  //apply settings to allow the use of session variables
  }
if ((!isset($_SESSION['Email'])) && (!isset($_SESSION['Password']))) 
{
	echo '<p align="center"> <a href="login.php">Login</a> </p>';
}
else
{	
		echo '<p align="center"> <a href="logout.php">Logout</a> </p>';
		echo '<p align="center"> <a href="photographer.php">Photographer control panel</a> </p>';
}
?>


<p align="center"> --------------------------------------------------------------------------------------------------------------------------</p>
<h2 align="center"> Basic Search</h2>
<form>
<p align="center"><b>Select a WorldRegion </b>
<select id="setit" style="color: #0000FF" size="1" name="test">

	<?php
		include('_includes/connection.php');
		
		if(isset($db)===true) //database found!!!
		{
			$sql = "SELECT * FROM worldregion ORDER BY WorldRegionName";
			$query = $db->query($sql);
			
			while($row=$query->fetch(PDO::FETCH_ASSOC))
			{
				echo '<option value="index.php?id='.$row['WorldRegionID'].'">'.$row['WorldRegionName'].'</option>';
			}
		}
	?>	

<input type="button" value="Update" onclick="window.open(setit.options[setit.selectedIndex].value)">
</p></form>

<form align="center">
<p align="center"><b>Select a Country     </b>
<select id="setit2" style="color: #0000FF" size="1" name="test">

	<?php
	include('_includes/connection.php');
	if(!empty($_GET['id']))
		{
			$id =$_GET['id'];

			if(isset($db)===true) //database found!!!
			{
				$sql = "SELECT CommonName, CountryCode FROM `country` where WorldRegionID ='".$id."'";
				$query = $db->query($sql);
				
				while($row=$query->fetch(PDO::FETCH_ASSOC))
				{
					echo '<option value="index.php?idCC='.$row['CountryCode'].'&id='.$_GET['id'].'">'.$row['CommonName'].'</option>';
				}
			}
		}
		else
		{
			//please make a selection from the previous dropdown box
		}
	?>	
	
<input type="button" value="Update" onclick="window.open(setit2.options[setit2.selectedIndex].value)">
</p></form>

<form align="center">
<p align="center"><b>Select a Location    </b>
<select id="setit2" style="color: #0000FF" size="1" name="test">

	<?php
	include('_includes/connection.php');
	if(!empty($_GET['idCC']))
		{
			$idin =$_GET['idCC'];

			if(isset($db)===true) //database found!!!
			{
				$sql = "SELECT LocationName, Locationid FROM `location` where CountryCode ='".$idin."'";
				$query = $db->query($sql);
				
				while($row=$query->fetch(PDO::FETCH_ASSOC))
				{
					echo '<option value="index.php?idLOC='.$row['Locationid'].'&idCC='.$_GET['idCC'].'&id='.$_GET['id'].'">'.$row['LocationName'].'</option>';
				}
			}
		}
		else
		{
			//please make a selection from the previous dropdown box
		}
	?>	
	
<input type="button" value="Submit" onclick="window.open(setit2.options[setit2.selectedIndex].value)">
</p></form>

<p align="center"> --------------------------------------------------------------------------------------------------------------------------</p>
<h2 align="center"> Advanced Search</h2>
<p align="center"> not case sensitive</p>
<form name="input" action="index.php" method="get">
<p align="center">
	Search Photographs by location name: <input type="text" name="idLOCname">
	<input type="submit" value="Submit">
</p></form> 

<h5 align="center">OR</h5>

<form name="input" action="index.php" method="get" align="center">
<p align="center">
	Search Photographs by photographers last name: <input type="text" name="idPHOLASTname">
	<input type="submit" value="Submit">
</p></form> 

<h5 align="center">OR</h5>

<form name="input" action="index.php" method="get" align="center">
<p align="center">
	Search Photographs by photographers first name: <input type="text" name="idPHOFIRSTname">
	<input type="submit" value="Submit">
</p></form> 
<p align="center"> --------------------------------------------------------------------------------------------------------------------------</p>


<h2 align="center">Search Results</h2>
<?php 
	include('_includes/connection.php');
	if (isset($db) === true) 
	{
		// could use header redirection to error page
	}
	if(!empty($_GET['idLOC']))																										//runs for the basic search functions
	{
		$idLOCin = ($_GET['idLOC']);
		$sql = "SELECT `PictureID`, `PhotoName`, `Comment` FROM `picture` where `LocationID`='".$idLOCin."'";						//search by location ID from PICTURE
	}
	elseif(!empty($_GET['idLOCname']))																								//runs for the advanced search functions	
	{
		$idLOCnamein = ($_GET['idLOCname']);
		$sql = "SELECT `PictureID` , `PhotoName` , `Comment` FROM `picture` WHERE `LocationID` IN ( SELECT `LocationId` FROM `location` WHERE `LocationName` LIKE '%".$idLOCnamein."%')";	//uses a subquery 
		echo '<p  align="center"> Displaying Photographs by location name containing the phrase "."<b>"'.$idLOCnamein.'"</b></p>';
	}
	elseif(!empty($_GET['idPHOLASTname']))																								//runs for the advanced search functions	
	{
		$idPHOLASTnamein = ($_GET['idPHOLASTname']);
		$sql = "SELECT `PictureID` , `PhotoName` , `Comment` FROM `picture` WHERE `ID` IN (SELECT ID FROM `photographer` WHERE `LastName` LIKE '%".$idPHOLASTnamein."%')";	//uses a subquery 
		echo '<p  align="center"> Displaying Photographs queried by photographer last name containing the phrase "."<b>"'.$idPHOLASTnamein.'"</b></p>';
	}
	elseif(!empty($_GET['idPHOFIRSTname']))																								//runs for the advanced search functions	
	{
		$idPHOFIRSTnamein = ($_GET['idPHOFIRSTname']);
		$sql = "SELECT `PictureID` , `PhotoName` , `Comment` FROM `picture` WHERE `ID` IN (SELECT ID FROM `photographer` WHERE `FirstName` LIKE '%".$idPHOFIRSTnamein."%')";	//uses a subquery 
		echo '<p  align="center"> Displaying Photographs queried by photographer first name containing the phrase "."<b>"'.$idPHOFIRSTnamein.'"</b></p>';
	}
	else
	{
		//header("Location: http://localhost/testWorldPic/index.php");
		exit();
	}
	//use an approach which mixes object oriented with mysql_ ... code
	// testing loop which is similar to using php "mysql_..." functions in appearance - loops through the associative array
	//$row = $query->fetch(PDO::FETCH_ASSOC)
	echo  "<p  align='center'> <br><em>Click on picture for more info</em></p>";
	$query = $db->query($sql);
	$numRows = $query->rowCount();
	echo '<p align="center"> Number of results: '.$numRows.'</p>';
	while($row=$query->fetch(PDO::FETCH_ASSOC))
	{
		//echo '<option value="index.php?idPIC='.$row['PictureID'].'&idLOC='.$_GET['idLOC'].'&idCC='.$_GET['idCC'].'&id='.$_GET['id'].'">'.$row['PhotoName'].'</option>';
		//echo 'photos/'.$row['PhotoName'];

		echo '
		<table border="1" align="center"> 
		<tr>
			<th scope="col"><h4>'.$row['PhotoName'].'</h4></th>
		  </tr>
		  <tr>
		  <td> <a href="SinglePictureAndInfo.php?PictureID='.$row['PictureID'].'&PhotoName='.$row['PhotoName'].'&Comment='.$row['Comment'].'" target="_blank"> <img src="photos/'.$row['PhotoName'].'"width="500" border="0"/> </a></td>
		  </tr>
		</table>
		';
	}
	
?>
</select>
</body>
</html>