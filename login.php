<?php
echo'
<style>
/* Full-width input fields */
.login_input {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

/* Set a style for all buttons */
button {
    background-color: #4CAF50;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

button:hover {
    opacity: 0.8;
}

/* Extra styles for the cancel button */
.cancelbtn {
    width: auto;
    padding: 10px 18px;
    background-color: #f44336;
}

/* Center the image and position the close button */
.imgcontainer {
    text-align: center;
    margin: 24px 0 12px 0;
    position: relative;
}

img.avatar {
    width: 40%;
    border-radius: 50%;
}

.login_container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

/* The Modal (background) */
.login_modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    padding-top: 60px;
}

/* Modal Content/Box */
.login_modal-content {
    background-color: #fefefe;
    margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
    border: 1px solid #888;
    width: 30%; /* Could be more or less, depending on screen size */
}

/* The Close Button (x) */
.login_close {
    position: absolute;
    right: 25px;
    top: 0;
    color: #000;
    font-size: 35px;
    font-weight: bold;
    background-color: red;
    margin-top: -24px;
    margin-right: -25px;
    width: 35px;
}

.login_close:hover,
.login_close:focus {
    color: red;
    cursor: pointer;
}

/* Add Zoom Animation */
.login_animate {
    -webkit-animation: animatezoom 0.6s;
    animation: animatezoom 0.6s
}

@-webkit-keyframes animatezoom {
    .login_from {-webkit-transform: scale(0)} 
    to {-webkit-transform: scale(1)}
}
    
@keyframes animatezoom {
    .login_from {transform: scale(0)} 
    to {transform: scale(1)}
}
@media only screen and (max-device-width : 300px) {
  .login_modal-content{width: 80%}
}
@media (max-width : 300px) {
  .login_modal-content{width: 80%}
}

</style>

<div id="id01" class="login_modal">
  
  <form class="login_modal-content login_animate login_form" action="php_scripts/login.php?login=1" method="POST">
    <div class="imgcontainer">
      <div onclick="document.getElementById(\'id01\').style.display=\'none\'" class="login_close" title="Close Modal">&times;</div>
      <img style="width:200px"src="img/login_avatar.png" alt="Avatar" class="avatar">
    </div>

    <div class="login_container">
      <label><b>EMail Address</b></label>
      <input class="login_input" type="text" placeholder="Enter EMail" name="email" required>

      <label><b>Password</b></label>
      <input class="login_input" type="password" placeholder="Enter Password" name="password" required>
        
      <button type="submit">Login</button>
    </div>
    <div></div>
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