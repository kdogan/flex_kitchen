<?php
/**
 * Description of functions
 *
 * @author Kamuran Dogan
 */
class functions {
    
    private function getDBConnection(){
        $conn = mysqli_connect("localhost", "flex_kitchen", "root", "flex_kitchen");
        return $conn;
    }
    
    //Yapıcı sınıfımız tanımlandı
    public function __construct(){
    }
    
    /*
     * Url adresi verilen sayfanın içeriğini döndürür
     * $url => varchar
    */
    public function getUserLIs(){

        $persons = $this -> getAllFromTable("person");
        $result = "<h2>No User found... :'(</h2>";
        if($persons->num_rows >0){
            $result = "";
            while($row = $persons->fetch_assoc()){
                $result = $result.'<li class="user_div" id="'.$row["id"].'">
                <img class="user_img"src="'.$row["img_path"].'" href="#" onclick="clickUser(\'user_div_id_'.$row["id"].'\')"></img>
                <p>'.$row["firstname"]." ".$row["lastname"].'</p>
                </li>';
            }
        }
        echo $result;
    }
    public function getArticleLIs(){

        $persons = $this -> getAllFromTable("article");
        $result = "<h2>No Article found... :'(</h2>";
        if($persons->num_rows >0){
            $result = "";
            while($row = $persons->fetch_assoc()){
                $result = $result.'<li class="article_div" id="'.$row["id"].'">
                <img class="article_img" src="'.$row["img_path"].'" href="#" onclick="clickArticle(\'user_div_id_'.$row["id"].'\')"></img>
                <p>'.$row["name"].'</p>
                <p><strong>'.$row["price"].' €</strong></p>
                </li>';
            }
        }
        echo $result;
    }

    private function getAllFromTable($tableName){
        $conn = $this->getDBConnection();
        if (!$conn) {
            die('Verbindung schlug fehl: ' . mysql_error());
        }
        $sql = "SELECT * FROM ".$tableName;
        $result = $conn->query($sql);
        $conn->close();
        return $result;

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

    public function getFooter(){
        echo '<footer>Copyright &copy; flexlog.de</footer>
            </div>
            </body>
            </html>';
    }
}
?>