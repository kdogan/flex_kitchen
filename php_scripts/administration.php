<?php
class administration {

	public function __construct(){
    }

function getFirstContentOfAdminSite(){

	echo '
<menu>
  <li style="width:fil-content">
      <div class="user_div" id="admin_users">
        <div class="user_img" style="background-image: url(\'img/users.png\');" href="#" onclick="showUsers()"></div>
        <p>Employees</p>
      </div>           
    </li>
    <li style="width:fil-content">
      <div class="user_div" id="admin_users">
        <div class="user_img" style="background-image: url(\'img/products.png\');" href="#" onclick="showUsers()"></div>
        <p>Products</p>
      </div>    
    </li>
    <li style="width:fil-content">
      <div class="user_div" id="admin_users">
        <div class="user_img" style="background-image: url(\'img/setting.png\');" href="#" onclick="showUsers()"></div>
        <p>Setting</p>
      </div>    
    </li>
  </menu>';
}
}

?>