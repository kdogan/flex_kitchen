<?php
include("dbConnector.php");
$db = new dbConnector();
$conn = $db->getDBConnection();


$id = $_GET["id"];

if(isset($id)){
$sql = 'SELECT * FROM person WHERE is_admin="0" and id ='.$id;
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
    echo json_encode($response);
} else {
    echo "-1";
}
$conn->close(); 
    
}
?>