<?php

if(isset($_GET["id"]) && !isset($_GET["amound"])){
	$id=$_GET["id"];
	//TODO before execution of sql queries check if current user has right to access
 	$response = getPersonFromDB($id);
 	echo json_encode($response);
}

if(isset($_GET["id"]) && isset($_GET["amound"])){
	$id=$_GET["id"];
	$amound = $_GET["amound"];
	$response = updateAccountBalanceOfUser($id, $amound);
 	echo json_encode($response);
}

if(isset($_GET["productId"]) && isset($_GET["productNumber"])){
	$id=$_GET["productId"];
	$number = $_GET["productNumber"];
	$response = updateProductNumber($id, $number);
 	echo json_encode($response);
}

function updateAccountBalanceOfUser($userId, $amound){
	require_once("dbConnector.php");
	$db = new dbConnector();
	$conn = $db->getDBConnection();
	$person = getPersonFromDB($userId);
	$oldAccountBalance = floatval($person["account_balance"]);
	$newAccountBalance = $oldAccountBalance + floatval($amound);
	$response = "";
	$sql = 'UPDATE person SET account_balance = '.$newAccountBalance.'WHERE id ='.$userId;

	if ($conn->query($sql) === FALSE) {
    	$response = "Error updating record: " . $conn->error;
	}else{
		$response = array('newBalance'=>(string)$newAccountBalance);
	}
	return $response;
	$conn->close(); 
}

function updateProductNumber($productId, $productNumber){
	require_once("dbConnector.php");
	$db = new dbConnector();
	$conn = $db->getDBConnection();
	$product = getProductFromDB($productId);
	$oldAccountBalance = floatval($product["count"]);
	$newAccountBalance = $oldAccountBalance + $productNumber;
	$response = "";
	$sql = 'UPDATE article SET count = '.$newAccountBalance.' WHERE id ='.$productId;

	if ($conn->query($sql) === FALSE) {
    	$response = "Error updating record: " . $conn->error;
	}else{
		$response = array('newCount'=>(string)$newAccountBalance);
	}
	return $response;
	$conn->close(); 
}

function getPersonFromDB($userId){
	require_once("dbConnector.php");
	$db = new dbConnector();
	$conn = $db->getDBConnection();
	$sql = 'SELECT * FROM person WHERE is_admin="0" and id ='.$userId;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $response['id'] = $row["id"];
	        $response['firstname'] = $row["firstname"];
	        $response['lastname'] =$row["lastname"];
	        $response['email'] = $row["email"];
	        $response['img_path'] = $row["img_path"];
	        $response['account_balance'] = $row["account_balance"];
	    }
	    return $response;
	} else {
	    return "-1";
	}
	$conn->close(); 
}

function getProductFromDB($productId){
	require_once("dbConnector.php");
	$db = new dbConnector();
	$conn = $db->getDBConnection();
	$sql = 'SELECT * FROM article WHERE id ='.$productId;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $response['id'] = $row["id"];
	        $response['name'] = $row["name"];
	        $response['price'] = $row["price"];
	        $response['count'] = $row["count"];
	        $response['category'] = $row["category"];
	        $response['img_path'] = $row["img_path"];
	    }
	    return $response;
	} else {
	    return "-1";
	}
	$conn->close(); 
}

function getCategoriesFromDB(){
	require_once("dbConnector.php");
	$db = new dbConnector();
	$conn = $db->getDBConnection();
	$sql = 'SELECT * FROM category';
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
	    while($row = $result->fetch_assoc()) {
	        $response[$row["id"]] = $row["name"];
	    }
	    return $response;
	} else {
	    return "-1";
	}
	$conn->close(); 
}
if(isset($_REQUEST["first_name"]) && isset($_REQUEST["last_name"]) &&isset($_REQUEST["email"]) && isset($_REQUEST["customer_img"])){
	require_once("dbConnector.php");
    $db = new dbConnector();
    $conn = $db->getDBConnection();
    $firstname = $_REQUEST["first_name"];
    $lastname = $_REQUEST["last_name"];
    $email = $_REQUEST["email"];
    $telefon = $_REQUEST["telefon"];
    $imaga_name = "img/".$_REQUEST["customer_img"];

    $sql = 'INSERT INTO person (firstname, lastname, email, tel_no, img_path, account_balance, is_admin, user_pw) 
    		VALUES ("'.$firstname.'","'.$lastname.'","'.$email.'",'.$telefon.',"'.$imaga_name.'", 0, 0,"cfcd208495d565ef66e7dff9f98764da")';
    $result = $conn->query($sql);
    if($conn->query($sql)){
        echo "Records added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
}

if(isset($_REQUEST["person_id"]) && isset($_REQUEST["selectedArticleId"])){
	include("dbConnector.php");
	$db = new dbConnector();
	$conn = $db->getDBConnection();

	$selectedArticleId = $_REQUEST["selectedArticleId"];
	$personId =  $_REQUEST["person_id"];

	$sql = 'INSERT INTO person_article_matrix (person_id, article_id, count, buy_date) VALUES ('.$personId.','.$selectedArticleId.',1,CURDATE())';
	$result = mysqli_query($conn, $sql);

	if(isset($selectedArticleId) && isset($personId)){

	if ($result === TRUE) {
		echo "New record created successfully";
	}
	} else {
	echo "Error: ". $sql . "<br>" . $conn->error;
	}

$conn->close(); 
}
?>
