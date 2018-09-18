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
                <span class="name_label_span">'.$user.'</span>
                </li>';
            }
        }
        return $result;
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
                    <span class="name_label_span">'.$row["name"].'</span>
                </div>
                
                </li>';
            }
        }
        return $result;
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

        return '<table>
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
        require_once("php_scripts/dbFetchDataFromDB.php");
        $fetchDataFromDB = new fetchDataFromDB();
        $result = $fetchDataFromDB->getAllFromTable($tableName);
        return $result;
    }


    public function getFooter(){
        return '<div class="footer">
                    <footer id="footer">Copyright &copy; e-oku.de</footer>
                </div>
                </div>
                </body>
                </html>';
    }
}
?>