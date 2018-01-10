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

function goToAdminHome(){
	$.ajax({
      url: 'php_scripts/adminPageContent.php?adminHomeRequested=1',
      success: function(html) {
        
        document.getElementById('admin_home_manu').innerHTML = html;
      }
   });
}