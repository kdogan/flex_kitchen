<?php
include ("dbConnector.php");
session_start();
$conn =getDBConnection();

$errorMessage="";

// Remove Session
if(isset($_GET['destroySessionRequested']) && $_GET['destroySessionRequested'] ==1){
	
	if(isset($_SESSION['var'])){
		session_unset(); 
		session_destroy();
	}
	$response['isSessionDestroyed'] = true;
	echo json_encode($response);
}

// Create Session
if(isset($_GET['user_id'])){
	$userId = $_GET['user_id'];
	$succes = setSession($userId);
	$response['isSessionCreated'] = $succes;
	echo json_encode($response);
}

// Login requested
if(isset($_POST['login'])) {
  $email = $_POST['email'];
  $passwort = $_POST['passwort'];
 
  $statement = $conn->prepare("SELECT * FROM person WHERE email = :email");
  $result = $statement->execute(array('email' => $email));
  $user = $statement->fetch();
 
  //Überprüfung des Passworts
  if ($user !== false && password_verify($passwort, $user['passwort'])) {
  	 $_SESSION['userid'] = $user['id'];
 	 $_SESSION['isAdmin'] = $user['is_admin'];
 	 die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
  } else {
 	 $errorMessage = "E-Mail oder Passwort war ungültig<br>";
  }
 $conn->close();
}


function setSession($userId){
	$sql = 'SELECT * FROM person WHERE id ='.$userId;
	$conn =getDBConnection();
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
    	while($row = $result->fetch_assoc()) {
        	$_SESSION['userid'] = $row["id"];
        	$_SESSION['isAdmin'] = $row['is_admin'];
    	}
    	return true;
	} else {
    	return false;
	}
	
	$conn->close();     
}

?>