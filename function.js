var clickedArticleId = "";
$(function() {

  $("#search")
    .on("keyup", function(e) {
      if (e.which == 13 || e.which == 27) {
        $(e.target).val('');
      }

      var value = $(e.target).val();
      $("menu > li").each(function() {
          if ($(this).text().toLowerCase().search(value.toLowerCase()) > -1) {
              $(this).show();
          }
          else {
              $(this).hide();
          }
      });
    });
});

function clickUser(id){
  destroyPHPSession();
  if(setPHPSession(id)){
    window.location.href = "index.php";
    showUserAccountBalance();
  }
}

function destroyPHPSession(){
  var isDestroyed = false;
  $.ajax({
      url: 'php_scripts/login.php?destroySessionRequested=1',
      success: function(html) {
        var obj = JSON.parse(html);
        isDestroyed = obj.isSessionDestroyed;
      }
  });

  return isDestroyed;
}

function setPHPSession(userId){
  var sessionCreated = 0;
  $.ajax({
      url: 'php_scripts/login.php?user_id='+userId+'&password=0',//TODO : set password if required
      async: false,
      success: function(html) {
        var obj = JSON.parse(html);
        sessionCreated = obj.isSessionCreated; 
      }
  });
  return sessionCreated;

}

function clickArticle(articleId){
  var modal = document.getElementById('myModal');
  modal.style.display = "block";
  clickedArticleId = articleId;
  setSelectedArticleNameInPopupWindow(articleId);
}

window.onclick = function(event) {

  var targetId = event.target.id;
  if(targetId == "productConfirmationBtn" || targetId == "productCancelationBtn"){
    document.getElementById('myModal').style.display = "none";
    window.location.href = "index.php";
  }
}

function setCookie(userId,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = "userid="+escape(userId)+ ";expires="+expire.toGMTString();
}

function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}
function logout(name) {
  setCookie("userid", "",0);
  window.location.href = "index.php";
}

function showUserAccountBalance() {
    $.ajax({
        url: 'php_scripts/dbutility.php?accountBalanceRequested=1',
        async: false,
        success: function(html) {
              var obj = JSON.parse(html);
              //show until 3 digit after . e.g. 12.321
              var amound = obj;
              var afterCommaLength = obj.toString().split(".")[1].length;
              if(afterCommaLength > 3){
                var indexToCut = obj.indexOf(".") + 3;
                amound = obj.substr(0, indexToCut);
              }

              document.getElementById('accountBalance').innerHTML = amound+' €';
              if(obj.account_balance < 0){
                document.getElementById('accountBalance').style.backgroundColor = "red";
              }
        }
    });
    showLastBuyOfCurrentUser();
}
function closeAdminSite(){
  $.ajax({
      url: 'php_scripts/login.php?logoutRequested=1',
      success: function(html) {
            var obj = JSON.parse(html);
            window.location.reload();
            //window.location.href = "index.php";
      }
  });
}
function showLastBuyOfCurrentUser(){
  $.ajax({
    url: 'php_scripts/dbPersonArticleMatrix.php?lastEntryRequested=1',
    success: function(html) {
          var obj = JSON.parse(html);

          if(obj.name !="" || obj.price !=""){
            document.getElementById('lastBuy').innerHTML = obj.name;
          }
    }
});
}

function sendSelectedProductForUser(){
  $.ajax({
      url: 'php_scripts/dbutility.php?selectedArticleId='+clickedArticleId+'&articleBoughtRequsted=1',
      success: function(html) {
                var obj = JSON.parse(html);
                showUserAccountBalance();
               }
  });
}

function setSelectedArticleNameInPopupWindow(articleId){
  var article = "";
  $.ajax({
      url: 'php_scripts/dbArticle.php?id='+articleId,
      success: function(html) {
                var obj = JSON.parse(html);
                var selectedArticleName = document.getElementById('selectedProductName');
                selectedProductName.innerHTML = obj["name"];
                selectedProductName.style.fontWeight = 'bold';
               }
          });
}


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#blah')
                .attr('src', e.target.result)
                .width(150)
                .height(150);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
