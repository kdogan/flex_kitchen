<?php 
include("dbConnector.php");

$selectedProductId = $_GET["selectedArticleId"];
$personId = $_GET["personId"];
$conn =getDBConnection();
$sql = 'INSERT INTO person_article_matrix (person_id, article_id, count, buy_date) VALUES ('.$personId.','.$selectedProductId.',1,CURDATE())';
$result = $conn->query($sql);
if(isset($selectedArticleId) && isset($personId)){
    
    if ($conn->query($sql) === TRUE) {
    	echo "New record created successfully";
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close(); 
?>