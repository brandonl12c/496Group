<!DOCTYPE html>

<head>

  <meta charset="utf-8">
 
  <title>Registration Result</title>
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

                $loginPage = "login.php";
                $mynotesPage = "myNotes.php";
                $regPage = "registration.php";
                $username = $_POST['username'];
                $password = $_POST['password'];
                $email = $_POST['email'];
                $Repeatpassword = $_POST['Repeatpassword'];
                $Fname = $_POST['Fname'];
                $Lname = $_POST['Lname'];

                $sqli = "SELECT * FROM accountUser WHERE userName='$username' OR email='$email'";
                $resulti = mysqli_query($conn, $sqli);

                if(mysqli_num_rows($resulti)>0){
                    echo "Username or email already exist.";
                    echo "<meta http-equiv='refresh' content='3; url=$regPage'>";
                    exit;
                    }

                if ($password != $Repeatpassword) {
                    echo "<p>Password and Repeat Password are Different.</P>";
                    echo "<meta http-equiv='refresh' content='3; url=$regPage'>";
                    exit;
                    }
                    else {
                    echo "Registration Complete!<br>Please Login!";
                    echo "<meta http-equiv='refresh' content='3; url=$loginPage'>";
                    $sql = "INSERT INTO accountUser(userName, `password`, `email`,`Fname`, `Lname`) Values ('$username','$password','$email','$Fname','$Lname')";
                    $result = mysqli_query($conn, $sql);
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