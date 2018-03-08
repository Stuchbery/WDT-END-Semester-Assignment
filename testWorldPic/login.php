<?php
//declare variable and initialise
$numRows = 0;
$msg='';
if (isset($_POST['login']) && isset($_POST['username'])  && isset($_POST['password'])) {
include('_includes/connection.php');
if (isset($db) === true) {
	// could use header redirection to error page
 
		// prepare the SQL query
	
	  $query = 'SELECT ID, Email, Password FROM photographer WHERE Email = :username AND Password = :password';
	  $email =  trim($_POST['username']) ;  // remove the space
	  $password = trim($_POST['password']);
	  $stmt = $db->prepare($query);           //prepare method does not actually execute query
	  $stmt->bindParam(':username', $email, PDO::PARAM_STR);  //binding user input to parameter/variable search
      $stmt->bindParam(':password', $password, PDO::PARAM_STR);  //binding user input to parameter/variable search
	  $stmt->bindColumn('ID', $id); //binding column results to variables	  
	  $stmt->bindColumn('Email', $email);
	  $stmt->bindColumn('Password', $password);
	  $stmt->execute();             // PDO method executes query statement when it has been prepared
	  //Show all row that chosen----------------
	  $row= $stmt->fetchAll(PDO::FETCH_ASSOC);
		
	  //-----------------------------------------		
	  $numRows = $stmt->rowCount();	  	  
	

   if (empty($row)=== false){
       if (!isset($_SESSION)) //check to see if session has logged in already
	   {
          session_start();  //apply settings to allow the use of global session variables
       }
         $_SESSION['Email'] = $email;     //naming elements in the global array $_SESSION and assigning the contents of variables
         $_SESSION['Password'] = $password;
         //redirecting to photographer.php page
         //header("Location: http://localhost/testWorldPic/photographer.php" );
         header("Location: http://localhost/phpfiles/WDT-END-Semester-Assignment/testWorldPic/photographer.php" );
      //echo '<pre>' .print_r($row). '</pre>';    code used during testing
  }
  else 
  {
     $msg = 'Error please try again';
  }
  }
}
?>
<?php
/***********************************************************************
See form if this is the first time the page has loaded or they failed to enter the correct information
*******************************************************************************/
 echo '<h3>'.$msg. '</h3>'; ?>
<form id="form1" method="POST" action="">
  Email:
  <input type='text' name='username' id="username">
  <br>
  Password:
  <input type='password' name='password' id="password">
  <br>
  <input type='submit' name="login" id="login" value='Log in'  >
  
</form>

