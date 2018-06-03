
<?php

echo'
<link rel="stylesheet" href="./css/style.css">
<link rel="stylesheet" href="./css/window_style.css">


<div id="add_product_form" class="login_modal">
  
  <form class="login_modal-content login_animate login_form" action="php_scripts/dbArticle.php?" method="POST">
    <div class="imgcontainer">
      <h4>ADD NEW PRODUCT</h4>
      <div onclick="document.getElementById(\'add_product_form\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
    </div>

    <div class="login_container">
      <label><b>Produkt Name</b></label>
      <input class="login_input" type="text" placeholder="Enter Name" name="product_name" required>
      <label><b>Select Category</b></label>
      <div><select name="product_category">
      '.getCategoryOptionsElement().'
      </select></div><br/>
      <label><b>Price</b></label>
      <input class="login_input" type="text" placeholder="Enter price e.g. 1.0" name="product_price" required>

      <label><b>Enter picture name</b></label>
      <input class="login_input" type="text" placeholder="e.g. test.png" name="product_img" required>
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

function getCategoryOptionsElement(){
    require("php_scripts/dbutility.php");
    $categories = getCategoriesFromDB();
    $result = "";
    foreach ($categories as $key => $value) {
        $result = $result."<option value=".$key.">".$value."</option>";
    }
    
     return $result;
}
?>