
<?php 
include ("php_scripts/administration.php"); 
include ("php_script.php");
?>

<?php
$administration = new administration();
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
  <div style="float:right"><img style=" width:50px; float:right;" src="img/adminLogginImg.png" href="#" onclick="closeAdminSite()"></img></div>
  <div style="float:right"><img style=" height:60px;float:right;" src="img/home.png" href="#" onclick="showUsers()"></img></div>
  </form>
</div>
</header>
  
<div class="content">';
  
  $administration->getFirstContentOfAdminSite();
  
echo '</div>';
$functions->getFooter();

?>