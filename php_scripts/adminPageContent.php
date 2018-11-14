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

function getUserDivsInAdminPage(){
	require("../php_script.php");

	$script = new FunctionScript();
    $persons = $script->getAllPersonFromDB();
    
    $result = "<div style='width:20%;margin-buttom:10px'>
                        <div style='float:left;width:70%;height:37px;background-color:grey'>
                            <p><b>Neue Mitarbeiter hinzufügen</b></p>
                        </div>
                        <div style='float:left;width:20%;'>
                            <button class='button'style='width:100%' onclick='add_new_customer()'>+</button>
                        </div>
                    </div>";
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

            $result = $result.'<div class="column">
            <div class="box1"><img style="width:120px;float:left; border-radius: 10px 0px 0px 10px;" src='.$script->createUserImagePath($row["img_path"]).' alt="user image"></div>
            <div class="box2">
                <table>
                    <tr>
                      <td style="float:left">Name</td>
                      <td style="float:left">:</td>
                      <td style="float:left; font-weight: bold" id="loggedUserName">'.$user.'</td>
                    </tr>
                    <tr>
			            <td style="float:left"> Kontozustand </td>
			            <td style="float:left">:</td>
			            <td style="float:left; font-weight: bold" >
			                <div style="background-color: white;border-radius:50% ;padding:3px 15px 3px 15px; color:black" id="accountBalance'.$id.'">'.$accountBalance.' €</div>
			            </td>
			         </tr>
			         <tr>
			            <td style="float:left"> letzte Kauf </td>
			            <td style="float:left">:</td>
			            <td style="float:left; font-weight: bold" id="lastBuy">'.$lastPurchase["name"].' ('.$lastPurchase["buy_date"].')</td>
			         </tr>
                    </table>
                    </div>
            		<div class="box3">
            			<div style="float:left">
            				<input class="payment_input" id="'.$inputPayment.'" placeholder="e.g. 2.50"onkeyup="checkInputForNumber(\''.$inputPayment.'\',\''.$payButtonId.'\')" type="text"></div>
            			<div style="float:left;">
            				<button id="'.$payButtonId.'" class="button"  onclick="updateUserAmound(\''.$id.'\',\''.$inputPayment.'\');">Bezahlen</button>
            			</div>
                        <div style="float:right;">
                            <img id="'.$payButtonId.'" class="button" src="img/remove_user_icon.png" onclick="setUserInActive(\''.$id.'\');">
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
        $result = "<div style='width:15%;margin-buttom:10px'>
                        <div style='float:left;width:70%;height:37px;background-color:grey'>
                            <p><b>Add New Product</b></p>
                        </div>
                        <div style='float:left;width:20%;'>
                            <button class='button'style='width:100%' onclick='add_new_product()'>Add</button>
                        </div>
                    </div>";
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
            <div class="box1"><img style="width:120px;float:left; border-radius: 10px 0px 0px 10px;" src="img/'.$image.'" alt="product image"></div>
            <div class="box2">
                <table>
                    <tr>
                      <td style="float:left">Name</td>
                      <td style="float:left">:</td>
                      <td style="float:left; font-weight: bold" id="loggedUserName">'.$productName.'</td>
                    </tr>
                    <tr>
                        <td style="float:left"> Preis</td>
                        <td style="float:left">:</td>
                        <td style="float:left; font-weight: bold" id="price'.$price.'">'.$price.' €</td>
                     </tr>
                    <tr>
			            <td style="float:left"> Anzahl des Produkts </td>
			            <td style="float:left">:</td>
			            <td style="float:left; font-weight: bold" > 
			              <div style="background-color: white;border-radius:50% ;padding:3px 15px 3px 15px; color:black" id="numOfProduct'.$productId.'">'.$NumOfProducts.' Stück</div>
			            </td>
			         </tr>
			         <tr>
			            <td style="float:left"> Kategorie</td>
			            <td style="float:left">:</td>
			            <td style="float:left; font-weight: bold" id="category'.$productId.'">'.$categoryName.'</td>
			         </tr>
                    </table>
                    </div>
            		<div class="box3">
                        <div style="float:left;width:50%">
                            <input class="payment_input" id="'.$inputPayment.'" onkeyup="checkInputForNumber(\''.$inputPayment.'\',\''.$payButtonId.'\')" type="text">
                        </div>
                        <div style="float:left;width:50%;">
                            <button id="'.$payButtonId.'" class="button" style="width:100%;" onclick="updateProductNumber(\''.$productId.'\',\''.$inputPayment.'\');">Einlagern</button>
                        </div>
                    </div>
            		  
                </div>';
        }
    }
    return $result;
}

?>
