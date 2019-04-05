
<?php

//dbh.php
// $servername = "localhost";
// // MAMP password == "root", change to "" if using XAMPP
// $username = "root";
// $password = "root";
// $dbname = "496db"; //dbname

// // Create connection
// $conn = new mysqli($servername, $username, $password, $dbname);

// // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// } 
// // echo "//db connected test test test<br>";
    
    function dbConnect(){
                
        $hostname = "localhost";
        $dbUsername = "496Group";
        $dbPassword = "cs496Password";
        $db = "496DB";

        $GLOBALS['connection'] = new mysqli($hostname, $dbUsername, $dbPassword, $db);

        if (!$GLOBALS['connection']){
            echo '<script>';
            echo 'alert("message unsuccessfully sent")';
            echo '</script>';
            die("Connection Failed: " . $GLOBALS['connection']->connect_error);
        }
    }

    // function loginValidation(){
    //     $loginPage = "login.php";
    //     $mynotesPage = "myNotes.php";
    //     $email = $_POST['email'];
    //     $password = $_POST['password'];
    //     $loginsql = "SELECT * FROM accountUser WHERE email='$email' AND Password ='$password' ";
    //     $login_result = mysqli_query($GLOBALS['connection'], $loginsql);

    //     if(!$row = mysqli_fetch_assoc($login_result)) {
    //         echo "<br>Invalid Username or Password";
    //         // echo "<meta http-equiv='refresh' content='3; url=$loginPage'>";
    //         // exit();
    //     } else{
    //         $_SESSION['UserName'] = $row['userName'];
    //         echo "<br>Hi ".$row['userName'].", You are Logged in.";
    //         echo "<meta http-equiv='refresh' content='1; url=$mynotesPage'>";
    //         exit();
    //     }
    // }

    function loginValidation(){
        $loginPage = "login.php";
        $mynotesPage = "home.php";
        $email = $_POST['email'];
        $password = $_POST['password'];

        //admin login sql
        $adminLoginsql = "SELECT * FROM adminUser WHERE email='$email'  AND Password ='$password' ";
        $adminLoginresult = mysqli_query($GLOBALS['connection'], $adminLoginsql);
        //user login sql
        $loginsql = "SELECT * FROM accountUser WHERE email='$email' AND Password ='$password' ";
        $login_result = mysqli_query($GLOBALS['connection'], $loginsql);
        // if(!$row = mysqli_fetch_assoc($login_result) && !$row = mysqli_fetch_assoc($adminLoginresult)) {
        //     echo "<br>Invalid Username or Password";
        if(mysqli_num_rows($adminLoginresult) > 0){
            $row = mysqli_fetch_assoc($adminLoginresult);
            $_SESSION['UserName'] = $row['userName'];
            echo "<br>Admin <br>".$row['userName'].", You are Logged in.";
            //session_destroy();
            exit();
        } else if (mysqli_num_rows($login_result) > 0){
            $row = mysqli_fetch_assoc($login_result);
            $_SESSION['UserName'] = $row['userName'];
            echo "<br>Hi, ".$row['userName'].", You are Logged in.";
            echo "<meta http-equiv='refresh' content='1; url=$mynotesPage'>";
            //session_destroy();
            exit();
        } else{
            echo "<br>Invalid Username or Password ";
        }
    }

    // function adminLoginValidation(){ //need to be modified after adding the admin home page
    //     $adminloginPage = "adminlogin.php";
    //     $myAdminPage = "myAdmin.php";
    //     $email = $_POST['email'];
    //     $password = $_POST['password'];
    //     $adminLoginsql = "SELECT * FROM adminUser WHERE email='$email'  AND Password ='$password' ";
    //     $adminLoginresult = mysqli_query($GLOBALS['connection'], $adminLoginsql);
    //     if(!$row = mysqli_fetch_assoc($adminLoginresult)) {
    //       echo "<br>Invalid Username or Password";
    //       //echo "<meta http-equiv='refresh' content='3; url=$loginPage'>";
    //        // exit();
    //     } else{
    //         $_SESSION['AdminUserName'] = $row['userName'];
    //         echo "<br>".$row['userName'].", You are Logged in.";
    //         // echo "<meta http-equiv='refresh' content='2; url=$myAdminPage'>";
    //         //exit();
    //     }
    // }

    // function checkEmail(){
    //   $loginPage = "login.php";
    //   $mynotesPage = "myNotes.php";
    //   $regPage = "registration.php";
    //   $username = $_POST['username'];
    //   $password = $_POST['password'];
    //   $email = $_POST['email'];
    //   $Repeatpassword = $_POST['Repeatpassword'];
    //   $Fname = $_POST['Fname'];
    //   $Lname = $_POST['Lname'];
    //   //sql
    //   $emailsqli = "SELECT * FROM accountUser WHERE email='$email'";
    //   $email_result = mysqli_query($GLOBALS['connection'], $emailsqli);
    //   if(mysqli_num_rows($email_result) > 0){
    //     echo "Email already in use";
    //   }
    // }

    function registration(){
        $mynotesPage = "myNotes.php";
        $regPage = "registration.php";
        $username = $_POST['username'];
        $password = $_POST['password'];
        //$hashedPw = sha1($password);
        $email = $_POST['email'];
        $Repeatpassword = $_POST['Repeatpassword'];
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];
        $loginPage = "login.php";

        $emailsqli = "SELECT * FROM accountUser WHERE email='$email'";
        $email_result = mysqli_query($GLOBALS['connection'], $emailsqli);
        //admin email check
        $admin_emailsqli = "SELECT * FROM adminUser WHERE email='$email'";
        $admin_email_result = mysqli_query($GLOBALS['connection'], $admin_emailsqli);

        if(mysqli_num_rows($email_result) == 0 && mysqli_num_rows($admin_email_result) == 0){
            echo "<br>Registration Complete!";
            echo "<meta http-equiv='refresh' content='2; url=$loginPage'>";
            $reg_sql = "INSERT INTO accountUser(userName, `password`, `email`,`Fname`, `Lname`) Values ('$username','$password','$email','$Fname','$Lname')";
            $reg_result = mysqli_query($GLOBALS['connection'], $reg_sql);
        } else{
            echo "Email already in use<br><br>";
        }
    }

    function restPw(){
        $loginPage = "login.php";
        $username = $_POST['username'];
        $email = $_POST['email'];
        $RepeatEmail = $_POST['RepeatEmail'];
        $password = $_POST['password'];
        $Repeatpassword = $_POST['Repeatpassword'];
        $sqli1 = "SELECT * FROM accountUser WHERE email='$email' AND userName ='$username' ";
        $user_result = mysqli_query($GLOBALS['connection'], $sqli1);
            if(mysqli_num_rows($user_result) > 0){
                echo "<br><br> Successfully Reset Your Password";
                echo "<meta http-equiv='refresh' content='3; url=$loginPage'>";
                $resetPw_sql = "UPDATE accountUser SET password = '$password' WHERE email='$email' AND userName ='$username' ";
                $resetResult = mysqli_query($GLOBALS['connection'], $resetPw_sql);
            }else{
                echo "<br><br> Username and Email Address does not match";
            }         
    }

?>
