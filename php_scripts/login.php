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

?>
