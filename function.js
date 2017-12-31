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

function clickUser(user, id){
  // remove previous cockie
  setCookie("userid",'',-1);
  // set new cookie
  setCookie("userid",id,1);

  //TODO : require password from user if loggin is activatet!!!
  window.location.href = "articles.php";
}

function clickArticle(articleId){
  //TODO hier muss eine popup fenster gemacht werden und ausgewählte article darstellen
  var modal = document.getElementById('myModal');
  modal.style.display = "block";
  clickedArticleId = articleId;
}

window.onclick = function(event) {

  var targetId = event.target.id;
  if(targetId == "productConfirmationBtn" || targetId == "productCancelationBtn"){
    document.getElementById('myModal').style.display = "none";
    window.location.href = "articles.php";
  }
}

function setCookie(cookieName,cookieValue,nDays) {
 var today = new Date();
 var expire = new Date();
 if (nDays==null) nDays=1;
 expire.setTime(today.getTime() + 3600000*24*nDays);
 document.cookie = cookieName+"="+escape(cookieValue)+ ";expires="+expire.toGMTString();
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

function setLoggedUser(id) {
    $.ajax({
            url: 'php_scripts/dbutility.php?id='+id, //call storeemdata.php to store form data
            success: function(html) {
                      var obj = JSON.parse(html);

                      if(obj.firstname !="" || obj.lastname !=""){
                        // set logged user name
                        document.getElementById('loggedUserName').innerHTML = obj.firstname + " "+obj.lastname;
                      }
                      
                      if(obj.img_path !=""){
                        //set logged user image src
                        document.getElementById('loggedUserImg').style.backgroundImage = "url('"+obj.img_path+"')";
                      }
                      var indexToCut = obj.account_balance.indexOf(".")+3;

                      document.getElementById('accountBalance').innerHTML = obj.account_balance.substr(0, indexToCut)+' €';
                      if(obj.account_balance < 0){
                        document.getElementById('accountBalance').style.backgroundColor = "red";
                      }
                    }
          });
    setAccountBalance(id,1);
}

function setAccountBalance(personId, lastEntryRequsted){

  $.ajax({
            url: 'php_scripts/dbPersonArticleMatrix.php?person_id='+personId+'&lastEntry='+lastEntryRequsted,
            success: function(html) {
                      var obj = JSON.parse(html);

                      if(obj.name !="" || obj.price !=""){
                        // set logged user name
                        document.getElementById('lastBuy').innerHTML = obj.name;
                      }
                    }
          });
}

function sendSelectedProductForUser(){
  var currentUserId = getCookie("userid");
  $.ajax({
      url: 'php_scripts/dbPersonArticleMatrixPost.php?selectedArticleId='+clickedArticleId+'&personId='+currentUserId, //call storeemdata.php to store form data
      success: function(html) {
                var obj = JSON.parse(html);

               }
          });
}


