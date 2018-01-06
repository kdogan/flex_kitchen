
<?php 
include ("php_script.php");
include ("php_scripts/login.php");
?>

<?php
$functions = new functions();
$functions->getSiteHead();

echo '
	<script type="text/javascript" src="js/administration.js"></script>
	<head>
	<script>
	function checkAccessForCurrentUser() {';
	echo "if(".$_SESSION["isAdmin"]." == 0){
		alert('Access danied for user id ".$_SESSION["userid"]."! You are not admin');
		window.location.href = \"index.php\";}";
echo '}
</script>
</head>
<body onLoad="checkAccessForCurrentUser();">

<div class="flex-container">
<header>
<div class="header_first_column">
  <div style="width: 50px; height: 50px; float: left"> FLEX KITCHEN</div>
</div>
<div class="header_second_column" style="background-color:yellow;color:black"><h4> Aministration Bereich</h4></div>
<div class="header_third_column">
  <form class="search_form">
  <div style="float:right"><img style=" width:50px; float:right;" src="img/adminLogginImg.png" href="#" onclick="closeAdminSite()"></img></div>
  <div style="float:right"><img style=" height:60px;float:right;" src="img/home.png" href="#" onclick="showUsers()"></img></div>
  </form>
</div>
</header>
  
<div class="content">';
  
  echo '
<menu>
  <li style="width:fil-content">
      <div class="user_div">
        <div class="user_img" style="background-image: url(\'img/users.png\');" href="#" onclick="showUsers()"></div>
        <p>Employees</p>
      </div>           
    </li>
    <li style="width:fil-content">
      <div class="user_div">
        <div class="user_img" style="background-image: url(\'img/products.png\');" href="#" onclick="showUsers()"></div>
        <p>Products</p>
      </div>    
    </li>
    <li style="width:fil-content">
      <div class="user_div">
        <div class="user_img" style="background-image: url(\'img/setting.png\');" href="#" onclick="showUsers()"></div>
        <p>Setting</p>
      </div>    
    </li>
  </menu>';
  
echo '</div>';
$functions->getFooter();

?>