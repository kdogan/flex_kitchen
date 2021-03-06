<?php
class FunctionScript{

    public function getAccountBalanceOfCurrentUser(){
        require_once("login.php");

        //$currentUserId = $this->getSessionUserId();
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->getAccountBalanceOfCurrentUser();
        return $result;
    }
    public function updateAccountBalanceOfUser($userId, $amount){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->updateAccountBalanceOfUser($userId, $amount);
        return $result;
    }

    function updateProductNumber($productId, $productNumber){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->updateProductNumber($productId, $productNumber);
        return $result;
    }

    public function getPersonById($personId){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->getPersonById($personId);
        return $result;
    }
    public function getArticleById($articleId){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->getArticleById($articleId);
        return $result;
    }

    public function getAllFromTable($tableName){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->getAllFromTable($tableName);
        return $result;
    }

    public function getAllPersonFromDB(){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->getAllPersonFromDB();
        return $result;
    }

    public function getCategoriesFromDB(){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->getCategoriesFromDB();
        return $result;
    }

    public function insertUser($firstname, $lastname, $email, $telefon, $img_path){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->insertUser($firstname, $lastname, $email, $telefon, $img_path);
        return $result;
    }

    public function insertArticle($articleName, $category, $price, $filename){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $result = $fetchDataFromDB->insertArticle($articleName, $category, $price, $filename);
        return $result;
    }

    public function getUserLIs(){
        $persons = $this->getAllPersonFromDB();
        $result = "<h2>No User found... :'(</h2>";
        if($persons->num_rows >0){
            $result = "";
            while($row = $persons->fetch_assoc()){
                //don't show admin in index page
                if($row["is_admin"] == "1") continue;
                $user = $row["firstname"]." ".$row["lastname"]; 
                $id = $row["id"];
                $src = $this->createUserImagePath($row["img_path"]);
                $result = $result.'<li class="user_div" id="'.$id.'">
                <div class="user_img" style="background-image: url(\''.$src.'\');" href="#" onclick="clickUser(\''.$id.'\')"></div>
                <span class="name_label_span">'.$user.'</span></li>';
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
                $imgUrl = $this->createUserImagePath($row["img_path"]);
                $result = $result.'<li class="article_li" style="width:fil-content">
                <div class="article_li_div" id="'.$id.'">
                    <div class="notify-badge"><strong>'.$row["price"].' €</strong></div>
                    <div class="article_li_img" style="background-image: url(\''.$imgUrl.'\');" href="#" onclick="clickArticle(\''.$id.'\')"></div>
                    <span class="name_label_span">'.$row["name"].'</span>
                </div>
                </li>';
            }
        }
        return $result;
    }

    public function getAllPurchasedArticlesForPersonSince($personId, $sinceXMonth){
        $dbFacadaScript = $this->getDBFacadeScript();
        $purchasedArticlesByIds = $fetchDataFromDB-> getAllPurchasedArticlesForPersonFromDB($personId, $sinceXMonth);
        return $purchasedArticlesByIds;
    }

    public function getAllPurchasedArticlesByDate($personId, $sinceXMonth){
        $dbFacadaScript = $this->getDBFacadeScript();
        $purchasedArticlesByDate = $dbFacadaScript->getAllPurchasedArticlesByDate($personId, $sinceXMonth);
        return $purchasedArticlesByDate;
    }
    public function getUserPaymentByDate($personId, $sinceXMonth){
        $dbFacadaScript = $this->getDBFacadeScript();
        $userPaymentByDate = $dbFacadaScript->getUserPaymentByDate($personId, $sinceXMonth);
        return $userPaymentByDate;
    }

    public function getLastPurchasedArticle($personId){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $purchasedArticle = $fetchDataFromDB-> getLastPurchases($personId);
        return $purchasedArticle;
    }
    public function setUserInActive($personId){
        $fetchDataFromDB = $this->getDBFacadeScript();
        $userInActiveSuccess = $fetchDataFromDB->setUserInActive($personId);
        return $userInActiveSuccess;
    }

    public function createUserImagePath($image_path){
        if(strpos($image_path, 'http') !== false){
            return $image_path;
        }else{
            return 'img/'.str_replace(" ","%20",$image_path);
        }
    }

    function getDBFacadeScript(){
        require_once("php_scripts/dbFetchDataFromDB.php");
        return new fetchDataFromDB();
    }
}

?>
