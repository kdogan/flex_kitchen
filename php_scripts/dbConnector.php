<?php
// Create connection
class dbConnector{
	
	public function __construct(){
    }
	public function getDBConnection(){
	    $conn = mysqli_connect("localhost", "flex_user", "cMfedhceSldYmMbB", "flex_kitchen");
	    return $conn;
	}
}
?>