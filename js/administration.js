function login(){
	var loginWindow = document.getElementById("admin_login_Window");
	loginWindow.style.display = "block";
}

function getUsersInAdminPage(){
  $.ajax({
      url: 'php_scripts/adminPageContent.php?userRequested=1',
      success: function(html) {
        document.getElementById('admin_home_manu').innerHTML = html;
        document.getElementById('toggle-button').innerHTML = '<img class="icon_image" src="img/add_user_icon.png" onclick="add_new_customer()"/>';
        document.getElementById('toggle-button').classList.add('header-btn-container');
      }
   });
}

function getProducts(){
  $.ajax({
      url: 'php_scripts/adminPageContent.php?productsRequested=1',
      success: function(html) {
        document.getElementById('admin_home_manu').innerHTML = html;
        document.getElementById('toggle-button').innerHTML = '<img class="icon_image" src="img/add_product_icon.png" onclick="add_new_product()"/>';
        document.getElementById('toggle-button').classList.add('header-btn-container');
      }
   });
}

function goToAdminHome(){
	$.ajax({
      url: 'php_scripts/adminPageContent.php?adminHomeRequested=1',
      success: function(html) {
        document.getElementById('admin_home_manu').innerHTML = html;
        document.getElementById('toggle-button').innerHTML = "";
        document.getElementById('toggle-button').classList.remove('header-btn-container');
      }
   });
}

function goToUserHistoryPage(personId){
  $.ajax({
      url: 'php_scripts/adminPageContent.php?userHirstoryPageRequested=1&personId='+personId,
      success: function(html) {
        document.getElementById('admin_home_manu').innerHTML = html;
        document.getElementById('toggle-button').innerHTML = '<img class="icon_image" src="img/go-back-arrow.png" onclick="getUsersInAdminPage()"/>';
        document.getElementById('toggle-button').classList.add('header-btn-container');
      }
   });
}

function add_new_product(){
  var loginWindow = document.getElementById("add_product_form");
  loginWindow.style.display = "block";
}
function add_new_customer(){
  var addNewEmployeeWindow = document.getElementById("add_customer_form");
  addNewEmployeeWindow.style.display = "block";
}

function showUserHistory(since, personId){

  var slider = document.getElementById("myRange");
  var output = document.getElementById("sinceXMonth");
  output.innerHTML = slider.value;

  slider.oninput = function() {
    output.innerHTML = this.value;
  }

  $.ajax({
    url: 'php_scripts/adminPageContent.php?userHistoryRequested=1&since='+since+"&personId="+personId,
    success: function(html) {
      let response = JSON.parse(html);
      document.getElementById('user_products_history_area').innerHTML = response["productList"];
      document.getElementById('user_payments_history_area').innerHTML = response["payments"];
    }
 });
}

function searchUserInAdminPage(){
  var value = document.getElementById("searchInAdminPage").value;
  $(".column").each(function() {
      if ($(this).text().toLowerCase().search(value.toLowerCase()) > -1) {
          $(this).show();
      }
      else {
          $(this).hide();
      }
  });
}

function checkInputForNumber(inputPayment,buttonId) {
    var input = document.getElementById(inputPayment);
    var payButton = document.getElementById(buttonId);

    var x=input.value;
    if (!isInputedAmoundValid(x) && x !="")
    {
        input.style.backgroundColor="#FF0000";
    }else{
        input.style.backgroundColor="#FFF";
    }
}

function updateUserAmount(userId, inputFieldId){

    var input = document.getElementById(inputFieldId);
    var amound = input.value;
    if(isInputedAmoundValid(amound)){
      $.ajax({
        url: 'php_scripts/dbutility.php?paymentRequested=1&id='+userId+'&amount='+amound,
        success: function(html) {
                  var obj = JSON.parse(html);
                  var idOfBalanceToBeUpdated = "accountBalance"+userId;
                  document.getElementById(idOfBalanceToBeUpdated).innerHTML = obj["newBalance"]+" €";
                  input.value = "";
                }
      });

    }
}

function updateProductNumber(productId, inputFieldId){
    var input = document.getElementById(inputFieldId);
    var productNumber = input.value;
    if (isInteger(productNumber)){
        $.ajax({
          url: 'php_scripts/dbutility.php?productId='+productId+'&productNumber='+productNumber,
          success: function(html) {
                    var obj = JSON.parse(html);
                    var idOfBalanceToBeUpdated = "numOfProduct"+productId;
                    var numberOfProduct = obj["newCount"];
                    document.getElementById(idOfBalanceToBeUpdated).innerHTML = numberOfProduct+" Stück";
                    input.value = "";
                    }
        });
    }
}

function confirmUserDeleting(personName, personId){
  var r = confirm("Möchten Sie wirklich "+personName+" löschen?");
    if (r == true) {
      setUserInActive(personId);
    } 
}

function setUserInActive(personId){
    $.ajax({
      url: 'php_scripts/dbutility.php?personId='+personId+'&setUserInActive=1',
      success: function(html) {
                var obj = JSON.parse(html);
                getUsersInAdminPage();
                }
    }); 
}

function confirmProductDeleting(productName, productId){
  var r = confirm("Möchten Sie wirklich das Product "+productName+" löschen?");
    if (r == true) {
      deleteProduct(productId);
    } 
}

function deleteProduct(productId){
  $.ajax({
    url: 'php_scripts/dbutility.php?productId='+productId+'&deleteProductRequested=1',
    success: function(html) {
              var obj = JSON.parse(html);
              getProducts();
              }
  }); 
}

function isInteger(x) {
  return x % 1 === 0;
}

function isInputedAmoundValid(value){
    var regex=/^\-?([1-9]\d*|0)(\.\d?[1-9])?$/;
    if(value=="" || !value.match(regex)) {
      return false;
    }
    else{
      return true;
    }
}

