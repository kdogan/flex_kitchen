
<?php

echo'
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/window_style.css">

<div id="add_customer_form" class="login_modal">
  
  <form class="login_modal-content login_animate login_form" action="php_scripts/dbutility.php?" method="POST" enctype="multipart/form-data">
  
    <div class="imgcontainer">
      <h4>ADD NEW CUSTOMER</h4>
      <div onclick="document.getElementById(\'add_customer_form\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
    </div>

    <div class="login_container">
      <label><b>First Name</b></label>
      <input class="login_input" type="text" placeholder="Enter firstname" name="first_name" required>
      <label><b>Last Name</b></label>
      <input class="login_input" type="text" placeholder="Enter lastname" name="last_name" required>
      <label><b>Email</b></label>
      <input class="login_input" type="email" placeholder="e.g. testman@flexkitchen.com" name="email" required>
      <label><b>Telefon</b></label>
      <input class="login_input" type="tel" name="telefon" required>
      <label><b>Select picture</b></label>
      <input type="file" name="photo" id="user_photo" required>
    </div>
    <div style="text-align: center; margin-bottom:10px"><button class="button" type="submit">Save</button></div>
  </form>
  
</div>
<script>
	// Get the modal
	var login_modal = document.getElementById(\'id01\');

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
    	if (event.target == login_modal) {
        	modal.style.display = "none";
    	}
	}
</script>';

?>