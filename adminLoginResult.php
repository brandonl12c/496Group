<!DOCTYPE html>

<head>

  <meta charset="utf-8">
 
  <title>loginResult</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
  <link href="./cssFiles/styleSheet.css" rel="stylesheet">
  <link rel="script" href="../JS/script.js">

</head>

    
<body>

  <div class="container">
    <div class="d-flex justify-content-center h-100">
        <div class="card-header">
          <h1>
  <?php 
  include 'dbh.php';
  session_start();
 
    $adminloginPage = "adminlogin.php";
    $myAdminPage = "myAdmin.php";
    $username = $_POST['username'];
    $password = $_POST['password'];
    //either user username or email address to login 
	$sql = "SELECT * FROM adminUser WHERE userName='$username' OR email='$username'  AND Password ='$password' ";
    $result = mysqli_query($conn, $sql);

    if(!$row = mysqli_fetch_assoc($result)) {
        echo "<br>Invalid Attempt";
        echo "<meta http-equiv='refresh' content='3; url=$loginPage'>";
        exit();
    } else{
        $_SESSION['AdminUserName'] = $row['userName'];
        echo "<br>Hi, Admin User<br>".$row['userName'].", You are Logged in.";
        echo "<meta http-equiv='refresh' content='2; url=$myAdminPage'>";
        exit();
    }

?>
</h1>
 
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

</html>