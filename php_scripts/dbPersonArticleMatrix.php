<?php
include("dbConnector.php");

$person_id = $_GET["person_id"];
$isLastEntryRequested = $_GET["lastEntry"];
$conn =getDBConnection();

if(!isset($isLastEntryRequested) || $isLastEntryRequested != 1){
    $sql = 'SELECT * FROM person_article_matrix WHERE person_id ='.$person_id.' ORDER BY ID DESC LIMIT 1';
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response['id'] = $row["id"];
            $response['person_id'] = $row["person_id"];
            $response['article_id'] =$row["article_id"];
            $response['buy_date'] = $row["buy_date"];
        }
        echo json_encode($response);
    } else{
        echo "-1";
    }   
}else {
    $sql = 'SELECT name from article where id = (select article_id from person_article_matrix where person_id = '.$person_id.' ORDER BY ID DESC LIMIT 1)';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $response['name'] = $row["name"];
            echo json_encode($response);
        }
    }     
}
$conn->close();
?>