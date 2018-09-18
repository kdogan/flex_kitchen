<?php
// Create connection
class dbConnector{
	
	public function __construct(){
    }

	public function getDBConnection(){
	    $conn = mysqli_connect("localhost", "flex_user", "cxz6KNEQn8YJe0UN", "flex_kitchen");
	    return $conn;
	}
}
?>