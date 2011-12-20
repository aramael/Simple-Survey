<?php
date_default_timezone_set('America/Los_Angeles');

/*				SERVER AUTH
***********************************************/
$db_Host = "localhost";
$db_Name = DATABASE_NAME;
$db_User = DATABASE_USER;
$db_Pass = DATABASE_PASSWORD;

/*			  PROJECT CONSTANTS
***********************************************/
$question_1 = BIASED_QUESTION_1;
$question_2 = BIASED_QUESTION_2;
$control_question = CONTROL_QUESTION;
$project_manager = "";
$project_manager_email = "";
$project_name = "";

/*			  PDO DB INFORMATION
***********************************************/
try {
	$dbh = new PDO("mysql:host=".$db_Host.";dbname=".$db_Name, $db_User, $db_Pass);
}
catch(PDOException $e){
	echo $e->getMessage();
}

//Include Functions
include "functions.php";
?>