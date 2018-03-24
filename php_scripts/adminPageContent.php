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
    
    $result = "<div style='width:15%;margin-buttom:10px'>
                        <div style='float:left;width:70%;height:33px;background-color:grey'>
                            <p><b>Add New Employee</b></p>
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

            $fetchedData = $fetchDataFromDB->getLastPurchases($id);
            $lastPurchase =json_decode($fetchedData);

            $result = $result.'<div class="column" style="background-color:#DCDCDC">
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
            			<div style="float:left;width:50%">
            				<input class="payment_input" id="'.$inputPayment.'" placeholder="e.g. 2.50"onkeyup="checkInputForNumber(\''.$inputPayment.'\',\''.$payButtonId.'\')" type="text"></div>
            			<div style="float:left;width:50%;">
            				<button id="'.$payButtonId.'" class="button"  onclick="updateUserAmound(\''.$id.'\',\''.$inputPayment.'\');">Bezahlen</button>
            			</div>
            		</div>
            </div>';
        }
    }
    return $result;
}

function getProductDivsInAdminPage(){
    require("dbutility.php");
	require("../php_script.php");
	$functions = new functions();
    
    
	$products = $functions->getAllFromTable("article");
    $categories = getCategoriesFromDB();

    if($products->num_rows >0){
        $result = "<div style='width:15%;margin-buttom:10px'>
                        <div style='float:left;width:70%;height:33px;background-color:grey'>
                            <p><b>Add New Product</b></p>
                        </div>
                        <div style='float:left;width:20%;'>
                            <button class='button'style='width:100%' onclick='add_new_product()'>+</button>
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

            $result = $result.'<div class="column" style="background-color:#DCDCDC">
            <div class="box1"><img style="width:120px;float:left" src="'.$image.'" alt="product image"></div>
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
                            <button id="'.$payButtonId.'" class="button" style="width:100%;" onclick="updateProductNumber(\''.$productId.'\',\''.$inputPayment.'\');">+</button>
                        </div>
                    </div>
            		  
                </div>';
        }
    }
    return $result;
}

?>
