<?php
/**
 *
 * @author Kamuran Dogan
 */
class fetchDataFromDB {

	public function __construct(){
    }

	public function getLastPurchases($personId){

		$conn = $this->getDBConnection();
    	$sql = 'SELECT a.name as name, pam.person_id as person_id, pam.buy_date as buy_date 
    			FROM article a, person_article_matrix pam 
    			WHERE a.id = pam.article_id AND pam.person_id = '.$personId.' ORDER BY pam.id DESC LIMIT 1';

    	$result = $conn->query($sql);

    	$response['id'] = -1;
		$response['person_id'] = -1;
		$response['article_id'] =-1;
		$response['buy_date'] = "00.00.00.00";

	    if ($result->num_rows > 0) {
	        while($row = $result->fetch_assoc()) {
	            $response['name'] = $row["name"];
	            $response['person_id'] = $row["person_id"];
	            $response['buy_date'] = $row["buy_date"];
	        }
	    }
	    $conn->close();
	    return $response;
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

	public function getAllFromTable($tableName){
        $conn = $this->getDBConnection();
        if (!$conn) {
            die('database connectin fails: ' . mysql_error());
        }
        $sql = "SELECT * FROM ".$tableName;
        $result = $conn->query($sql);
        $conn->close();
        return $result;
	}
	
	/*public function getLastPurchasedArticleName($personId){
		$conn = $this->getDBConnection();
		$sql =' SELECT name from article where id = (select article_id from person_article_matrix where person_id = '.$personId.' ORDER BY ID DESC LIMIT 1)';
		$result = $conn->query($sql);
		$name;
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$name = $row["name"];
			}
		} else{
			$name = "Noch nix gekauft!";
		}
		$conn->close();
		return $name;
	}

	public function getLastPersonArticleMatrixEntryForUser($personId){
		$conn = $this->getDBConnection();
		$sql = 'SELECT * FROM person_article_matrix WHERE person_id ='.$personId.' ORDER BY ID DESC LIMIT 1';
		$response;
		$result = $conn->query($sql);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$response['id'] = $row["id"];
				$response['person_id'] = $row["person_id"];
				$response['article_id'] =$row["article_id"];
				$response['buy_date'] = $row["buy_date"];
			}
		}else{
			$response['id'] = -1;
			$response['person_id'] = -1;
			$response['article_id'] =-1;
			$response['buy_date'] = "00.00.00.00";
		} 

		$conn->close();
		return $response;
	}*/
	
}
