<?php

if(isset($_REQUEST['userRequested'])){

	echo getUserDivsInAdminPage();
}

if(isset($_REQUEST['adminHomeRequested'])){
	require("content_script.php");
	echo getAdminPageContent();
}

if(isset($_REQUEST['productsRequested'])){
	echo getProductDivsInAdminPage();
}

if(isset($_REQUEST['userHirstoryPageRequested']) && isset($_REQUEST['personId'])){
    $personId = $_REQUEST['personId'];
    echo getUserHistoryPage($personId);
}

if(isset($_REQUEST['userHistoryRequested']) && isset($_REQUEST['personId']) && isset($_REQUEST['since'])){
    $personId = $_REQUEST['personId'];
    $since = $_REQUEST['since'];
    echo getUserHistory($personId, $since);
}

function getUserDivsInAdminPage(){
	require("../php_script.php");

	$script = new FunctionScript();
    $persons = $script->getAllPersonFromDB();
    $result = "";
    if($persons->num_rows >0){
        while($row = $persons->fetch_assoc()){
            //pass user if it is admin
            if($row["is_admin"] == "1") continue;

            $user = $row["firstname"].' '.$row["lastname"];
            $id = $row["id"];
            $accountBalance = $row["account_balance"];
            $payButtonId = 'payButton'.$id;
            $inputPayment = 'inputPayment'.$id;

            $fetchedData = $script->getLastPurchasedArticle($id);
            $lastPurchase =$fetchedData;
            $src = $script->createUserImagePath($row["img_path"]);
            $result = $result.'<div class="column">
            <div class="box1"><img src='.$src.' alt="user image"></div>
            <div class="box2">
                <div>Name: <span id="loggedUserName">'.$user.'</span></div>
                <div>Kontostand: <span id="accountBalance'.$id.'">'.$accountBalance.' €</span></div>
                <div>Letzter Kauf: <span id="lastBuy">'.$lastPurchase["name"].' ('.$lastPurchase["buy_date"].')</span></div>
            </div>
            <div class="box3">
                <div class="input_in_grid">
                    <input class="payment_input" id="'.$inputPayment.'" placeholder="e.g. 2.50" onkeyup="checkInputForNumber(\''.$inputPayment.'\',\''.$payButtonId.'\')" type="text">
                </div>
                <div class="payment_button_in_grid">
                    <button id="'.$payButtonId.'" class="button"  onclick="updateUserAmount(\''.$id.'\',\''.$inputPayment.'\');">Bezahlen</button>
                </div>
                <div class="remove_user_in_grid">
                    <img class="icon_image" id="'.$payButtonId.'" src="img/remove_user_icon.png" onclick="confirmUserDeleting(\''.$user.'\',\''.$id.'\');"/>
                </div>
                <div class="user_history_in_grid">
                    <img class="icon_image" style="margin-top:3px;" src="img/user-history.png" onclick="goToUserHistoryPage(\''.$id.'\');"/>
                </div>
            </div>
            </div>';
        }
    }
    return $result;
}

function getProductDivsInAdminPage(){
	require("../php_script.php");
	$script = new FunctionScript();

	$products = $script->getAllFromTable("article");
    $categories = $script->getCategoriesFromDB();

    if($products->num_rows >0){
        $result = "";
        while($row = $products->fetch_assoc()){

            $productName = $row["name"];
            $productId = $row["id"];
            $NumOfProducts = $row["count"];
            $price = $row["price"];
            $categoryId = $row["category"];
            $categoryName = $categories[$categoryId];
            $image = $row["img_path"];

            $payButtonId = 'payButton'.$productId;
    		$inputPayment = 'inputPayment'.$productId;

            $result = $result.'<div class="column">
                <div class="box1"><img src="img/'.$image.'" alt="product image"></div>
                <div class="box2">
                    <div>Name: <span id="loggedUserName">'.$productName.'</span></div>
                    <div>Preis: <span id="price'.$price.'">'.$price.' €</span></div>
                    <div>Anzahl: <span id="numOfProduct'.$productId.'">'.$NumOfProducts.' Stück</span></div>
                    <div>Kategorie: <span id="category'.$productId.'">'.$categoryName.'</span></div>
                </div>
                <div class="box3">
                    <div class="input_in_grid">
                        <input class="payment_input" id="'.$inputPayment.'" onkeyup="checkInputForNumber(\''.$inputPayment.'\',\''.$payButtonId.'\')" type="text">
                    </div>
                    <div class="payment_button_in_grid">
                        <button id="'.$payButtonId.'" class="button" style="width:100%;" onclick="updateProductNumber(\''.$productId.'\',\''.$inputPayment.'\');">Einlagern</button>
                    </div>
                    <div class="remove_user_in_grid">
                        <img class="icon_image" style="margin-top:3px;" id="'.$payButtonId.'" src="img/remove_product_icon.png" onclick="confirmProductDeleting(\''.$productName.'\',\''.$productId.'\');"/>
                    </div>
                </div>
            </div>';
        }
    }
    return $result;
}

function getUserHistoryPage($personId){
    require("../php_script.php");
    $script = new FunctionScript();
    $person = json_decode($script->getPersonById($personId));
    $userName = $person->firstname.' '.$person->lastname;
    $accountBalance = $person->account_balance;
    $accountBalanceColor = intval($accountBalance) < 0? "red":"black";

    $src = $script->createUserImagePath($person->img_path);

    $result = "";
    $result = $result.'<div class="column">
    <div class="box1"><img src='.$src.'></div>
    <div class="box2">
        <div>Name: <span id="loggedUserName">'.$userName.'</span></div>
        <div>Kontostand: <span style="color:'.$accountBalanceColor.'">'.$accountBalance.' €</span></div>
    </div>
    <div class="box3">
        <div class="input_in_grid">
            <input type="range" min="1" max="11" value="1" class="slider" id="myRange" onchange="showUserHistory(this.value, '.$personId.');">
            <p><b><span id="sinceXMonth">1</span></b> Monat(e)</p>
        </div>
        <div class="payment_button_in_grid">
            
        </div>
    </div>
    </div>
    <div class="user_history_area">
        <div id="user_products_history_area" class="purchased_history history_area"><table><tr><th>Produktname</th><th>Kaufdatum</th></tr></table></div>
        <div id="user_payments_history_area" class="payment_history history_area"><table><tr><th>Bezahlte Betrag</th><th>Zahlungsdatum</th></tr></table></div>
    </div>';
    return $result;
}

function getUserHistory($personId, $since){
    require("../php_script.php");
    $script = new FunctionScript();

    $paymentByDate = $script->getUserPaymentByDate($personId, $since);

    $actionRows = "<table><tr><th>Dataum</th><th>Beschreibung</th><th>Betrag</th><th>Kontostand</th></tr>";
    if($paymentByDate != -1){
        foreach ($paymentByDate as $key => $value) {
            $actionDate = "<td>".$value["action_date"]."</td>";
            $actionDesc = "<td>".$value["action_desc"]."</td>";
            $actionAmount = "<td>".$value["amount"]."</td>";
            $actionAccountBalance = "<td>".$value["account_balance"]."</td>";

            $actionRows = $actionRows."<tr>".$actionDate.$actionDesc.$actionAmount.$actionAccountBalance."</tr>";
        }
    }
    $actionRows = $actionRows."</table>";
    $response["productList"] = $actionRows;


    return json_encode($response);
}

?>
