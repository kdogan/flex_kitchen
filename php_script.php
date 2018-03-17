<?php
/**
 * Description of functions
 *
 * @author Kamuran Dogan
 */
class functions {
    

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
                //pass user if it is admin
                if($row["is_admin"] == "1") continue;
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
                $id = $row["id"];
                $result = $result.'<li style="width:fil-content">
                <div class="user_div" id="'.$id.'">
                    <div class="user_img" style="background-image: url(\''.$row["img_path"].'\');" href="#" onclick="clickArticle(\''.$id.'\')">
                        <span class="notify-badge"><strong>'.$row["price"].' €</strong></span>
                    </div>
                    <p>'.$row["name"].'</p>
                </div>
                
                </li>';
            }
        }
        echo $result;
    }

    public function getAdminPageContent(){

        echo   '<li style="width:fil-content">
      <div class="user_div">
        <div class="user_img" style="background-image: url(\'img/users.png\');" href="#" onclick="getUsersInAdminPage()"></div>
        <p>Employees</p>
      </div>           
    </li>
    <li style="width:fil-content">
      <div class="user_div">
        <div class="user_img" style="background-image: url(\'img/products.png\');" href="#" onclick="getProducts()"></div>
        <p>Products</p>
      </div>    
    </li>
    <li style="width:fil-content">
      <div class="user_div">
        <div class="user_img" style="background-image: url(\'img/setting.png\');" href="#" onclick="showSetting()"></div>
        <p>Setting</p>
      </div>    
    </li>';
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

    public function getAllFromTable($tableName){
        require_once("php_scripts/dbConnector.php");
        $db = new dbConnector();
        $conn = $db->getDBConnection();
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
<script type="text/javascript" src="js/administration.js"></script>
<link rel="stylesheet" href="./css/style.css">';  
    }

    public function getFooter(){
        echo '<footer id="footer">Copyright &copy; e-oku.de</footer>
            </div>
            </body>
            </html>';
    }
}
?>