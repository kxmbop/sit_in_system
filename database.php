<?php
	$db_server = "localhost";
	$db_user = "root";
	$db_pass = "";
	$db_name = "sit_in_monitoring";
	$conn = "";

	try{
		$conn = mysqli_connect(	$db_server, 
		$db_user, 
		$db_pass, 
		$db_name);
	}
	catch(mysqli_sql_exception){
		echo"can't connect";
	}

	/*			
	if($conn){ echo"connected"; }
	else{ echo"can't connect!"; }
    */

?>