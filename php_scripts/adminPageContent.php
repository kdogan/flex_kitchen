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
                    <button id="'.$payButtonId.'" class="button"  onclick="updateUserAmound(\''.$id.'\',\''.$inputPayment.'\');">Bezahlen</button>
                </div>
                <div class="remove_user_in_grid">
                    <img class="icon_image" id="'.$payButtonId.'" src="img/remove_user_icon.png" onclick="confirmUserDeleting(\''.$user.'\',\''.$id.'\');"/>
                </div>
                <div>
                    <img class="icon_image" style="margin-top:3px;" src="img/remove_product_icon.png" onclick="showUserHistoryPage(\''.$id.'\');"/>
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
    <div class="box1"><img src='.$src.' alt="user image"></div>
    <div class="box2">
        <div>Name: <span id="loggedUserName">'.$userName.'</span></div>
        <div>Kontostand: <span style="color:'.$accountBalanceColor.'">'.$accountBalance.' €</span></div>
    </div>
    <div class="box3">
        <div class="input_in_grid">
            <select id = "sinceXMonth">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="payment_button_in_grid">
            <button class="button"  onclick="showUserHistory(document.getElementById("sinceXMonth").value);">Zeigen</button>
        </div>
    </div>
    </div>';
    return $result;
}

?>
