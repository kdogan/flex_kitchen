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

	function getDBConnection(){
		require_once("dbConnector.php");
		$db = new dbConnector();
		$conn = $db->getDBConnection();
		return $conn;
	}
	public function getAllPurchasedArticlesForPersonFromDB($personId){

		$conn = $this->getDBConnection();
    	$sql = 'SELECT pam.article_id, sum(pam.count) as sum
    			FROM article a, person_article_matrix pam
    			WHERE a.id = pam.article_id AND pam.person_id = '.$personId.' && month(buy_date) = month(now())-1 && year(buy_date) = year(now()) GROUP BY article_id';

    	$result = $conn->query($sql);
    	$purchasedArticlesByArticleId;

	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $response['article_id'] = $row["article_id"];
	            $response['sum'] = $row["sum"];
	            $purchasedArticlesByArticleId[$row["article_id"]] = $response;
	        }
	    }else{
	    	return -1;
	    }
	    $conn->close();
	    return json_encode($purchasedArticlesByArticleId);
	}

	public function getAllPersonsFromDB(){

		$conn = $this->getDBConnection();

		$sql = 'SELECT * FROM person WHERE is_admin="0"';
		$result = $conn->query($sql);

		if ($result->num_rows > 0) {
			$counter = 0;
		    $customers;
		    while($row = $result->fetch_assoc()) {
		        $response['id'] = $row["id"];
		        $response['firstname'] = $row["firstname"];
		        $response['lastname'] =$row["lastname"];
		        $response['email'] = $row["email"];
		        $response['img_path'] = $row["img_path"];
		        $response['account_balance'] = $row["account_balance"];

		        $customers[$counter] = $response;
		        $counter++;
		    }
		    $conn->close();
		    return json_encode($customers);
		} else {
		    return "-1";
		}
	}

	function getArticleFromDB($productId){
		$conn = $this->getDBConnection();

		$sql = 'SELECT * FROM article WHERE id ='.$productId;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		        $article['id'] = $row["id"];
		        $article['name'] = $row["name"];
		        $article['price'] = $row["price"];
		        $article['count'] = $row["count"];
		        $article['category'] = $row["category"];
		        $article['img_path'] = $row["img_path"];
		    }
		    return $article;
		} else {
		    return "-1";
		}
		$conn->close();
	}

}
