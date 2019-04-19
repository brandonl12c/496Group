<?php
include 'logfunctions.php';
dbConnect();
  session_start();
  //set user session with userId
if(isset($_SESSION['userId'])) {
	$userId = $_SESSION['userId'];
	}else {
		$user = null;

	}

?>
  
<!DOCTYPE html>

<style>
.loginStyle{
  margin-top: 8%;
}
</style>

<script>
function openWinRegistration() {
    window.open("registration.php", "_self");
}
function openWinAdmin() {
    window.open("adminLogin.php", "_self");
}
function openWinAccount() {
    window.open("login.php", "_self");
}
function openWinPasswordReset(){
  window.open("resetPassword.php", "_self");
}
</script>

<head>

  <meta charset="utf-8">
 
  <title>User Login</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
  <link href="./cssFiles/styleSheet.css" rel="stylesheet">
  <link rel="script" href="../JS/script.js">

</head>

    
<body>

<div class="loginStyle">
  <div class="container">
    <div class="d-flex justify-content-center h-100">
      <div class="card">
        <div class="card-header">
          <h3>Sign In</h3>
          <!-- user or admin -->
          
          <!-- <div class="d-flex justify-content-end LoginType">
            <button type="button" class="btn btn-warning btn-sm" onclick="openWinAdmin()">Admin</button>
            <button type="button" class="btn btn-primary btn-sm" disabled>User</button>
          </div> -->
        </div>
        <div class="card-body">
          <form action="login.php" method="POST">
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
              </div>
              <input type="email" class="form-control" name="email" placeholder="Email Address" required="required"
              value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>">
              
            </div>
            <div class="input-group form-group">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
              </div>
              <input type="password" class="form-control" name="password" placeholder="Password" required="required">
            </div>
            <div class="form-group">
              <input type="submit" value="Login" class="btn float-right login_btn">
            </div>
          </form>
          
          <p style="color:goldenrod; font-size:30px;">

            <?php
            get_userName_loginPage();
            ?>
          
            <?php  
              //login email and password check 
              $password =  $email = "";
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
              loginValidation();
              //check for admin user first then normal user
              }

            ?>
          </p>

        </div>
        
        <div class="card-footer">
          <div class="d-flex justify-content-center links" >
            Don't have an account?<a href="#" onclick="openWinRegistration()">Sign Up</a>
          </div>
          <div class="d-flex justify-content-center links">
            <a href="#" onclick="openWinPasswordReset()">Forgot your password?</a>
          </div>
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