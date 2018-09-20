<?php
include "login.php";

function getCurrentPageContent(){
    $currentPageContent = getHomePageContent(); //= getLoginPage();
    if(hasSession()){
        if(isAdmin()){
            $currentPageContent = getAdminPage();
        }else{
            $currentPageContent = getArticlePage();
        }
    }
    return $currentPageContent;
}

function getUserAccountBalance(){
    return '<table>
             <tr>
                <td style="float:left"> Kontozustand </td>
                <td style="float:left">:</td>
                <td style="float:left; font-weight: bold" > 
                    <div style="background-color: white;border-radius:50% ;padding:3px 15px 3px 15px; color:black" id="accountBalance">0 €</div>
                </td>
             </tr>
             <tr>
                <td style="float:left"> letzte Kauf </td>
                <td style="float:left">:</td>
                <td style="float:left; font-weight: bold" id="lastBuy">letzte Getränk</td>
             </tr>
            </table>';
}

function getHomePageContent(){
    require_once("php_script.php");
    $script = new FunctionScript();
    return '<!DOCTYPE html>
            <html>'.getPageScriptBinding().'<head>
            </head>
            <body>
            <div class="flex-container">
            <header>
            <div class="header_first_column">
                <div style="width: 50px; height: 50px; float: left"> FLEX KITCHEN</div>
                </div>
                <div class="header_second_column" style="color:#83bb26"> </div>
                <div class="header_third_column">
                <form class="search_form">
                    <div style="float:right" id="adminLoginBtn"><img style="width:50px; float:right;" src="img/adminLogginImg.png" href="#" onclick="login()"></img></div>
                    <div style="float:right"> <input type="text" class="search" id="search" placeholder="Search for names.." title="Type in a name"></div>
                </form>
            </div>
            </header>
            <div class="content">
            <menu>'. $script->getUserLIs().'</menu>'.getLoginPage().'
        </div>'.getFooter();
}

function getAdminPage(){
return '
<!DOCTYPE html>
    <html><link rel="stylesheet" href="./css/window_style.css">'.getPageScriptBinding().'<head>
	<style>
        .product_count {
            width: 60px;
            height: 40px;
            padding: 1px;
            border: none;
            border: 1px solid #555;
            font-weight: bold;
        }
	</style>
	<script>
	function searchUserInAdminPage(){
      var value = document.getElementById("searchInAdminPage").value;
      $(".column").each(function() {
          if ($(this).text().toLowerCase().search(value.toLowerCase()) > -1) {
              $(this).show();
          }
          else {
              $(this).hide();
          }
      });
	}
	function checkInputForNumber(inputPayment,buttonId)
	{
		var input = document.getElementById(inputPayment);
		var payButton = document.getElementById(buttonId);
		//input.style.backgroundColor="#FFF";
		
		var x=input.value;
		
		if (!isInputedAmoundValid(x) && x !="")
		{
		    input.style.backgroundColor="#FF0000";
		}else{
			input.style.backgroundColor="#FFF";
		}
	}
	function updateUserAmound(userId, inputFieldId){

	  var input = document.getElementById(inputFieldId);
	  var amound = input.value;
	  if(isInputedAmoundValid(amound)){
	    $.ajax({
	      url: \'php_scripts/dbutility.php?id=\'+userId+\'&amound=\'+amound,
	      success: function(html) {
	                var obj = JSON.parse(html);
	                var idOfBalanceToBeUpdated = "accountBalance"+userId;
	                document.getElementById(idOfBalanceToBeUpdated).innerHTML = obj["newBalance"]+" €";
	                input.value = "";
	               }
	    });
	  }
	}

	function updateProductNumber(productId, inputFieldId){

	  var input = document.getElementById(inputFieldId);
	  var productNumber = input.value;
	  if (isInteger(productNumber)){
	    $.ajax({
	      url: \'php_scripts/dbutility.php?productId=\'+productId+\'&productNumber=\'+productNumber,
	      success: function(html) {
	                var obj = JSON.parse(html);
	                var idOfBalanceToBeUpdated = "numOfProduct"+productId;
	                var numberOfProduct = obj["newCount"];
	                document.getElementById(idOfBalanceToBeUpdated).innerHTML = numberOfProduct+" Stück";
	                input.value = "";
	               }
	    });
	  }
	}

function isInteger(x) {
   return x % 1 === 0;
}

function isInputedAmoundValid(value){
  var regex=/^\-?([1-9]\d*|0)(\.\d?[1-9])?$/;
  if(value=="" || !value.match(regex)) {
    return false;
  }
  else{
    return true;
  }
}
</script>
</head>
<body">

<div class="flex-container">
<header>
<div class="header_first_column">
  <div style="width: 50px; height: 50px; float: left"> FLEX KITCHEN</div>
</div>
<div class="header_second_column" style="background-color:yellow;color:black"><h4> Aministration Bereich</h4></div>
<div class="header_third_column">
  <form class="search_form">
	<div style="float:right"><img style=" width:50px; float:right;" src="img/adminLogginImg.png" href="#" onclick="closeAdminSite()"></img></div>
	<div style="float:right"><img style=" height:60px;float:right;" src="img/home.png" href="#" onclick="goToAdminHome()"></img></div>
	<div style="float:right"> <input type="text" class="search" id="searchInAdminPage" onkeyup="searchUserInAdminPage()" placeholder="Search for names.." title="Type in a name"></div>
  </form>
</div>
</header>
  
<div class="content" id="contentInAdminPage">
<menu id="admin_home_manu" style="padding-left:0px">'.getAdminPageContent().'</menu>'.getWindowToAddNewProduct().getWindowToAddNewPerson().'</div>'.getFooter();
}

