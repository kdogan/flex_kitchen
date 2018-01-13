<?php
/**
 * Description of functions
 *
 * @author Kamuran Dogan
 */
class fetchDataFromDB {
	
	

	public function __construct(){
    }


	public function getLastPurchases($personId){
		require_once("dbConnector.php");
		$db = new dbConnector();
		$conn = $db->getDBConnection();
		
		//$conn = $this->getDBConnection();
    	$sql = 'SELECT a.name as name, pam.person_id as person_id, pam.buy_date as buy_date 
    			FROM article a, person_article_matrix pam 
    			WHERE a.id = pam.article_id AND pam.person_id = '.$personId.' ORDER BY pam.id DESC LIMIT 1';
    			
    	$result = $conn->query($sql);
    	
    	$response['name'] = "Name";
	    $response['person_id'] = "PersonId";
	    $response['buy_date'] = "Date";
	    
	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $response['name'] = $row["name"];
	            $response['person_id'] = $row["person_id"];
	            $response['buy_date'] = $row["buy_date"];
	            //echo json_encode($response);
	        }
	    }  
	    $conn->close();
	    return json_encode($response);
	    
	}
}