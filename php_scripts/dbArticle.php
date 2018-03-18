<?php
include("dbConnector.php");


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

if(isset($_REQUEST["product_name"]) && isset($_REQUEST["product_category"]) && isset($_REQUEST["product_price"]) && isset($_REQUEST["product_img"]) ){
    $db = new dbConnector();
    $conn = $db->getDBConnection();
    $name = $_REQUEST["product_name"];
    $price = $_REQUEST["product_price"];
    $category = $_REQUEST["product_category"];
    $imaga_name = "img/".$_REQUEST["product_img"];

    $sql = 'INSERT INTO article (name, price, count, category, img_path) VALUES ("'.$name.'",'.$price.',0,'.$category.',"'.$imaga_name.'")';
    $result = $conn->query($sql);
    if($conn->query($sql)){
        echo "Records added successfully.";
    } else{
        echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
    }
    $conn->close();
}

?>