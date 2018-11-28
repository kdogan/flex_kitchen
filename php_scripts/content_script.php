<?php
include "dbutility.php";

function getCurrentPageContent(){
    require_once(__DIR__."/login.php");
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
    require_once("php_script.php");
    $script = new FunctionScript();

    $currentUserId = getSessionUserId();
    $purchasedArticle = $script->getLastPurchasedArticle($currentUserId);
    $articleName = $purchasedArticle['name'];
    $date  = $purchasedArticle['buy_date'];
    
    $amound = $script->getAccountBalanceOfCurrentUser();
    
    $color= "#616367";
    if( floatval($amound) < 0){
        $color= "#bf0000";
    }
    return '<div class="balance-container">
             <span>Kontostand: </span><span style="color: '.$color.'">'.$amound.' €</span>
            </div>
            <div class="lastbuy-container">
             <span>Letzter Kauf: </span><span>'.$articleName.' ('.$date.')</span>
            </div>';
}

function getHomePageContent(){
    require_once("./php_script.php");
    $script = new FunctionScript();
    return '<!DOCTYPE html>
            <html>'.getPageScriptBinding().'<head>
            </head>
            <body>
            <header>Mitarbeiter wählen</header>
            <div class="content">
              <form class="search_form">
                <div>
                  <input type="text" class="search" id="search" placeholder="Search for names.." title="Type in a name">
                </div>
              </form>
              <div class="users">'.$script->getUserLIs().'</div>'.getLoginPage().'
            </div>
            <footer>
              <div style="float:right" id="adminLoginBtn"><img style="width:45px; float:right;" src="img/adminLogginImg.png" href="#" onclick="login()"></img></div>
            </footer>
            <!--'.getFooter().'-->';

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
	
</script>
</head>
<body">

<header>Admin</header>
  
<div class="content" id="contentInAdminPage">
  <form class="search_form">
    <div style="float:right"> <input type="text" class="search" id="searchInAdminPage" onkeyup="searchUserInAdminPage()" placeholder="Search for names.." title="Type in a name"></div>
  </form>
  <menu id="admin_home_manu" style="padding-left:0px">'.getAdminPageContent().'</menu>'.getWindowToAddNewProduct().getWindowToAddNewPerson().'
  <!--<div id="header_second_column_in_admin"><div>-->
</div>
<footer class="admin-footer" id="admin-footer">
    <div class="header-btn-container" id="logout-from-admin"><img class="user_logout_img user_logout_in_admin_page" src="img/user_logout.png" href="#" onclick="closeAdminSite()"></img></div>
    <div class="" id="toggle-button"></div>
    <div class="header-btn-container" id="admin-home-button"><img class="home-btn" src="img/home.png" href="#" onclick="goToAdminHome()"></img></div>
  </footer>
<!--'.getFooter().'-->';
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
  
    <header> 
    <div id="loggedUserName">'.getCurrentUserName().'</div></div>
    </header>
    <div class="content">
      <div><form class="search_form"><input class="search" type="text" id="search" placeholder="Search for article.." title="Type in a name"></form></div>
      <div class="articles">'.$script->getArticleLIs().'</div>
    </div>
    <footer class="articlepage-footer">
      <div class="footer-container">
      <div class="header-btn-container"><img class="user_logout_img user_logout_in_article_page" src="img/user_logout.png" href="#" onclick="closeAdminSite()"></img></div>
        <div id="loggedUserImg" class="user_profil_icon" style="background-image:url(\''.$script->createUserImagePath(getCurrentUserImagePath()).'\')"></div>
        <div class="user_info">'.getUserAccountBalance().'</div>
      </div>
    </footer>
    <!--'.getFooter().'--><div id="myModal" class="modal">
      <!-- Modal content -->
      <div class="modal-content">
        <div>Du hast</div>
        <div id="selectedProductName">Getränk</div>
        <div>gewählt!</div>
        <div class="confirm-container">
          <button class="popupButton" id="productConfirmationBtn" style="background-image:url(\'img/ok_btn.png\')" onclick="sendSelectedProductForUser()">bestätigen</button>
          <button class="popupButton" id="productCancelationBtn" style="background-image:url(\'img/x_btn.png\')">abbrechen</button>
        </div>
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
    return '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
		    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.8.3/underscore.js"></script>
        <script type="text/javascript" src="function.js"></script>
        <script type="text/javascript" src="./js/administration.js"></script>
        <link href="http://fonts.googleapis.com/css?family=Open+Sans|Baumans" rel="stylesheet" lazyload/>
        <link rel="stylesheet" href="./css/style.css">';
}

