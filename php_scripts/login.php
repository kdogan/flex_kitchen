<?php
session_start();
$errorMessage="";

// Remove Session
if(isset($_GET['destroySessionRequested']) && $_GET['destroySessionRequested'] ==1){
	$response['isSessionDestroyed'] = true;
	echo json_encode($response);
}

// Create Session
if(isset($_GET['user_id'])){
	$userId = $_GET['user_id'];
	$succes = setSession("id", $userId);
	$response['isSessionCreated'] = $succes;
	echo json_encode($response);
}

if(isset($_GET['logoutRequested'])){
	session_unset();
	session_destroy();
	$response['logout'] = 1;
	echo json_encode($response);
}

// Login requested
if(isset($_GET['admin_login_requested'])) {
  if(!isset($_REQUEST['email'])){
	  echo json_encode("Email missing!");
	  exit;
  }
 
  $email = $_REQUEST['email'];
  $sessionCreated = setSession("email", "\"".$email."\"");
  if($sessionCreated){
 	  $errorMessage="Login success!";
	  $host  = $_SERVER['HTTP_HOST'];
	  $extra = 'index.php';
	  //Hacy only for localtest
	  if(strpos($host, 'localhost') !== false){
		  $extra = "flex_kitchen".$extra;
	  }
 	 header("Location: http://$host/$extra");
  } else {
 	 $errorMessage = "E-Mail oder Passwort war ungültig<br>";
  }
  echo json_encode($errorMessage);
}

function setSession($attributeName, $attributeValue){
	require_once("./dbConnector.php");
    $db = new dbConnector();
    $conn = $db->getDBConnection();

	session_unset();
	$sql = 'SELECT * FROM person WHERE '.$attributeName.'='.$attributeValue;
	$result = $conn->query($sql);
	if ($result->num_rows > 0 ) {
    	while($row = $result->fetch_assoc()) {
    		//TODO activate here if password re
    		if(md5($_REQUEST['password']) != $row['user_pw']){
    			$errorMessage ="wrong password";	
    			return 0;
    		}
    		$errorMessage =  "session is created";

        	$_SESSION['userid'] = $row["id"];
        	$_SESSION['isAdmin'] = $row['is_admin'];
			$_SESSION['userName'] = $row['firstname'].' '.$row['lastname'];
        	$_SESSION['imagePath'] = $row['img_path'];
		}
    	return 1;
	} else {
    	return 0;
	}
	
	$conn->close();     
}

function hasSession(){
	if(count($_SESSION) > 0){
		return 1;
	}
	else{
	   return 0;
	}
}
function isAdmin(){
	if(hasSession()){
		if($_SESSION["isAdmin"] == 0){
			return 0;
		}else{
			return 1;
		}
	}else{
		return 0;
	}
}

function getSessionUserId(){
	return $_SESSION['userid'];;
}
function getCurrentUserName(){
 return $_SESSION['userName'];
}
function getCurrentUserImagePath(){
	$imagePath = $_SESSION['imagePath'];
	if($imagePath == ""){
		return 'img/default_user_img.png';
	}
	return $imagePath;
}
?>
