<!-- 
user profile page (not admin user)
allow user to change Fname, Lname
direct user to reset password and send feedback page
-->
<?php
include 'logfunctions.php';
  dbConnect();
  session_start();
  $loginPage = "login.php";
if(isset($_SESSION['userId'])) {
	$userId = $_SESSION['userId'];
	}else {
    $user = null;
    //direct back to login page if not logged in
    //echo "<meta http-equiv='refresh' content='1; url=$loginPage'>";
	}
?>

<!DOCTYPE html>

<style>
.login_btn1{
  color: black;
  background-color: #FFC312;
  width: 40%;
  margin-left: auto;
  margin-top:5px;
}
.card1{
  height: fill;
  margin-top: auto;
  margin-bottom: auto;
  width: fill;
  background-color: gray; 
}
.modBtn{
  position: absolute;
  right: 3%;
  /* background-color: #goldenrod; Green */
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  cursor: pointer;
  color: goldenrod; 
  border: 2px solid goldenrod;
  border-radius: 8px;
}
.modBtn:hover {
  background-color: goldenrod;
  color: black;
}
.modBtn1{
  margin-top:13px;
  width:80px;
  height:30px;
  position: absolute;
  right: 5%;
  /* background-color: #goldenrod; Green */
  border: none;
  font-size:18px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  background-color: white;
  cursor: pointer;
  color: goldenrod; 
  border: 2px solid goldenrod;
  border-radius: 8px;
}
.modBtn1:hover {
  background-color: goldenrod;
  color: black;
}
.updateBtn{
  position: absolute;
  right: 3%;
  /* background-color: #goldenrod; Green */
  border: none;
  color: white;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  cursor: pointer;
  color: grey; 
  border: 2px solid grey;
  padding-top:2px;
  border-radius: 8px;
}
.updateBtn:hover {
  background-color: goldenrod;
  color: white;
}
.updateBtn1{
  margin-top:18px;
  width:80px;
  height:30px;
  position: absolute;
  right: 5%;
  /* background-color: #goldenrod; Green */
  border: none;
  font-size:18px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  -webkit-transition-duration: 0.4s; /* Safari */
  transition-duration: 0.4s;
  background-color: white;
  cursor: pointer;
  color: grey; 
  border: 2px solid grey;
  border-radius: 8px;
}
.updateBtn1:hover {
  background-color: goldenrod;
  color: white;
}
.profile_input{
  width:50%;
  padding: 0px 12px;
  border-radius: 4px;
}
.title{
  color:goldenrod;
  position: absolute;
  left: 4%;
  font-weight: bold;
}
.New_username_input{
  width:50%;
  padding: 0px 12px;
  border-radius: 4px;
  font-size:20px;
}
.backbutton{
  position: absolute;
  left: 4%;
  margin-top:20px;
}
</style>

<script>
var check = function() {
  if (document.getElementById('Newpassword').value ==
    document.getElementById('RepeatNewpassword').value) {
    document.getElementById('pwmessage').style.color = 'white';
    document.getElementById('pwmessage').style.margin = '10px';
    document.getElementById('pwmessage').innerHTML = 'Matching';
  } else {
    document.getElementById('pwmessage').style.color = 'goldenrod';
    document.getElementById('pwmessage').style.margin = '10px';
    document.getElementById('pwmessage').innerHTML = 'Not Matching';
  }
} 
var checkLength = function(){
  if (document.getElementById('Newpassword').value.length < 8){
    document.getElementById('pwLengthmessage').innerHTML = 'Minimum 8 Characters';
    document.getElementById('pwLengthmessage').style.color = 'goldenrod';
    document.getElementById('pwLengthmessage').style.margin = '10px';
  }else{
    document.getElementById('pwLengthmessage').innerHTML = 'Good Password';
    document.getElementById('pwLengthmessage').style.color = 'white';
    document.getElementById('pwLengthmessage').style.margin = '10px';
  }
}

var disableRegBtn = function(){
  if (document.getElementById('Newpassword').value == 
    document.getElementById('RepeatNewpassword').value && document.getElementById('Newpassword').value.length >= 8 && document.getElementById('Currentpassword').value.length >= 8) {
    document.getElementById("regBtn").disabled = false;
  } else {
    document.getElementById("regBtn").disabled = true;
  }
}

