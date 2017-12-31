
<?php include ("php_script.php"); ?>

<?php
$functions = new functions();
$functions->getSiteHead();
echo'
<head>
<script>
function checkCookie() {

    var idInCookie = getCookie("userid");
    var expiresInCookie = getCookie("expires");
    if (idInCookie !="" && expiresInCookie >= 0) {
        window.location.href = "articles.php";
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
<div class="header_second_column" style="color:#11111"> .</div>
<div class="header_third_column">
  <form class="search_form">
    <input type="text" id="search" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
  </form>
</div>
</header>
  
<div class="content">
  <menu>';
  $functions->getUserLIs();
  echo '
  </menu>
</div>';
$functions->getFooter();

?>