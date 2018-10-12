<?php

if(isset($_GET["id"]) && !isset($_GET["amound"])){
	require_once("../php_script.php");
	$script = new FunctionScript();

	$id=$_GET["id"];
	//TODO before execution of sql queries check if current user has right to access
 	$response = $script->getPersonFromDB($id);
 	echo json_encode($response);
}

if(isset($_GET["id"]) && isset($_GET["amound"])){
	require_once("../php_script.php");
	$script = new FunctionScript();
	
	$id=$_GET["id"];
	$amound = $_GET["amound"];
	$response = $script->updateAccountBalanceOfUser($id, $amound);
 	echo json_encode($response);
}

if(isset($_GET["productId"]) && isset($_GET["productNumber"])){
	require_once("../php_script.php");
	$script = new FunctionScript();

	$id=$_GET["productId"];
	$number = $_GET["productNumber"];
	$response = $script->updateProductNumber($id, $number);
 	echo json_encode($response);
}

if(isset($_GET['accountBalanceRequested'])){
	require_once("../php_script.php");
    $script = new FunctionScript();

	$response = $script->getAccountBalanceOfCurrentUser();
	echo json_encode($response);
}

if(isset($_REQUEST["first_name"]) && isset($_REQUEST["last_name"]) &&isset($_REQUEST["email"]) && isset($_REQUEST["customer_img"])){
  $firstname = $_REQUEST["first_name"];
  $lastname = $_REQUEST["last_name"];
  $email = $_REQUEST["email"];
  $telefon = $_REQUEST["telefon"];
	$imaga_name = $_REQUEST["customer_img"];

	require_once("php_script.php");
    $script = new FunctionScript();

    $userInserted = $script->insertUser($firstname, $lastname, $email, $telefon, $imaga_name);
}

if(isset($_REQUEST["articleBoughtRequsted"])){
	require_once("login.php");
	include("dbConnector.php");
	$db = new dbConnector();
	$conn = $db->getDBConnection();

	if(!isset($_REQUEST["selectedArticleId"])){
		echo json_encode("No article selected to buy");
		exit;
	}

	$selectedArticleId = $_REQUEST["selectedArticleId"];
  $personId =  getSessionUserId();
	$sql = 'INSERT INTO person_article_matrix (person_id, article_id, count, buy_date) VALUES ('.$personId.','.$selectedArticleId.',1,now())';
	$result = mysqli_query($conn, $sql);

	if ($result === TRUE) {
    echo "New record created successfully";
    //Send email on user
    notifyUserForPurchasedArticle($personId, $selectedArticleId);
	} else {
		echo "Error: ". $sql . "<br>" . $conn->error;
	}
	$conn->close(); 
}
$errorByInsertedUser ="success";
// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	require_once("../php_script.php");
	
	$script = new FunctionScript();
	define ('SITE_ROOT', realpath(dirname(__DIR__)));
	
    // Check if file was uploaded without errors
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0 && $_REQUEST["first_name"] && $_REQUEST["last_name"] && $_REQUEST["email"] && $_REQUEST["telefon"]){
		
    	$firstname = $_REQUEST["first_name"];
    	$lastname = $_REQUEST["last_name"];
    	$email = $_REQUEST["email"];
    	$tel = $_REQUEST["telefon"];
		  $filename = $_FILES["photo"]["name"];

		$userInserted = $script->insertUser($firstname, $lastname, $email, $tel, $filename);

        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png","PNG" => "image/PNG");
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
    
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
            if(file_exists("img/" . $filename)){
                $errorByInsertedUser = $filename . " is already exists.";
            } else{
            	if($userInserted == TRUE){
                	move_uploaded_file($_FILES["photo"]["tmp_name"], SITE_ROOT.'/img/' . $filename);
                	$errorByInsertedUser = "User and picture inserting successfully";
                }
            } 
        } else{
            $errorByInsertedUser = "Error: There was a problem uploading your file. Please try again.";
        }
    } else{
        $errorByInsertedUser = "Error: " . $_FILES["photo"]["error"];
	}
	echo json_encode($errorByInsertedUser);
	header("Refresh:0; url=../index.php");
}

function notifyUserForPurchasedArticle($personId, $selectedArticleId){
  require_once("send_email.php");
  require_once("../php_script.php");
  $script = new FunctionScript();

  $personToNotify = $script->getPersonById($personId);
  $articleObject = getArticle($selectedArticleId);

  $htmlContent = '
    <html>
    <head>
        <title>Flex Kitchen</title>
    </head>
  <body>
      <div>
        <p>Hallo '.$personToNotify->firstname.',</p>
        <p>Ein '.$articleObject->name.' ist am '.date().' von Dir gekauft</p><br/>
        <p>Dies ist eine automatisch erstellte E-Mail. Bitte ANTWORTE NICHT auf diese Mail</p>
      </div>
    <br/>
    <p>Viele Grüße </p>
    <p>Flex Kitchen </p>
    </body>
    </html>';
    echo $htmlContent;
    $subject = "Du hast eine Getränke gekauft ".date();
    sendEmailToCustomer($person->email, $htmlContent, $subject);
}

?>
