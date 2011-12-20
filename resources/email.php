<?php

require_once "config.php";

try{
	$stmt = $dbh->prepare("SELECT subjectID, fname, lname FROM subjects WHERE completed = 0");
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_OBJ);
	$data = $stmt->fetchAll();
}catch(PDOException $e){
	echo $e->getMessage();
}

$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= "From: ".$project_manager." <".$project_manager_email."> \n";
$headers .= "To-Sender: \n";
$headers .= "X-Mailer: PHP\n"; // mailer
$headers .= "Reply-To: ".$project_manager." <".$project_manager_email.">\n"; //Return Path for errors
$headers .= "Content-Type: text/html; charset=iso-8859-1"; //Enc-type
$subject = "";

foreach($data as $user){
	$email = $user->fname."_".$user->lname."@horacemann.org";
	$email = str_replace( " ","_" , $email);
	/*$message = "";*/
	$message ="
		<html>
		<head>
		  <title>".$subject."</title>
		</head>
		<body>
			<p>Dear ".$user->fname.",</p>
			
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;INSERT INTRODUCTION We estimate that it will take you approximately less than a minute to complete the survey. Simply click on the link below, or cut and paste the entire URL into your browser to access the survey:</p>
			
			<p><a href='".$project_url."/?a=".base64_encode($user->subjectID)."'>".$project_url."/?a=".base64_encode($user->subjectID)."</a></p>
			
			<p>We would appreciate your response by December 23rd 2011.<br/>
			Your input is very important to us and will be kept strictly confidential and anonymous (used only for the purposes of research for this project).<br/>
			If you have any questions or would prefer to complete a paper survey please email me at ".$project_manager."a at <strong>".$project_manager_email."</strong></p>
			
			<p>Sincerely,<br/>
			".$project_manager."<br/>
			
			<p>If you experience technical difficulties accessing or submitting the survey please contact ".$project_manager." at <strong>".$project_manager_email."</strong> or respond to this email.</p>
		</body>
		</html>
	";
	@mail($email,$subject,$message,$headers);
	echo "<p>------------------------------------<br/>".$email."<br/>------------------------------------</p>";
}

?>