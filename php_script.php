<?php
class FunctionScript{

    public function getAccountBalanceOfCurrentUser(){
        require_once("login.php");
        require_once("php_scripts/dbFetchDataFromDB.php");

        $currentUserId = getSessionUserId();
        $fetchDataFromDB = new fetchDataFromDB();
        $result = $fetchDataFromDB->getAccountBalanceOfCurrentUser($currentUserId);
        return $result;
    }
    public function updateAccountBalanceOfUser($userId, $amound){
        require_once("php_scripts/dbFetchDataFromDB.php");
        $fetchDataFromDB = new fetchDataFromDB();
        $result = $fetchDataFromDB->updateAccountBalanceOfUser($userId, $amound);
        return $result;
    }

    function updateProductNumber($productId, $productNumber){
        require_once("php_scripts/dbFetchDataFromDB.php");

        $fetchDataFromDB = new fetchDataFromDB();
        $result = $fetchDataFromDB->updateProductNumber($productId, $productNumber);
        return $result;
    }

    public function getAllFromTable($tableName){
        require_once("php_scripts/dbFetchDataFromDB.php");
        $fetchDataFromDB = new fetchDataFromDB();
        $result = $fetchDataFromDB->getAllFromTable($tableName);
        return $result;
    }

    public function getCategoriesFromDB(){
        require_once("php_scripts/dbFetchDataFromDB.php");
        $fetchDataFromDB = new fetchDataFromDB();
        $result = $fetchDataFromDB->getCategoriesFromDB();
        return $result;
    }

    public function insertUser($firstname, $lastname, $email, $telefon, $img_path){
        require_once("php_scripts/dbFetchDataFromDB.php");
        $fetchDataFromDB = new fetchDataFromDB();
        $result = $fetchDataFromDB->insertUser($firstname, $lastname, $email, $telefon, $img_path);
        return $result;
    }

    public function getUserLIs(){
        $persons = $this ->getAllFromTable("person");
        $result = "<h2>No User found... :'(</h2>";
        if($persons->num_rows >0){
            $result = "";
            while($row = $persons->fetch_assoc()){
                //don't show admin in index page
                if($row["is_admin"] == "1") continue;
                $user = $row["firstname"]." ".$row["lastname"]; 
                $id = $row["id"];
                $imagePath = $row["img_path"];
                $result = $result.'<li class="user_div" id="'.$id.'">
                <div class="user_img" style="background-image: url(\''.$this->createUserImagePath($row["img_path"]).'\');" href="#" onclick="clickUser(\''.$id.'\')"></div>
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
                    <div class="user_img" style="background-image: url(\''.$this->createUserImagePath($row["img_path"]).'\');" href="#" onclick="clickArticle(\''.$id.'\')">
                        <span class="notify-badge"><strong>'.$row["price"].' €</strong></span>
                    </div>
                    <span class="name_label_span">'.$row["name"].'</span>
                </div>
                </li>';
            }
        }
        return $result;
    }

    public function getLastPurchasedArticle($personId){
        require_once("php_scripts/dbFetchDataFromDB.php");
        $fetchDataFromDB = new fetchDataFromDB();
        $purchasedArticle = $fetchDataFromDB-> getLastPurchases($personId);
        return $purchasedArticle;
    }

    public function createUserImagePath($image_path){
        if(strpos($image_path, 'http') !== false){
            return $image_path;
        }else{
            return 'img/'.$image_path;
        }
        
    }
}

?>
