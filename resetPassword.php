<!DOCTYPE html>

<style>
.card1{
  height: fill;
  margin-top: auto;
  margin-bottom: auto;
  width: 550px;
  background-color: gray; 
}
.regStyle{
  margin-top: 5%;
}

.login_btn1{
  color: black;
  background-color: #FFC312;
  width: 50%;
}
.login_btn2{
  color: black;
  background-color: #666699;
  width: 50%;
}

</style>

<script>
function openWinLogin() {
    window.open("login.php", "_self");
}

var disableResetBtn = function(){
  if (document.getElementById('email').value == document.getElementById('RepeatEmail').value) {
    // document.getElementById("resetPwBtn").disabled = false;
    document.getElementById('emailCheckMessage').innerHTML = 'Matching';
    document.getElementById('emailCheckMessage').style.color = 'white';
    document.getElementById('emailCheckMessage').style.margin = '10px';
  } else {
    // document.getElementById("resetPwBtn").disabled = true;
    document.getElementById('emailCheckMessage').innerHTML = 'Not Matching';
    document.getElementById('emailCheckMessage').style.color = 'goldenrod';
    document.getElementById('emailCheckMessage').style.margin = '10px';
  }
}

var check = function() {
  if (document.getElementById('password').value ==
    document.getElementById('Repeatpassword').value) {
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
  if (document.getElementById('password').value.length < 8){
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
  if (document.getElementById('password').value == 
    document.getElementById('Repeatpassword').value && document.getElementById('password').value.length >= 8 && document.getElementById('email').value == document.getElementById('RepeatEmail').value) {
    document.getElementById("resetPwBtn").disabled = false;
  } else {
    document.getElementById("resetPwBtn").disabled = true;
  }
}
// && document.getElementById('username').value != NULL

</script>

<head>

  <meta charset="utf-8">
 
  <title>Reset Password</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
  <link href="./cssFiles/styleSheet.css" rel="stylesheet">
  <link rel="script" href="../JS/script.js">

</head>

    
<body>
  <?php
    include 'logfunctions.php';
    dbConnect();    
    $username = $email = $RepeatEmail = $password = $Repeatpassword = "";
  ?>
<div class="regStyle">
  <div class="container">
    <div class="d-flex justify-content-center h-100">
      <div class="card1">
        <div class="card-header">
          <h3>Forget your Password?</h3>
          <!-- <div class="d-flex justify-content-end LoginType">
            <button type="button" class="btn btn-warning btn-sm" onclick="openWinAccount()">Already Have an Account?</button>
          </div> -->
        </div>
        <div class="card-body">

          <form action="resetPassword.php" method="POST">
          <p class="d-flex justify-content-left links"><b>Please fill in this form to change your password.</b></p>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username" required="required" autofocus
              value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>">
            </div>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              </div>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required="required" onkeyup ='disableResetBtn(),disableRegBtn();'
              value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
              <!-- <span id='emailCheckMessage'> </span> -->
            </div>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
              </div>
              <input type="email" class="form-control" id="RepeatEmail" name="RepeatEmail" placeholder="Repeat Email" required="required" onkeyup ='disableResetBtn(),disableRegBtn();'
              value="<?php echo isset($_POST['RepeatEmail']) ? $_POST['RepeatEmail'] : '' ?>">
              <span id='emailCheckMessage'> </span>
            </div>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required="required" onkeyup ='checkLength(),check(), disableRegBtn();'   >
              <span id='pwLengthmessage'> </span>
            </div>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
              </div>
              <input type="password" class="form-control" id="Repeatpassword" name="Repeatpassword" placeholder="Repeat New password" required="required" onkeyup='checkLength(),check(),disableRegBtn();'>
              <span id='pwmessage'> </span>
            </div>

            <hr>

            <div class="form-group">
              <input type="submit" id="resetPwBtn" value="Reset Password" class="btn float-center login_btn1">
              <input type="button" onclick="openWinLogin();" value="Cancel" class="btn float-right login_btn2">

                <?php
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    restPw();
                    }
                ?> 

            </div>

          </form>


          
        </div>
      
      </div>
    </div>
  </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</html>