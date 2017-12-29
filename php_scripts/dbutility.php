<?php
include("dbConnector.php");


$id = $_GET["id"];

if(isset($id)){
$sql = 'SELECT * FROM person WHERE id ='.$id;
$conn =getDBConnection();
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $response['id'] = $row["id"];
        $response['firstname'] = $row["firstname"];
        $response['lastname'] =$row["lastname"];
        $response['email'] = $row["email"];
        $response['img_path'] = $row["img_path"];
    }
    echo json_encode($response);
} else {
    echo "-1";
}
$conn->close();     
}
?>