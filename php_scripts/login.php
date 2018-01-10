<?php
include ("dbConnector.php");
session_start();
$conn =getDBConnection();

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
	$_SESSION['userid'] = "-1";
    $_SESSION['isAdmin'] = "-1";
	$response['logout'] = "succeeded";
	echo json_encode($response);
}

// Login requested
if(isset($_GET['login'])) {
  
  $sessionCreated = setSession("email", "\"".$_REQUEST['email']."\"");
  if($sessionCreated)
 	 $errorMessage="Login success!";
 	 $host  = $_SERVER['HTTP_HOST'];
 	 $extra = 'flex_kitchen/index.php';
 	 if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin']==="1"){
	 	$extra = 'flex_kitchen/admin.php';
	 }

	 	
 	 header("Location: http://$host/$extra");
  } else {
 	 $errorMessage = "E-Mail oder Passwort war ungültig<br>";
  }
 $conn->close();



function setSession($attributeName, $attributeValue){

	session_unset();
	$sql = 'SELECT * FROM person WHERE '.$attributeName.'='.$attributeValue;
	$conn =getDBConnection();
	$result = $conn->query($sql);
	if ($result->num_rows > 0 ) {
    	while($row = $result->fetch_assoc()) {
    		//TODO activate here if password re
    		if(md5($_REQUEST['password']) != $row['user_pw']){
    			$errorMessage ="wrong password";	
    			return false;
    		}
    		$errorMessage =  "session is created";

        	$_SESSION['userid'] = $row["id"];
        	$_SESSION['isAdmin'] = $row['is_admin'];
    	}
    	return true;
	} else {
    	return false;
	}
	
	$conn->close();     
}

function hasSession(){
	if(array_key_exists('userid', $_SESSION)){
	   if($_SESSION['userid'] =="-1"){
		return 0;
	   }else{
		return 1;
	   }
	}
	else{
	   return 0;
	}
}
function isAdmin(){
	if(hasSession()){
		if($_SESSION["isAdmin"] == 0 || $_SESSION["isAdmin"] == -1){
			return 0;
		}else{
			return 1;
		}
	}else{
		return 0;
	}
}

function getSessionUserId(){
	if(hasSession()){
	   $uId = $_SESSION['userid'];
	   return $uId;
	}else{
	   return -1;
	}
}

?>
