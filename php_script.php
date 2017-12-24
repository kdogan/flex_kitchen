<?php
/**
 * Description of functions
 *
 * @author Kamuran Dogan
 */
class functions {
    $servername = "localhost";
    $username = "flex_kitchen";
    $password = "root";
    $dbname = "flex_kitchen";
    
    //Yapıcı sınıfımız tanımlandı
    public function __construct(){
    }
    
    /*
     * Url adresi verilen sayfanın içeriğini döndürür
     * $url => varchar
    */
    public function getUserLIs(){

        $persons = getAllPerson();
        
        $result = '<li class="user_div" id="'.$id.'">
            <img class="user_img"src="'.$image_path.'" href="#" onclick="clickUser(\'user_div_id_1\')"></img>
            <p>Max Pferdmann</p>
        </li>';

        echo $result;
    }

    private function getAllPerson(){
        $link = mysql_connect($servername, $username, $password);
        if (!$link) {
            die('Verbindung schlug fehl: ' . mysql_error());
        }
        $sql = "SELECT * FROM person";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    }
} else {
    echo "0 results";
}
$conn->close();

    }

    public function getSiteHead(){
        echo '<!DOCTYPE html>
                <html>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
<script type="text/javascript" src="function.js"></script>
<link rel="stylesheet" href="style.css">';  
    }
}
?>