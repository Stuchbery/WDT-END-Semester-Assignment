<?php include('_includes/connection.php');
if (isset($db) === true) 
	{
		// could use header redirection to error page
	}
	if(!empty($_GET['PictureID']) && !empty($_GET['PhotoName'])&& !empty($_GET['Comment']))
	{
		$done = false;	//boolean used to check if the comment has been submitted or not
		
		$PictureIDin = ($_GET['PictureID']);
		$PhotoNamein = ($_GET['PhotoName']);
		$Commentin = ($_GET['Comment']);
		//$sql = "SELECT `PictureID`, `PhotoName`, `Comment` FROM `picture` where `LocationID`='".$idLOCin."'";
		//echo "<br>PictureIDin: ".$PictureIDin;
		//echo "<br>PhotoNamein: ".$PhotoNamein;
		//echo "<br>Commentin: ".$Commentin;
		
		echo '
		<html>
		<head>
		<link rel="stylesheet" type="text/css" href="css/mystyle.css">
		<meta charset="utf-8">
		<title>Modify Photographer Details</title>

		</head>
		
		<table border="1"> 
		<tr>
			<th scope="col"><h2>Photograph Name: '.$PhotoNamein.'</h2></th>
		  </tr>
		  <tr>
		  <td align="center"> <a href="photos/'.$PhotoNamein.'" target="_blank"> <img src="photos/'.$PhotoNamein.'" border="0"/> </a></td>
		  </tr>
		  <tr>
			<td><b>Phototgraphers Comments:<b> '.$Commentin.'</td>
		  </tr>
		  
		</table>';
		echo '<h3> Public Comments </h3><br>';
		echo '-----------------------------------------------------------------------------------------------------------------------</br>';
		$sql = "SELECT `CommentBy` , `CommentDate` , `Comment` FROM `public_comment` WHERE `PictureID` = '".$PictureIDin."'";	
		
		$query = $db->query($sql);
		while($row=$query->fetch(PDO::FETCH_ASSOC))
		{
			/****************************************
			requires query to identify related comments in the public_comment table and a
			loop to display all comments about this picture
			********************************************/
			echo '
			<table border="1">
			<tr>
			<td> <b>'.$row['CommentBy'].'</b><em> on the '.$row['CommentDate'].' </em>: '.$row['Comment'].'</td>
			</tr>
			</table>
			</br>
			';
		}
		echo '-----------------------------------------------------------------------------------------------------------------------</br>';
		//add a comment code here
		if(!$done)
		{
			echo"<h3><u> Add your comment here </u><h3>";
		}
		include('_includes/connection.php');
		if (isset($db) === true) 
		{

			if (isset($_POST['update'])) 
			{
				/***********************************************************************************
				If the submit button has been clicked prepare update query.
				Assign named parameters to the contents of the posted form objects
				Note that some columns and related named parameters are not present
				***********************************************************************************/
				$CommentBy = $_POST['commentby'];
				$Comment = $_POST['comment'];
				
				//echo "</br>updating";
				//echo "</br>CommentBy: ".$CommentBy;
				//echo "</br>Comment: ".$Comment;
				//echo "</br>PictureID: ".$_GET['PictureID'];
				
				//$sql = 'UPDATE photographer SET FirstName = :firstName, LastName = :lastName WHERE ID = :id';
				
				$sql = "INSERT INTO public_comment (CommentBy, Comment, PictureID) VALUES ('".$CommentBy."', '".$Comment."', '".$_GET['PictureID']."')";
				
				$stmt = $db->prepare($sql);
				
				// execute query by passing array of variables
				$stmt->execute();  
				//print_r($stmt);
				$done = $stmt->rowCount();
			}
			// display error message if query fails
			if (isset($stmt) && !$done) 
			{
				$error = $stmt->errorInfo();
				if (isset($error[2])) 
				{
					$error = $error[2];
				}
			}
		}
		if (isset($error)) 
		{
			echo "<p>Error: $error</p>";
		}
		else 
		{
			if(!$done)
			{
				// :O
			}
			else
			{
				echo "</br>Your Comment has been posted";
				echo '<<a href="SinglePictureAndInfo.php?PictureID='.$_GET['PictureID'].'&PhotoName='.$_GET['PhotoName'].'&Comment='.$_GET['Comment'].'"> Click to update Page</a>';
			}
			echo'
			<form id="form1" method="POST" action="">
			<p>
			<label for="commentby">Name:</label>
			<input name="commentby" type="text" id="commentby" value="">
			</p>
			<p>
			<label for="comment">Comment:</label>
			<input name="comment" type="text" id="comment" value="">
			</p> 
			<p>
			<input type="submit" name="update" value="Post Comment" id="update">
			<input name="id" type="hidden" value="<?php echo $id; ?>">
			</p>
			</form>';
			
			$_POST['PictureID']=$_GET['PictureID'];
		
		}
		echo '
		</body>
		</html>';
	}
	else
	{
		echo "Error Picture details not passed correctly via GET method";
	}
?>
	<a href="index.php?"> Return to search page </a><br/>