function getLoginPage(){
   return '
<div id="admin_login_Window" class="login_modal">
  <form class="login_modal-content login_animate login_form" action="php_scripts/login.php?admin_login_requested=1" method="POST">
    <div class="imgcontainer">
      <div onclick="document.getElementById(\'admin_login_Window\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
      <img style="width:110px"src="img/adminLogginImg.png" alt="Avatar" class="avatar">
    </div>

    <div class="login_container">
      <label><b>EMail Address</b></label>
      <input class="login_input" type="text" placeholder="Enter EMail" name="email" required>

      <label><b>Password</b></label>
      <input class="login_input" type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Login</button>
    </div>
    <div><!--Error msg here--></div>
  </form>
  
</div>
<script>
	var login_modal = document.getElementById(\'admin_login_Window\');
	window.onclick = function(event) {
    	if (event.target == login_modal) {
        	modal.style.display = "none";
    	}
	}
</script>';
}

function getAdminPageContent(){
    return   '<li style="width:fil-content">
 <div class="admin_menu_div">
   <div class="admin_menu_img" style="background-image: url(\'img/users.png\');" href="#" onclick="getUsersInAdminPage()"></div>
   <p>Employees</p>
 </div>           
</li>
<li style="width:fil-content">
 <div class="admin_menu_div">
   <div class="admin_menu_img" style="background-image: url(\'img/products.png\');" href="#" onclick="getProducts()"></div>
   <p>Products</p>
 </div>    
</li>
<li style="width:fil-content">
 <div class="admin_menu_div">
   <div class="admin_menu_img" style="background-image: url(\'img/setting.png\');" href="#" onclick="showSetting()"></div>
   <p>Setting</p>
 </div>    
</li>';
}

function getWindowToAddNewProduct(){
    return'
<div id="add_product_form" class="login_modal">
  
  <form class="login_modal-content login_animate login_form" action="php_scripts/dbArticle.php?" method="POST" enctype="multipart/form-data">
    <div class="imgcontainer">
      <h4>ADD NEW PRODUCT</h4>
      <div onclick="document.getElementById(\'add_product_form\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
    </div>

    <div class="login_container">
      <label><b style="float:left">Produkt Name</b></label>
      <input class="login_input" type="text" placeholder="Enter Name" name="product_name" required>
      <label><b style="float:left">Select Category</b></label>
      <div><select name="product_category">
      '.getCategoryOptionsElement().'
      </select></div><br/>
      <label><b style="float:left">Price</b></label>
      <input class="login_input" type="text" placeholder="Enter price e.g. 1.0" name="product_price" required>

      <label><b style="float:left">Select a picture</b></label>
      <input type="file" name="product_img" id="article_photo" required>
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
      <label><b style="float:left">First Name</b></label>
      <input class="login_input" type="text" placeholder="Enter firstname" name="first_name" required>
      <label><b style="float:left">Last Name</b></label>
      <input class="login_input" type="text" placeholder="Enter lastname" name="last_name" required>
      <label><b style="float:left">Email</b></label>
      <input class="login_input" type="email" placeholder="e.g. testman@flexkitchen.com" name="email" required>
      <label><b style="float:left">Telefon</b></label>
      <input class="login_input" type="tel" name="telefon" required>
      <label><b style="float:left">Select picture</b></label>
      <input class="upload-picture-btn" type="file" name="photo" id="user_photo" required>
      <label for="user_photo"><span>Datei auswählen</span></label>
    </div>
    <div style="text-align: center; margin-bottom:16px"><button class="button" type="submit">Save</button></div>
  </form>
  
</div>';
}

function getCategoryOptionsElement(){
    require_once("php_script.php");
    $script = new FunctionScript();

    $categories = $script->getCategoriesFromDB();
    $result = "";
    foreach ($categories as $key => $value) {
        $result = $result."<option value=".$key.">".$value."</option>";
    }
    
     return $result;
}
?>
