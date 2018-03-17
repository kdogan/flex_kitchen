<?php


if(isset($_REQUEST['userRequested'])){

	echo getUserDivsInAdminPage();
}
if(isset($_REQUEST['adminHomeRequested'])){
	require("../php_script.php");
	$functions = new functions();
	echo $functions->getAdminPageContent();
}

if(isset($_REQUEST['productsRequested'])){
	echo getProductDivsInAdminPage();
}

function getUserDivsInAdminPage(){
	require("../php_script.php");
	require("dbFetchDataFromDB.php");

	$functions = new functions();
	$fetchDataFromDB = new fetchDataFromDB();

    $persons = $functions->getAllFromTable("person");
    
    $result = "<h2>No User found... :'(</h2>";
    if($persons->num_rows >0){
        $result = "";
        while($row = $persons->fetch_assoc()){
            //pass user if it is admin
            if($row["is_admin"] == "1") continue;
            
            $user = $row["firstname"].' '.$row["lastname"];
            $id = $row["id"];
            $accountBalance = $row["account_balance"];
            $payButtonId = 'payButton'.$id;
            $inputPayment = 'inputPayment'.$id;

            $fetchedData = $fetchDataFromDB->getLastPurchases($id);
            $lastPurchase =json_decode($fetchedData);

            $result = $result.'<div class="column" style="background-color:#aaa000;">
            <div class="box1"><img style="width:120px;float:left" src="'.$row["img_path"].'" alt="user image"></div>
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
			            <td style="float:left; font-weight: bold" id="lastBuy">'.$lastPurchase->{"name"}.' ('.$lastPurchase->{"buy_date"}.')</td>
			         </tr>
                    </table>
                    </div>
            		<div class="box3">
            			<div style="float:left;width:100%;font-size:10px" id="errorMsgInUserPayment"></div>
            			<div style="float:left;width:100%">
            				<input class="payment_input" id="'.$inputPayment.'" placeholder="e.g. 2.50"onkeyup="checkInputForNumber(\''.$inputPayment.'\',\''.$payButtonId.'\')" type="text"></div>
            			<div style="float:left;width:100%; margin-top:2px">
            				<button id="'.$payButtonId.'" class="button"  onclick="updateUserAmound(\''.$id.'\',\''.$inputPayment.'\');">Bezahlen</button>
            			</div>
            		</div>
            </div>';
        }
    }
    return $result;
}

function getProductDivsInAdminPage(){
	require("../php_script.php");
	$functions = new functions();
	$products = $functions->getAllFromTable("article");
    
    $result = "<h2>No products found... :'(</h2>";

    if($products->num_rows >0){
        $result = "<div style='width:15%'>
                        <div style='float:left;width:70%;background-color:yellow'>
                            <p>Add New Product </p>
                        </div>
                        <div style='float:left;width:30%;''>
                            <button class='button'style='width:100%'>+</button>
                        </div>
                    </div>";
        while($row = $products->fetch_assoc()){
            
            $productName = $row["name"];
            $productId = $row["id"];
            $NumOfProducts = $row["count"];
            $price = $row["price"];
            $category = $row["category"];
            $image = $row["img_path"];

            $payButtonId = 'payButton'.$productId;
    		$inputPayment = 'inputPayment'.$productId;

            $result = $result.'<div class="column" style="background-color:#aaa000;">
            <div class="box1"><img style="width:120px;float:left" src="'.$image.'" alt="product image"></div>
            <div class="box2">
                <table>
                    <tr>
                      <td style="float:left">Name</td>
                      <td style="float:left">:</td>
                      <td style="float:left; font-weight: bold" id="loggedUserName">'.$productName.'</td>
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
			            <td style="float:left; font-weight: bold" id="category'.$productId.'">'.$category.'</td>
			         </tr>
                    </table>
                    </div>
            		<div class="box3">
                        <div style="float:left;width:100%;font-size:10px" id="errorMsgInUserPayment"></div>
                        <div style="float:left;width:70%">
                            <input class="payment_input" id="'.$inputPayment.'" onkeyup="checkInputForNumber(\''.$inputPayment.'\',\''.$payButtonId.'\')" type="text">
                        </div>
                        <div style="float:left;width:30%;">
                            <button id="'.$payButtonId.'" class="button"  onclick="updateProductNumber(\''.$productId.'\',\''.$inputPayment.'\');">Add</button>
                        </div>
                    </div>
            		  
                </div>';
        }
    }
    return $result;
}
?>
