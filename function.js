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

  setCookie("userid",id,1);
  //require password from user if loggin is activatet!!!
  window.location.href = "articles.php";
}

function setCookie(cname,cvalue,exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires=" + d.toGMTString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
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

function getUserNameForId(id) {
    $.ajax({
            url: 'php_scripts/dbutility.php?id='+id, //call storeemdata.php to store form data
            success: function(html) {
                      var obj = JSON.parse(html);
                      var ajaxDisplay = document.getElementById('foo');
                      ajaxDisplay.innerHTML = obj.firstname + " "+obj.lastname;

                      //set logged user image src
                      document.getElementById("loggedUserImg").src=obj.img_path;
                    }
          });
}