function getArticlePage(){
    require_once("login.php");
    require_once("php_script.php");
    $script = new FunctionScript();
    return '
    <!DOCTYPE html>
    <html>'.getPageScriptBinding().'<head>     
    </head>
    <body">
      
    <div class="flex-container">
    <header> 
      <div class="header_first_column">
        <div id="loggedUserImg" style="width:60px;height:60px;float:left; background-image:url(\''.getCurrentUserImagePath().'\');background-repeat:no-repeat;background-size: cover"></div>
        <div style="float:left"> <p id="loggedUserName">'.getCurrentUserName().'</p></div>
    </div> 
      <div class="header_second_column">'.getUserAccountBalance().'</div>
      <div class="header_third_column">
        <div style="float:right"><img style="width:50px; float:right;" src="logout.ico" href="#" onclick="closeAdminSite()"></img></div>
        <div style="float:right"><form class="search_form"><input class="search" type="text" id="search" placeholder="Search for article.." title="Type in a name"></form></div>
      </div>
    </header>
    <div class="content">
      <menu>'.$script->getArticleLIs().'</menu>
    </div>'.getFooter().'<div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <table style="font-size:3em">
          <tr><td colspan="2">Sie haben</td></tr>
          <tr><td colspan="2" id="selectedProductName">Clup Matte</td></tr>
          <tr><td colspan="2"> ausgewählt</td></tr>
          <tr>
            <td><button class="popupButton" id="productConfirmationBtn" style="background-image:url(\'img/ok_btn.png\')" onclick="sendSelectedProductForUser()"></button> </td>
            <td><button class="popupButton" id="productCancelationBtn" style="background-image:url(\'img/x_btn.png\')"></button></td>
          </tr>
        </table>
      </div>
    
    </div>';
}
function getFooter(){
    return '<div class="footer">
                <footer id="footer">Copyright &copy; e-oku.de</footer>
            </div>
            </div>
            </body>
            </html>';
}

function getPageScriptBinding(){
    return '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
        <script type="text/javascript" src="function.js"></script>
        <script type="text/javascript" src="./js/administration.js"></script>
        <link rel="stylesheet" href="./css/style.css">';
}

function getLoginPage(){
   return '
<style>
/* Full-width input fields */
.login_input {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.login_container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.login_modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.login_modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 20%; /* Could be more or less, depending on screen size */
    min-width: 300px;
}

/* The Close Button (x) */
.login_close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
    background-color: red;
    margin-top: -24px;
    margin-right: -25px;
    width: 35px;
}

.login_close:hover,
.login_close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.login_animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    .login_from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    .login_from {transform: scale(0)} 
    to {transform: scale(1)}
}
@media only screen and (max-device-width : 300px) {
  .login_modal-content{width: 80%}
}
@media (max-width : 300px) {
  .login_modal-content{width: 80%}
}
</style>

