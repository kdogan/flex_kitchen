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
                $result = $result.'<li class="user_div" id="'.$id.'">
                <div class="user_img" style="background-image: url(\''.$row["img_path"].'\');" href="#" onclick="clickUserInAdminPage('.$id.'\')"></div>
                <p>'.$user.'</p>
                </li>';
            }
        }
        return $result;
    }

?>