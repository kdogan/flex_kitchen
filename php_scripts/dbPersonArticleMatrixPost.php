<?php 
include("dbConnector.php");

$selectedArticleId = $_GET["selectedArticleId"];
$personId =  $_GET["personId"];

$conn =getDBConnection();
$sql = 'INSERT INTO person_article_matrix (person_id, article_id, count, buy_date) VALUES ('.$personId.','.$selectedArticleId.',1,CURDATE())';
$result = mysqli_query($conn, $sql);

if(isset($selectedArticleId) && isset($personId)){
    
    if ($result === TRUE) {
    	echo "New record created successfully";
    }
} else {
	$foo = 'aritcle Id :'.$selectedArticleId.', personId :'.$personId;
    echo "Error: ".$foo. " " . $sql . "<br>" . $conn->error;
}

$conn->close(); 
?>