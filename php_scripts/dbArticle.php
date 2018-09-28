<?php
include("dbConnector.php");

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
	require_once("../php_script.php");
	
	$script = new FunctionScript();
	define ('SITE_ROOT', realpath(dirname(__DIR__)));
    
    $articleInserted ="success";
    // Check if file was uploaded without errors
    if(isset($_FILES["product_img"]) && $_FILES["product_img"]["error"] == 0 && $_REQUEST["product_name"] && $_REQUEST["product_category"] && $_REQUEST["product_price"]){
		
    	$articleName = $_REQUEST["product_name"];
    	$category = $_REQUEST["product_category"];
    	$price = $_REQUEST["product_price"];
		$filename = $_FILES["product_img"]["name"];

		$articleInserted = $script->insertArticle($articleName, $category, $price, $filename);
        
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png","PNG" => "image/PNG");
        $filetype = $_FILES["product_img"]["type"];
        $filesize = $_FILES["product_img"]["size"];
    
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)){
        	$articleInserted = "Error: Please select a valid file format.";
        }
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024;
        if($filesize > $maxsize){
        	$articleInserted ="Error: File size is larger than the allowed limit.";
        } 
    
        // Verify MYME type of the file
        if(in_array($filetype, $allowed)){
            if(file_exists("img/" . $filename)){
                $articleInserted = $filename . " is already exists.";
            } else{
            	if($articleInserted == TRUE){
                	move_uploaded_file($_FILES["product_img"]["tmp_name"], SITE_ROOT.'/img/' . $filename);
                	$articleInserted = "User and picture inserting successfully";
                }
            } 
        } else{
            $articleInserted = "Error: There was a problem uploading your file. Please try again.";
        }
    } else{
        $articleInserted = "Error: " . $_FILES["product_img"]["error"];
    }
	echo json_encode($articleInserted);
	header("Refresh:0; url=../index.php");
}

if(isset($_GET["id"])){
    $id = $_GET["id"];
    $db = new dbConnector();
    $conn = $db->getDBConnection();
    $sql = 'SELECT * FROM article WHERE id ='.$id;
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response['id'] = $row["id"];
            $response['name'] = $row["name"];
            $response['price'] =$row["price"];
            $response['img_path'] = $row["img_path"];
        }
        echo json_encode($response);
    } else {
        echo "Error: ". $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

?>
