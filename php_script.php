<?php
/**
 * Description of functions
 *
 * @author Kamuran Dogan
 */
class functions {
    
    //Yapıcı sınıfımız tanımlandı
    public function __construct(){
    }
    
    public function getDBConnection(){
        $conn = mysqli_connect("localhost", "flex_kitchen", "root", "flex_kitchen");
        return $conn;
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
                $user = $row["firstname"].' '.$row["lastname"];
                $id = $row["id"];
                $result = $result.'<li class="user_div" id="'.$id.'">
                <div class="user_img" style="background-image: url(\''.$row["img_path"].'\');" href="#" onclick="clickUser(\''.$user.'\',\''.$id.'\')"></div>
                <p>'.$user.'</p>
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
                <img class="article_img" src="'.$row["img_path"].'" href="#" onclick="clickArticle(\''.$row["id"].'\')"></img>
                <p>'.$row["name"].'</p>
                <span><strong>'.$row["price"].' €</strong></span>
                </li>';
            }
        }
        echo $result;
    }

    public function getActiveUserIcon(){
        echo 
            '<div id="loggedUserImg" style="width:60px;height:60px;float:left; background-image:url(\'default_user_img.png\');background-repeat:no-repeat;background-size: cover"></div>
             <div style="float:left"> <p id="loggedUserName"></p></div>';
    }

    public function getUserAccountBalance(){

        echo '
        <table>
         <tr>
            <td style="float:left"> Kontozustand </td>
            <td style="float:left">:</td>
            <td style="float:left; font-weight: bold" > 
                <div style="background-color: white;border-radius:50% ;padding:3px 15px 3px 15px; color:black" id="accountBalance">0 €</div>
            </td>
         </tr>
         <tr>
            <td style="float:left"> letzte Kauf </td>
            <td style="float:left">:</td>
            <td style="float:left; font-weight: bold" id="lastBuy">letzte Getränk</td>
         </tr>
        </table>';
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