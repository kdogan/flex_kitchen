
<?php include ("php_script.php"); ?>
<?php
$functions = new functions();
$functions->getSiteHead();
echo '
</head>
<body>

<div class="flex-container">
<header>';
$functions->getActiveUserIcon();
  echo '<div style="float:right">
    <img style="width:50px; float:right;" src="logout.ico" href="#"></img>
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