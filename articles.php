
<?php include ("php_script.php"); ?>
<?php
$functions = new functions();
$functions->getSiteHead();
echo '
</head>
<body>

<div class="flex-container">
<header>
  <div style="width:60px;float:left">
    <img class="user_img" style="background-color: black" src="https://codepo8.github.io/canvas-images-and-pixels/img/horse.png" href="#"></img>
</div>
  <div style="float:left"><p>Max Pferdmann</p></div>
  <div style="float:right">
    <img style="width:50px; float:right;" src="logout.ico" href="#"></img>
  </div>
  <div style="float:right">
    <form class="search_form"><input type="text" id="search" onkeyup="myFunction()" placeholder="Search for article.." title="Type in a name"></form>
  </div>
  
</header>
  
<div class="content">
 

  <menu>
  ';
  $functions->getArticleLIs();
  echo '
  </menu>
</div>';

$functions->getFooter();
?>