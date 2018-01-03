<?php
include ("dbConnector.php");
session_start();
$conn =getDBConnection();
$errorMessage="";

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
 
}
?>