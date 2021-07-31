<?php
session_start();
$my_token = $_SESSION['token'];

$connect = mysqli_connect("localhost","root","","machine_test");

extract($_POST);
if($token != $my_token){
	echo "CSRF token missing!";
} else{

	$profile = $_FILES['file']['name'];
	$temp = $_FILES['file']['tmp_name'];

	$query= "INSERT INTO users(name,email,profile) values('$name','$email','$profile')";

	if(mysqli_query($connect, $query)){
		$upload = 'err'; 
		if(!empty($_FILES['file'])){ 
			 
			// File upload configuration 
			$targetDir = "uploads/"; 
			$allowTypes = array('pdf', 'doc', 'docx', 'jpg', 'png', 'jpeg', 'gif'); 
			 
			$fileName = basename($_FILES['file']['name']); 
			$targetFilePath = $targetDir.$fileName; 
			 
			// Check whether file type is valid 
			$fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION); 
			if(in_array($fileType, $allowTypes)){ 
				// Upload file to the server 
				if(move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)){ 
					$upload = 'ok'; 
				} 
			} 
		} 
		echo $upload;
	}
}
?>