
<?php include ("php_script.php"); ?>
<?php
$functions = new functions();
$functions->getSiteHead();
echo '
</head>
<body>
  <script type="text/javascript">
      setLoggedUser(getCookie("userid"));
  </script>
<div class="flex-container">
<header>';
$functions->getActiveUserIcon();
echo '<div id="selectedArticle" style="float:left; display:none;">
        <table>
          <tr>
            <td rowspan="2"><img id="selectedArticleImg" style="width:60px; height:60px;" src="https://codepo8.github.io/canvas-images-and-pixels/img/horse.png" href="#"></img></td>
            <td rowspan="2"><p id="selectedArticleName"></p> <strong><p id="selectedArticlePrice"></p></strong></td>
            <td><img id="confirmArticleBtn" style="width:30px; height:30px;" src="img/ok_btn.png" href="#"></img></td>
          </tr>
          <tr>
            <td><img id="cancelArticleBtn" style="width:30px; height:30px;" src="img/x_btn.png" href="#"></img></td>
          </tr>
        </table>
      </div>';

echo '<div style="float:right">
        <img style="width:50px; float:right;" src="logout.ico" href="#" onclick="logout(\'userid\')"></img>
      </div>
      <div style="float:right">
        <form class="search_form"><input type="text" id="search" onkeyup="myFunction()" placeholder="Search for article.." title="Type in a name"></form>
      </div>
</header>
<div class="content">
  <menu>';
  $functions->getArticleLIs();
  echo '
  </menu>
</div>';

$functions->getFooter();
?>