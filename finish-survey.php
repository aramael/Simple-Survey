<?php
/**
 *Template Index Page
 *
 */
require_once "resources/config.php";
$title = "";
if (isset($_GET['a']) && $_GET['a'] !== "" && $_GET['a'] == base64_encode($_SESSION['subjectID'])){
	try{
		$stmt = $dbh->prepare("SELECT * FROM subjects WHERE subjectID = :subjectID");
		$stmt->bindParam(":subjectID", base64_decode($_GET['a']), PDO::PARAM_INT, 11);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_OBJ);
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	/**
	 * Check if subjectID is valid against database
	 */
	if($stmt->rowCount() == 1){
		$subject = $stmt->fetch();
		/**
		 * Check if subject has already finished the entire survey
		 */
		if ($subject->competed == 1){

			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= "From: ".$project_manager." <".$project_manager_email."> \n";
			$headers .= "To-Sender: \n";
			$headers .= "X-Mailer: PHP\n"; // mailer
			$headers .= "Reply-To: ".$project_manager." <".$project_manager_email.">\n"; //Return Path for errors
			$headers .= "Content-Type: text/html; charset=iso-8859-1"; //Enc-type
			$emailSubject = "Thank You";
			$message ="
				<html>
				<head>
				  <title>".$subject."</title>
				</head>
				<body>
					<p>Dear ".$subject->fname.",</p>
					
					<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you very much for taking time the time to answer our questions. Your responses have been recorded.</p>
									
					<p>Sincerely,<br/>
					".$project_manager."
				</body>
				</html>
			";
			@mail($email,$subject,$message,$headers);
		

			get_header();?>

			Thank you for submitting the survey.

			<?php
			get_footer();
		}
	}
}
?>