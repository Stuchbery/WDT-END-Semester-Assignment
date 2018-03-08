<!DOCTYPE html>
<html>
<body>

<form>
<p align="center"><b>Select a WorldRegion </b>
<select id="setit" style="color: #0000FF" size="1" name="test">

	<?php
	echo "test";
		include('_includes/connection.php');
		
		if(isset($db)===true) //database found!!!
		{
			//echo '<option value="volvo">Volvo</option>';
			$sql = "SELECT * FROM worldregion ORDER BY WorldRegionName";
			$query = $db->query($sql);
			
			while($row=$query->fetch(PDO::FETCH_ASSOC))
			{
				echo '<option value="dropdown.php?id='.$row['WorldRegionID'].'">'.$row['WorldRegionName'].'</option>';
			}
		}
	?>
<input type="button" value="Go" onclick="window.open(setit.options[setit.selectedIndex].value)">

</p></form>

<form>
<p align="center"><b>Select a Country </b>
<select id="setit2" style="color: #0000FF" size="1" name="Countries">

	<?php
	echo "test2";
		if(!empty($_GET['id']))
		{
			$id =$_GET['id'];
			echo "Countries:".$id;
				//$sql = "SELECT LocationName, Locationid FROM `location` where CountryCode = 'AU'";
				$sql = "SELECT LocationName, Locationid FROM `location` where CountryCode ='".$id."'";
			
			if(isset($db)===true) //database found!!!
			{
				//echo '<option value="volvo">Volvo</option>';
				$sql = "SELECT * FROM worldregion ORDER BY WorldRegionName";
				$query = $db->query($sql);
				
				while($row=$query->fetch(PDO::FETCH_ASSOC))
				{
					echo '<option value="dropdown.php?idCC='.$row['CountryCode'].'">'.$row['CommonName'].'</option>';
				}
			}
		}
		else
		{
			//please make a selection from the previous dropdown box
		}
	?>
<input type="button" value="Go" onclick="window.open(setit2.options[setit2.selectedIndex].value)">

</p></form>


</select>
</body>
</html>