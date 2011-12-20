<?php
session_start();
require_once "resources/config.php";
/**
 * Check User
 *
 * Issue a GET 'a' to get $subjectID
 */
if (isset($_GET['a']) && $_GET['a'] !== ""){
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
		if ($subject->competed == 0){
			$formKey = new formKey();
			/**
			 * Check if subject has already answered this question by checking no result in database
			 */
			try{
				$stmt = $dbh->prepare("SELECT question1 FROM responses WHERE subjectID = :subjectID");
				$stmt->bindParam(":subjectID", $subject->subjectID, PDO::PARAM_STR, 11);
				$stmt->execute();
				$stmt->setFetchMode(PDO::FETCH_OBJ);
				$data = $stmt->fetch();
			}catch(PDOException $e){
				echo $e->getMessage();
			}
			if ($data == false){
	
				/**
				 * Check if the subject submitted an answer to the first question
				 */
				if (isset($_POST['submit'])){
					/**
					 *Protect Against CRSF
					 */
					if(!isset($_POST['form_key']) || !$formKey->validate()){
						$error = "Please Try Submitting the Form Again";
					}else{
						/**
						 * Submit Answer
						 *
						 * Store Answer in Database & Redirect to Second Question
						 */
						try{
							$stmt = $dbh->prepare("INSERT INTO responses (subjectID, question1) VALUES (:subjectID, :response)");
							$stmt->bindParam(":subjectID", $subject->subjectID, PDO::PARAM_STR, 11);
							$stmt->bindParam(":response", $_POST['question1'], PDO::PARAM_STR, 11);
							$stmt->execute();
							$stmt->setFetchMode(PDO::FETCH_OBJ);
						}catch(PDOException $e){
							echo $e->getMessage();
						}
						$_SESSION['subjectID'] = $subject->subjectID;
						header("Location: continue-survey.php?a=".base64_encode($subject->subjectID));
					}
				}
				get_header();
				?>
				<form action="" method="post">
					<?php $formKey->outputKey(); ?>
					<p><?php echo $subject->fname;?>, thank you for taking a moment to take our survey. Please try to answer each question the the best of you ability.</p>
					<?php if (isset($error)){?><p class="error"><?php echo $error;?></p><?php }?>
					<fieldset>
						<legend><?php echo $control_question;?></legend>
						<label for="question1">Please answer on a scale of 1-5, where one is no school spirit and five is a lot of school spirit.</label>
						<p>
							<input name="question1" id="question1" type="text" title="<?php echo $control_question;?>" class="fd-form-element-hidden"/>
						</p>
						<script>
							fdSlider.createSlider({
							// Associate an input
							inp:document.getElementById("question1"),
							// Declare a step
							step:0.1,
							// Declare a maxStep (for keyboard users)
							maxStep:0.4,
							// Min value
							min:0,
							// Max value
							max:5,
							// Use the "tween to clickpoint" animation
							animation:"tween",
							// Force a value
							forceValue:true
							});
						</script>
					</fieldset>
					<div class="actionable">
						<center><input class="large awesome " type="submit" name="submit" value="Next &raquo;" /></center>
					</div>
				</form>
			<?php }else{
				get_header();
				echo $subject->fname;?>, you have already answered this question. Please click on the link below to advance to the next question.
                <a class="large awesome" href="continue-survey.php?a=<?php echo base64_encode($subject->subjectID);?>">Next &raquo;</a>
			<?php }
		}else{
			get_header();
			echo $subject->fname;?>, you have already finished this survey. Thank you for submitting it.<?php			
		}
	}else{
		get_header();
		?>Something has gone wrong. Please try clicking on that link again, if it continues to happen please email <a href="mailto:<?php echo $project_manager_email;?>"><?php echo $project_manager_email;?></a><?php
    }
}else{
	get_header();?>
	Something has gone wrong. Please try clicking on that link again, if it continues to happen please email <a href="mailto:<?php echo $project_manager_email;?>"><?php echo $project_manager_email;?></a>
<?php }
get_footer();
?>