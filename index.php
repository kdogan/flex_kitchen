
<?php include ("php_script.php"); ?>

<?php
$functions = new functions();
$functions->getSiteHead();
echo'
<head>

</head>
<body>

<div class="flex-container">
<header>
<div style="width: 50px; height: 50px; float: left"> FLEX KITCHEN
</div>
<div>
  <form class="search_form">
    <input type="text" id="search" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
  </form>
</div>
</header>
  
<div class="content">
  <menu>
  ';
  $functions->getUserLIs();
  echo '
  </menu>
</div>';
$functions->getFooter();

?>