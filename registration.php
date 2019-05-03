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
  margin-left: 120px;
}

.emailCheck{
  color: 'goldenrod';
  margin: '10px';
}

</style>

<script>
function openWinLogin() {
    window.open("login.php", "_self");
}

function term_privacy_popup(){
  alert("Privacy Notice\nThis privacy notice discloses the privacy practices for Notebox website.\nWe only have access to/collect information that you voluntarily give us via email or other direct contact from you. \nWe take precautions to protect your information. Your information is protected both online and offline.\nIf you feel that we are not abiding by this privacy policy, you should contact us immediately.");
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
    document.getElementById('Repeatpassword').value && document.getElementById('password').value.length >= 8) {
    document.getElementById("regBtn").disabled = false;
  } else {
    document.getElementById("regBtn").disabled = true;
  }
}

</script>

<head>

  <meta charset="utf-8">
 
  <title>Notebox Register</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
  <link href="./cssFiles/styleSheet.css" rel="stylesheet">
  <link rel="script" href="../JS/script.js">

</head>

    
<body>
  <?php
    include 'functions.php';
    dbConnect();
    $username = $password =  $email = $Repeatpassword = $Fname = $Lname = "";
  ?>
<div class="regStyle">
  <div class="container">
    <div class="d-flex justify-content-center h-100">
      <div class="card1">
        <div class="card-header">
          <h3>Register</h3>
          <!-- <div class="d-flex justify-content-end LoginType">
            <button type="button" class="btn btn-warning btn-sm" onclick="openWinAccount()">Already Have an Account?</button>
          </div> -->
        </div>
        <div class="card-body">

          <form action="registration.php" method="POST">
          <p class="d-flex justify-content-left links"><b>Please fill in this form to create an account.</b></p>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="text" class="form-control" id="username" name="username" placeholder="Username" required="required" 
              value="<?php echo isset($_POST['username']) ? $_POST['username'] : '' ?>">
            </div>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
              </div>
              <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required="required" 
              value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">

            </div>


            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="required" onkeyup ='checkLength(),check(), disableRegBtn();'   
              >
              <span id='pwLengthmessage'> </span>
            </div>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-check-circle"></i></span>
              </div>
              <input type="password" class="form-control" id="Repeatpassword" name="Repeatpassword" placeholder="Repeat password" required="required" onkeyup='checkLength(),check(),disableRegBtn();'>
              <span id='pwmessage'> </span>
            </div>

            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
              </div>
              <input type="text" class="form-control" id="Fname" name="Fname" placeholder="(Optional) First name" 
              value="<?php echo isset($_POST['Fname']) ? $_POST['Fname'] : '' ?>">
            </div>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-address-card"></i></span>
              </div>
              <input type="text" class="form-control" id="Lname" name="Lname" placeholder="(Optional) Last name" 
              value="<?php echo isset($_POST['Lname']) ? $_POST['Lname'] : '' ?>">
            </div>

            <hr>

            <p class="d-flex justify-content-left links">By creating an account you agree to our <a href="#" onclick="term_privacy_popup()"><u><b>Terms & Privacy</b></u></a></p>
            <p class="d-flex justify-content-left links">Already have an account? <a href="#" onclick="openWinLogin()"><u><b>Sign in</b></u></a>.</p>
           
            <div class="form-group">
            <span style="color:goldenrod;"><b>
                <?php
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                      registration();
                    }
                ?> 
                </b>
              <br>
            </span>
            
              <input type="submit" id="regBtn" value="Register" class="btn  login_btn1">
           
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