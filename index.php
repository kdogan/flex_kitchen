
<?php 
  include ("php_script.php"); 
  include ("php_scripts/login.php"); 
?>

<?php
$functions = new functions();
$functions->getSiteHead();
echo'
<head>
<script>
function checkCookie() {
  if('.hasSession().'){
    if('.isAdmin().'){
      document.getElementById("adminLoginBtn").style.display="none";
      window.location.href = "admin.php";
      }else{
        window.location.href = "articles.php";
      }
  }
    
}
</script>
</head>
<body onLoad="checkCookie();">

<div class="flex-container">
<header>
<div class="header_first_column">
  <div style="width: 50px; height: 50px; float: left"> FLEX KITCHEN</div>
</div>
<div class="header_second_column" style="color:#83bb26"> .</div>
<div class="header_third_column">
  <form class="search_form">
  <div style="float:right" id="adminLoginBtn"><img style="width:50px; float:right;" src="img/adminLogginImg.png" href="#" onclick="login()"></img></div>
   <div style="float:right"> <input type="text" class="search" id="search" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name"></div>
  </form>
</div>
</header>
  
<div class="content">
  <menu>'. $functions->getUserLIs().' </menu>
</div>'.$functions->getFooter();

include ('login.php');

?>