function mod_Fname() {
  var x = document.getElementById("mod_Fname");
  if (x.style.display == "block") {
    x.style.display = "none";
  } else {
    x.style.display = "block";
  }
}
function mod_Lname() {
  var x1 = document.getElementById("mod_Lname");
  if (x1.style.display == "block") {
    x1.style.display = "none";
  } else {
    x1.style.display = "block";
  }
}
function mod_username() {
  var x2 = document.getElementById("mod_username");
  if (x2.style.display == "block") {
    x2.style.display = "none";
  } else {
    x2.style.display = "block";
  }
}
function mod_email() {
  var x5 = document.getElementById("mod_email");
  if (x5.style.display == "block") {
    x5.style.display = "none";
  } else {
    x5.style.display = "block";
  }
}
function reset_pw() {
  var x3 = document.getElementById("reset_pw");
  if (x3.style.display == "block") {
    x3.style.display = "none";
  } else {
    x3.style.display = "block";
  }
}
function reset_pw1() {
  var x4 = document.getElementById("reset_pw");
  if (x4.style.display == "none") {
    x4.style.display = "block";
  } 
}
function openwinhome(){
  window.open("home.php", "_self");
}
</script>

<html>
    <head>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
        <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
        <link href="./cssFiles/styleSheet.css" rel="stylesheet">
    <body style="margin-top:5%">
     
      <div class="card mx-auto mh-100 text-center" style="height: 450px;">
      <div class="backbutton">

      <i class="fas fa-arrow-circle-left fa-3x" style="color:goldenrod;" onclick="openwinhome();"></i>

      </div>
        <div class="card-header">
       <i class="fas fa-user fa-7x " style="color:goldenrod; margin-top:20px;"></i>
       <h4 class="usernameText" style="color:white; font-size:40px; margin-top:20px;"><b>
              <?php
                get_userName();
              ?>
            </b>
            <button class="modBtn1" type="button" onclick="mod_username()">Update</button>
            <form method="POST" action="profile.php">
              <div id="mod_username" style="display: none;">
                <input type="text" class="New_username_input" name="newUsername" placeholder="Enter a New Username" required="required">
                <button class="updateBtn1" type="submit" name="updateUsername">Submit</button>
                <?php
                  update_Username();
                ?>
              </div>
            </form>
            </h4>
        </div>

      <div class="card1">
       <div class="card-body">

        
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <span class="title">First Name</span>
            
            <?php
              get_Fname();
            ?>
            <button class="modBtn" type="button" onclick="mod_Fname()">Update</button>
              <li class="list-group-item" id="mod_Fname" style="display: none;">
              <form method="POST" action="profile.php">
              <input type="text" class="profile_input" name="newFname" placeholder="Update First Name" required="required">
              <button class="updateBtn" type="submit" name="updateFname">Submit</button>
                <?php
                  update_Fname();
                ?>
              </form>
              </li>
          </li>

          <li class="list-group-item">
          <span class="title">Last name</span>
            <?php
              get_Lname();
            ?>
          <button class="modBtn" type="button" onclick="mod_Lname()">Update</button>
              <li class="list-group-item" id="mod_Lname" style="display: none;">
              <form method="POST" action="profile.php">
              <input type="text" class="profile_input" name="newLname" placeholder="Update Last Name" required="required">
              <button class="updateBtn" type="submit" name="updataLname">Submit</button>
                <?php
                  update_Lname();
                ?>
              </form>
              </li>
          </li>

          <li class="list-group-item">
          <span class="title">Email</span>
          <?php
          get_email();
          ?>
            <button class="modBtn" type="button" onclick="mod_email()">Update</button>
                <li class="list-group-item" id="mod_email" style="display: none;">
                <form method="POST" action="profile.php">
                <input type="email" class="profile_input" name="newEmail" placeholder="Update Email Address" required="required">
                <button class="updateBtn" type="submit" name="updataEmail">Submit</button>
                  <?php
                    update_email();
                  ?>
                </form>

          </li>
        </ul>

        <div class="card-body bg-dark">
          <a href="#" class="card-link" style="color:goldenrod" onclick="reset_pw()">Reset Password</a>
             <form method="POST" id="reset_pw" action="profile.php" style="display: none;margin-top:20px;">

                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-unlock-alt"></i></span>
                  </div>
                  <input type="password" class="form-control" id="Currentpassword" name="Currentpassword" placeholder="Current Password" required="required" onkeyup ='disableRegBtn();'>
                </div>

                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                  </div>
                  <input type="password" class="form-control" id="Newpassword" name="Newpassword" placeholder="New Password" required="required" onkeyup ='checkLength(),check(), disableRegBtn();'>
                  <span id='pwLengthmessage'> </span>
                </div>

                <div class="input-group form-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
                  </div>
                  <input type="password" class="form-control" id="RepeatNewpassword" name="RepeatNewpassword" placeholder="Repeat New Password" required="required" onkeyup ='checkLength(),check(), disableRegBtn();'>
                  <span id='pwmessage'> </span>
                </div>

                <span style="color:goldenrod;">
                <?php
                  if(isset($_POST['changePw'])){
                    resetPwProfilePage();
                  }
                ?>
                </span>

                <input type="submit" id="regBtn" name="changePw" value="Change Password" class="btn  login_btn1" >

            </form>
          <!-- </li> -->
        </div>
        </div>
      </div>
      </div>
  
</body>
</html>


