
<?php 
  include ("php_script.php"); 
  include ("php_scripts/login.php");
?>
<?php
$functions = new functions();
$functions->getSiteHead();
echo '
</head>
<body>
  <script type="text/javascript">
      if('.!isAdmin().'){
        setLoggedUser('.$_SESSION["userid"].');
      }else{
        window.location.href = "index.php";
      }
  </script>
<div class="flex-container">
<header> 
<!-- Header: first column -->
  <div class="header_first_column">';
    $functions->getActiveUserIcon();
echo '
</div> 
<!-- Header: first column End-->
<!-- Header: second column -->
  <div class="header_second_column">';
    $functions->getUserAccountBalance();
echo '</div>
<!-- Header: second column End-->
<!-- Header: third column -->
  <div class="header_third_column">
    <div style="float:right"><img style="width:50px; float:right;" src="logout.ico" href="#" onclick="closeAdminSite()"></img></div>
    <div style="float:right"><form class="search_form"><input type="text" id="search" onkeyup="myFunction()" placeholder="Search for article.." title="Type in a name"></form></div>
  </div>
  <!-- Header: third column End-->
</header>
<div class="content">
  <menu>';
  $functions->getArticleLIs();
  echo '
  </menu>
</div>';

echo '<div id="myModal" class="modal">
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

$functions->getFooter();
?>