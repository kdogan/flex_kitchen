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
  setSelectedArticle(articleId);
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
                    }
          });
}
function setSelectedArticle(id) {
    $.ajax({
            url: 'php_scripts/dbArticle.php?id='+id,
            success: function(html) {
                      var obj = JSON.parse(html);

                      if(obj.name !="" || obj.price !=""){
                        document.getElementById('selectedArticle').style.display = "block";
                        // set logged user name
                        document.getElementById('selectedArticleName').innerHTML = obj.name;
                        document.getElementById('selectedArticlePrice').innerHTML = obj.price+'€';
                      }
                      
                      if(obj.img_path !=""){
                        //set logged user image src
                        document.getElementById('selectedArticleImg').src=obj.img_path;
                      }
                    }
          });
}