<div id="admin_login_Window" class="login_modal">
  
  <form class="login_modal-content login_animate login_form" action="php_scripts/login.php?admin_login_requested=1" method="POST">
    <div class="imgcontainer">
      <div onclick="document.getElementById(\'admin_login_Window\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
      <img style="width:200px"src="img/login_avatar.png" alt="Avatar" class="avatar">
    </div>

    <div class="login_container">
      <label><b class="label_text">EMail Address</b></label>
      <input class="login_input" type="text" placeholder="Enter EMail" name="email" required>

      <label><b class="label_text">Password</b></label>
      <input class="login_input" type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Login</button>
    </div>
    <div><!--Error msg here--></div>
  </form>
  
</div>
<script>
	// Get the modal
	var login_modal = document.getElementById(\'admin_login_Window\');

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
    	if (event.target == login_modal) {
        	modal.style.display = "none";
    	}
	}
</script>';
}

function getAdminPageContent(){
    return   '<li style="width:fil-content">
 <div class="user_div">
   <div class="user_img" style="background-image: url(\'img/users.png\');" href="#" onclick="getUsersInAdminPage()"></div>
   <p>Employees</p>
 </div>           
</li>
<li style="width:fil-content">
 <div class="user_div">
   <div class="user_img" style="background-image: url(\'img/products.png\');" href="#" onclick="getProducts()"></div>
   <p>Products</p>
 </div>    
</li>
<li style="width:fil-content">
 <div class="user_div">
   <div class="user_img" style="background-image: url(\'img/setting.png\');" href="#" onclick="showSetting()"></div>
   <p>Setting</p>
 </div>    
</li>';
}

function getWindowToAddNewProduct(){
    return'
<div id="add_product_form" class="login_modal">
  
  <form class="login_modal-content login_animate login_form" action="php_scripts/dbArticle.php?" method="POST">
    <div class="imgcontainer">
      <h4>ADD NEW PRODUCT</h4>
      <div onclick="document.getElementById(\'add_product_form\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
    </div>

    <div class="login_container">
      <label><b class="label_text">Produkt Name</b></label>
      <input class="login_input" type="text" placeholder="Enter Name" name="product_name" required>
      <label><b class="label_text">Select Category</b></label>
      <div><select name="product_category">
      '.getCategoryOptionsElement().'
      </select></div><br/>
      <label><b class="label_text">Price</b></label>
      <input class="login_input" type="text" placeholder="Enter price e.g. 1.0" name="product_price" required>

      <label><b class="label_text">Enter picture name</b></label>
      <input class="login_input" type="text" placeholder="e.g. test.png" name="product_img" required>
    </div>
    <div style="text-align: center; margin-bottom:10px"><button class="button" type="submit">Save</button></div>
  </form>
  
</div>';
}

function getWindowToAddNewPerson(){
    return'
<div id="add_customer_form" class="login_modal">
  
  <form class="login_modal-content login_animate login_form" action="php_scripts/dbutility.php?" method="POST" enctype="multipart/form-data">
  
    <div class="imgcontainer">
      <h4>ADD NEW CUSTOMER</h4>
      <div onclick="document.getElementById(\'add_customer_form\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
    </div>

    <div class="login_container">
      <label><b class="label_text">First Name</b></label>
      <input class="login_input" type="text" placeholder="Enter firstname" name="first_name" required>
      <label><b class="label_text">Last Name</b></label>
      <input class="login_input" type="text" placeholder="Enter lastname" name="last_name" required>
      <label><b class="label_text">Email</b></label>
      <input class="login_input" type="email" placeholder="e.g. testman@flexkitchen.com" name="email" required>
      <label><b class="label_text">Telefon</b></label>
      <input class="login_input" type="tel" name="telefon" required>
      <label><b class="label_text">Select picture</b></label>
      <input type="file" name="photo" id="user_photo" required>
    </div>
    <div style="text-align: center; margin-bottom:10px"><button class="button" type="submit">Save</button></div>
  </form>
  
</div>';
}

function getCategoryOptionsElement(){
    require("php_scripts/dbutility.php");
    $categories = getCategoriesFromDB();
    $result = "";
    foreach ($categories as $key => $value) {
        $result = $result."<option value=".$key.">".$value."</option>";
    }
    
     return $result;
}
?>
