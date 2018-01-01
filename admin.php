
<?php 
include ("php_scripts/administration.php"); 
include ("php_script.php");
?>

<?php
$functions = new functions();
$functions->getSiteHead();

echo'
<script type="text/javascript" src="js/administration.js"></script>
<head>
<script>
function checkCookie() {

    // hier muss die Admin session geprüft werden
}
</script>
</head>
<body onLoad="checkCookie();">

<div class="flex-container">
<header>
<div class="header_first_column">
  <div style="width: 50px; height: 50px; float: left"> FLEX KITCHEN</div>
</div>
<div class="header_second_column" style="background-color:yellow;color:black"><h4> Aministration Bereich</h4></div>
<div class="header_third_column">
  <form class="search_form">
  <div style="float:right"><img style="width:50px; float:right;" src="img/adminLogginImg.png" href="#" onclick="closeAdminSite()"></img></div>
   <!--<div style="float:right"> <input type="text" id="search" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"></div>-->
  </form>
</div>
</header>
  
<div class="content">
  <menu>
  <li style="width:fil-content">
      <div class="user_div" id="admin_users">
        <div class="user_img" style="background-image: url(\'img/users.png\');" href="#" onclick="showUsers()"></div>
        <p>Employees</p>
      </div>           
    </li>
    <li style="width:fil-content">
      <div class="user_div" id="admin_users">
        <div class="user_img" style="background-image: url(\'img/products.png\');" href="#" onclick="showUsers()"></div>
        <p>Products</p>
      </div>    
    </li>
    <li style="width:fil-content">
      <div class="user_div" id="admin_users">
        <div class="user_img" style="background-image: url(\'img/setting.png\');" href="#" onclick="showUsers()"></div>
        <p>Setting</p>
      </div>    
    </li>
  </menu>
</div>';
$functions->getFooter();

?>