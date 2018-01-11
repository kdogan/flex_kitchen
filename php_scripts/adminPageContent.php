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
	$functions = new functions();

    $persons = $functions->getAllFromTable("person");
    $result = "<h2>No User found... :'(</h2>";
    if($persons->num_rows >0){
        $result = "";
        while($row = $persons->fetch_assoc()){
            //pass user if it is admin
            if($row["is_admin"] == "1") continue;
            $user = $row["firstname"].' '.$row["lastname"];
            $id = $row["id"];

            $result = $result.'<div class="column" style="background-color:#aaa000;">
                        <div class="box1"><img style="width:120px;float:left" src="'.$row["img_path"].'" alt="user image"></div>
                        <div class="box2">
                            <table>
                                <tr>
                                  <td>Name</td>
                                  <td>:</td>
                                  <td>'.$user.'</td>
                                </tr>
                                <tr>
                                 <td>Kontozustand</td>
                                  <td>:</td>
                                  <td>0 Euro</td>
                                </tr>
                                <tr>
                                  <td>Letzte Getränk</td>
                                  <td>:</td>
                                  <td>Nix</td>
                                </tr>
                                </table>
                                </div>
                        <div class="box3">Box3</div>
                    </div>';
        }
    }
    return $result;
}
?>
