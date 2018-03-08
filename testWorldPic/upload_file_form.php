<html>
<head>
<link rel="stylesheet" type="text/css" href="css/mystyle.css">
</head>
<body>

<h2> Please select a location for where this new photograph was taken </h2>
<p align="left"> --------------------------------------------------------------------------------------------------------------------------</p>

<form>
<p align="left"><b>Select a WorldRegion </b>
<select id="setit" style="color: #0000FF" size="1" name="test">

	<?php
		include('_includes/connection.php');
		
		if(isset($db)===true) //database found!!!
		{
			$sql = "SELECT * FROM worldregion ORDER BY WorldRegionName";
			$query = $db->query($sql);
			
			while($row=$query->fetch(PDO::FETCH_ASSOC))
			{
				echo '<option value="upload_file_form.php?idWR='.$row['WorldRegionID'].'&id='.$_GET['id'].'">'.$row['WorldRegionName'].'</option>';
			}
		}
	?>	

<input type="button" value="Update" onclick="window.open(setit.options[setit.selectedIndex].value)">
</p></form>

<form align="left">
<p align="left"><b>Select a Country     </b>
<select id="setit2" style="color: #0000FF" size="1" name="test">

	<?php
	include('_includes/connection.php');
	if(!empty($_GET['idWR']))
		{
			$idWR =$_GET['idWR'];

			if(isset($db)===true) //database found!!!
			{
				$sql = "SELECT CommonName, CountryCode FROM `country` where WorldRegionID ='".$idWR."'";
				$query = $db->query($sql);
				
				while($row=$query->fetch(PDO::FETCH_ASSOC))
				{
					echo '<option value="upload_file_form.php?idCC='.$row['CountryCode'].'&idWR='.$_GET['idWR'].'&id='.$_GET['id'].'">'.$row['CommonName'].'</option>';
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

<form align="left">
<p align="left"><b>Select a Location    </b>
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
					echo '<option value="upload_file_form.php?idLOC='.$row['Locationid'].'&idCC='.$_GET['idCC'].'&idWR='.$_GET['idWR'].'&id='.$_GET['id'].'">'.$row['LocationName'].'</option>';
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

<p align="left"> --------------------------------------------------------------------------------------------------------------------------</p>
<?php
if(isset($_GET['idLOC']) === false || isset($_GET['idCC']) === false || isset($_GET['idWR']) === false)
{

}
else
{
	//a location has been selected 
	echo '<h2>Please select the file you wish to upload</h2>';
	
	echo '<form action="upload_file.php?LocationId='.$_GET['idLOC'].'&id='.$_GET['id'].'" method="post"
	enctype="multipart/form-data">
	<label for="file"></label>
	<input type="file" name="file" id="file"><br>
	<label for="Comment"></br>Add Comment to photograph:</label>
	<input name="Comment" type="text" id="Comment" value="">
	</br>
	<input type="submit" name="submit" value="Submit">
	</form>


<p align="left"> --------------------------------------------------------------------------------------------------------------------------</p>

';

}
?>
<a href="index.php?"> Return to search page </a><br/>
<a href="logout.php"> Logout </a><br/>
</body>
</html>