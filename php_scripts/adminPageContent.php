<?php


if(isset($_REQUEST['userRequested'])){

	echo getUserDivsInAdminPage();
}
if(isset($_REQUEST['adminHomeRequested'])){
	require("../php_script.php");
	$functions = new functions();
	echo $functions->getAdminPageContent();
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
						                <div style="background-color: white;border-radius:50% ;padding:3px 15px 3px 15px; color:black" id="accountBalance">'.$accountBalance.' €</div>
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
                        				<a id="'.$payButtonId.'" class="button" type="button" disabled>Bezahlen</a>
                        			</div>
                        		</div>
                    </div>';
        }
    }
    return $result;
}
?>
