
<?php 
  include ("php_script.php"); 
  include ("php_scripts/login.php");
?>
<?php
$functions = new functions();
$functions->getSiteHead();
echo '
<script type="text/javascript">
  function checkCookie(){
      if('.hasSession().'){
        if('.isAdmin().'){
          window.location.href = "admin.php";
        }else{
          setLoggedUser('.getSessionUserId().');
        }
      }else{
        window.location.href = "index.php";
      }
  }
  </script>
</head>
<body onLoad="checkCookie();">
  
<div class="flex-container">
<header> 
<!-- Header: first column -->
  <div class="header_first_column">
    <div id="loggedUserImg" style="width:60px;height:60px;float:left; background-image:url(\'img/default_user_img.png\');background-repeat:no-repeat;background-size: cover"></div>
    <div style="float:left"> <p id="loggedUserName"></p></div>
</div> 
<!-- Header: first column End-->
<!-- Header: second column -->
  <div class="header_second_column">'. $functions->getUserAccountBalance().'</div>
<!-- Header: second column End-->
<!-- Header: third column -->
  <div class="header_third_column">
    <div style="float:right"><img style="width:50px; float:right;" src="logout.ico" href="#" onclick="closeAdminSite()"></img></div>
    <div style="float:right"><form class="search_form"><input class="search" type="text" id="search" onkeyup="myFunction()" placeholder="Search for article.." title="Type in a name"></form></div>
  </div>
  <!-- Header: third column End-->
</header>
<div class="content">
  <menu>'.$functions->getArticleLIs().'</menu>
</div>'.$functions->getFooter();


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

?>
