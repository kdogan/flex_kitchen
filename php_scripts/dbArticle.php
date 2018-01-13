<?php
include("dbConnector.php");

$id = $_GET["id"];

if(isset($id)){
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