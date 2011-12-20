<?php
/**
 *Functions
 *
 *Includes all required public functions
 */

function get_header(){
	global $title;
	include_once "header.php";	
}
function get_footer( $name = null ){
	include_once "footer.php";
}
class formKey{
	//Here we store the generated form key
	private $formKey;

	//Here we store the old form key (more info at step 4)
	private $old_formKey;

	//The constructor stores the form key (if one excists) in our class variable
	function __construct(){
		//We need the previous key so we store it
		if(isset($_SESSION['form_key']))
		{
			$this->old_formKey = $_SESSION['form_key'];
		}
	}

	//Function to generate the form key
	private function generateKey(){
		//Get the IP-address of the user
		$ip = $_SERVER['REMOTE_ADDR'];

		//We use mt_rand() instead of rand() because it is better for generating random numbers.
		//We use 'true' to get a longer string.
		//See http://www.php.net/mt_rand for a precise description of the function and more examples.
		$uniqid = uniqid(mt_rand(), true);

		//Return the hash
		return md5($ip . $uniqid);
	}

	//Function to output the form key
	public function outputKey(){
		//Generate the key and store it inside the class
		$this->formKey = $this->generateKey();
		//Store the form key in the session
		$_SESSION['form_key'] = $this->formKey;

		//Output the form key
		echo "<input type='hidden' name='form_key' id='form_key' value='".$this->formKey."' />";
	}

	//Function that validated the form key POST data
	public function validate(){
		//We use the old formKey and not the new generated version
		if($_POST['form_key'] == $this->old_formKey){
			//The key is valid, return true.
			return true;
		}
		else{
			//The key is invalid, return false.
			return false;
		}
	}
}
function retrive_question($subjectID){
	global $dbh, $question_1, $question_2;
	try{
		$stmt = $dbh->prepare("SELECT treatment FROM subjects WHERE subjectID = :subjectID");
		$stmt->bindParam(":subjectID", $subjectID, PDO::PARAM_STR, 11);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_OBJ);
		$data = $stmt->fetch();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	if ($data->treatment == 1){
		return $question_1;
	}elseif($data->treatment == 0){
		return $question_2;
	}
}
function assign_treatment($gender, $athlete){
	global $dbh;
	try{
		$stmt = $dbh->prepare("SELECT subjectID FROM subjects WHERE gender = :gender AND athlete = :athlete");
		$stmt->bindParam(":gender", $gender, PDO::PARAM_INT, 1);
		$stmt->bindParam(":athlete", $athlete, PDO::PARAM_INT, 1);
		$stmt->execute();
		$stmt->setFetchMode(PDO::FETCH_OBJ);
		$group = $stmt->fetchAll();
	}catch(PDOException $e){
		echo $e->getMessage();
	}
	$treatment = array();
	while (count($treatment) < round(sizeof($group)/2)) {
		$r = mt_rand(0,sizeof($group)-1);
		if (!in_array($r,$treatment)) $treatment[] = $r;
	}
	$message = "";
	foreach($treatment as $value){
		try{
			$stmt = $dbh->prepare("UPDATE subjects SET treatment = '1' WHERE subjectID = :subjectID");
			$stmt->bindParam(":subjectID", $group[$value]->subjectID, PDO::PARAM_INT, 11);
			$stmt->execute();
		}catch(PDOException $e){
			echo $e->getMessage();
		}
		$message .= "<li>Subject ".$group[$value]->subjectID."</li>";
	}
}
?>