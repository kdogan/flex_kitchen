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
                        		<table>
                        		<tr>
                                  <td style="float:left" ><input class="payment_input" type="text"></td>
                                </tr>
                                <tr>
                                  <td style="float:left;" ><button class="button">Bezahlen</button></td>
                                </tr>
                                </table>
                        	
                        </div>
                    </div>';
        }
    }
    return $result;
}
?>
