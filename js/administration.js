function login(){
	var loginWindow = document.getElementById("id01");
	loginWindow.style.display = "block";
}

function getUsersInAdminPage(){
  $.ajax({
      url: 'php_scripts/adminPageContent.php?userRequested=1',
      success: function(html) {
        document.getElementById('admin_home_manu').innerHTML = html;
      }
   });
}

function getProducts(){
  $.ajax({
      url: 'php_scripts/adminPageContent.php?productsRequested=1',
      success: function(html) {
        document.getElementById('admin_home_manu').innerHTML = html;
      }
   });
}

function goToAdminHome(){
	$.ajax({
      url: 'php_scripts/adminPageContent.php?adminHomeRequested=1',
      success: function(html) {
        
        document.getElementById('admin_home_manu').innerHTML = html;
      }
   });
}

function add_new_product(){
  var loginWindow = document.getElementById("add_product_form");
  loginWindow.style.display = "block";
}
function add_new_employee(){
  var addNewEmployeeWindow = document.getElementById("add_employee_form");
  addNewEmployeeWindow.style.display = "block";
}