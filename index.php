
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
  <li class="user_div" id="user_div_id_1">
    <img class="user_img"src="https://codepo8.github.io/canvas-images-and-pixels/img/horse.png" href="#" onclick="clickUser(\'user_div_id_1\')"></img>
    <p>Max Pferdmann</p>
  </li>
  
  <?php echo \'Wohingegen das hier geparst wird.\'; ?>
  </menu>
</div>
<footer>Copyright &copy; flexlog.de</footer>
</div>
</body>
</html>';
?>