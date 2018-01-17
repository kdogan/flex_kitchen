<?php


$id = $_GET["id"];

if(isset($id)){
	//TODO before execution of sql queries check if current user has right to access
 	$response = getPersonFromDB($id);
 	echo json_encode($response);
}

function updateAccountBalanceOfUser($userId, $amound){
	$person = getPersonFromDB($userId);
	$oldAccountBalance = floatval($person["account_balance"]);
	$newAccountBalance = $oldAccountBalance + floatval($amound);

	$sql = 'UPDATE person SET account_balance = '.$newAccountBalance.'WHERE id ='.$userId;
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
?>
