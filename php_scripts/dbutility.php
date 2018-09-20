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
    $firstname = $_REQUEST["first_name"];
    $lastname = $_REQUEST["last_name"];
    $email = $_REQUEST["email"];
    $telefon = $_REQUEST["telefon"];
    $imaga_name = $_REQUEST["customer_img"];

    $userInserted = insertUser($firstname, $lastname, $email, $telefon, $imaga_name);
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

$successfullyByInsertedUser = $errorByInsertedUser = "";

define ('SITE_ROOT', realpath(dirname(__DIR__)));
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0 && $_REQUEST["first_name"] && $_REQUEST["last_name"] && $_REQUEST["email"] && $_REQUEST["telefon"]){
    	$firstname = $_REQUEST["first_name"];
    	$lastname = $_REQUEST["last_name"];
    	$email = $_REQUEST["email"];
    	$tel = $_REQUEST["telefon"];
    	$img_path = $_FILES["photo"]["name"];
    	$userInserted = insertUser($firstname, $lastname, $email, $tel, $img_path);

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "PNG"=>"image/PNG");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)){
        	$errorByInsertedUser = "Error: Please select a valid file format.";
        }
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize){
        	$errorByInsertedUser ="Error: File size is larger than the allowed limit.";

        } 
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            // Check whether file exists before uploading it
            if(file_exists("img/" . $_FILES["photo"]["name"])){
                //echo $_FILES["photo"]["name"] . " is already exists.";
                $errorByInsertedUser = $_FILES["photo"]["name"] . " is already exists.";
            } else{
            	if($userInserted == TRUE){
                	move_uploaded_file($_FILES["photo"]["tmp_name"], SITE_ROOT.'/img/' . $_FILES["photo"]["name"]);
                	//echo "Your file was uploaded successfully.";
                	$successfullyByInsertedUser = "User iserted successfully";
                }
            } 
        } else{
            //echo "Error: There was a problem uploading your file. Please try again.";
            $errorByInsertedUser = "Error: There was a problem uploading your file. Please try again.";
        }
    } else{
        //echo "Error: " . $_FILES["photo"]["error"];
        $errorByInsertedUser = "Error: " . $_FILES["photo"]["error"];
    }
}

function insertUser($firstname, $lastname, $email, $telefon, $img_path){
	require_once("dbConnector.php");
    $db = new dbConnector();
    $conn = $db->getDBConnection();

    $imaga_name = "img/".$img_path;

    $sql = 'INSERT INTO person (firstname, lastname, email, tel_no, img_path, account_balance, is_admin, user_pw) 
    		VALUES ("'.$firstname.'","'.$lastname.'","'.$email.'",'.$telefon.',"'.$imaga_name.'", 0, 0,"cfcd208495d565ef66e7dff9f98764da")';

    $result = $conn->query($sql);
    if($result){
        $successfullyByInsertedUser = "Records added successfully.";
    } else{
        $errorByInsertedUser = "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
    return $result;
}
?>
