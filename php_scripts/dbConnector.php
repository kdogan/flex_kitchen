<?php
// Create connection
function getDBConnection(){
        $conn = mysqli_connect("localhost", "flex_kitchen", "root", "flex_kitchen");
        return $conn;
}

?>