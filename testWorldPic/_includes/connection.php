<?php
$config['db'] = array (
             'host'       => 'localhost',
             'username'   => 'root',
             'password'   => '',
             'dbname'     => 'world_pic'
);
//uses an instantiation of the PDO class with the information that mysql is the database server to be used, plus other required information
try {
	$db = new   PDO('mysql:host='.$config['db']['host'].';dbname=' . $config['db']['dbname'],$config['db']['username'],$config['db']['password']);
 } catch (PDOException $e) {
  echo 'Cannot connect to database';
  } 

 
?>