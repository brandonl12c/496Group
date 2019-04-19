
<?php

    function dbConnect(){
                
        $hostname = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $db = "496db";

        $GLOBALS['connection'] = new mysqli($hostname, $dbUsername, $dbPassword, $db);

        if (!$GLOBALS['connection']){
            echo '<script>';
            echo 'alert("message unsuccessfully sent")';
            echo '</script>';
            die("Connection Failed: " . $GLOBALS['connection']->connect_error);
        }
    }
    
    function loginValidation(){
        $loginPage = "login.php";
        $homePage = "home.php";
        $email = $_POST['email'];
        $password = $_POST['password'];

        $adminLoginsql = "SELECT * FROM adminUser WHERE email='$email'";
        $adminLoginresult = mysqli_query($GLOBALS['connection'], $adminLoginsql);
        
        $loginsql = "SELECT * FROM accountUser WHERE email='$email'";
        $login_result = mysqli_query($GLOBALS['connection'], $loginsql);

        if(mysqli_num_rows($adminLoginresult) > 0){
            $row = mysqli_fetch_assoc($adminLoginresult);
            //verify argon2I hashed password 
            $verified = password_verify($password, $row['password']);
            //modify after hash hashed password
            if($verified){
                $_SESSION['userId'] = $row['userId'];
                echo "Admin <br>".$row['userName'].", You are Logged in.";
                //change to admin home page
                session_destroy();
                exit();
            } else{
                echo "Invalid Email or Password ";
            }
        } else if(mysqli_num_rows($login_result) > 0){
            $user_row = mysqli_fetch_assoc($login_result);
            //verify argon2I hashed password 
            $verified = password_verify($password, $user_row['password']);
            if($verified){
                $_SESSION['userId'] = $user_row['userId'];
                echo "Hi, ".$user_row['userName'].",<br> You are Logged in.";
                //echo $user_row['userId'];
                echo "<meta http-equiv='refresh' content='1; url=$homePage'>";
                exit();
            }else {
                echo "Invalid Email or Password ";
            }
        } else{
            echo "Invalid Email or Password ";
        }
    }
	
    function registration(){
        $mynotesPage = "myNotes.php";
        $regPage = "registration.php";
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_ARGON2I);
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
            echo "Registration Complete!<br>";
            //echo "$hashed_password";
            echo "<meta http-equiv='refresh' content='2; url=$loginPage'>";
            $reg_sql = "INSERT INTO accountUser(userName, `password`, `email`,`Fname`, `Lname`) Values ('$username','$hashed_password','$email','$Fname','$Lname')";
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
        $hashed_password = password_hash($password, PASSWORD_ARGON2I);
        $Repeatpassword = $_POST['Repeatpassword'];
        $sqli1 = "SELECT * FROM accountUser WHERE email='$email' AND userName ='$username' ";
        $user_result = mysqli_query($GLOBALS['connection'], $sqli1);
            if(mysqli_num_rows($user_result) > 0){
                echo "<br><br> Successfully Reset Your Password";
                echo "<meta http-equiv='refresh' content='3; url=$loginPage'>";
                $resetPw_sql = "UPDATE accountUser SET password = '$hashed_password' WHERE email='$email' AND userName ='$username' ";
                $resetResult = mysqli_query($GLOBALS['connection'], $resetPw_sql);
            }else{
                echo "<br><br> Username and Email Address does not match";
            }         
    }


    function get_userName(){
        $loginPage = "login.php";
        if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $getUsername_sql = "SELECT userName FROM accountUser WHERE userId='$userId'";
        $userName_sql_result = mysqli_query($GLOBALS['connection'], $getUsername_sql);
        $username_row = mysqli_fetch_assoc($userName_sql_result);
        echo $username_row['userName'];
        }else {
        echo "Please Sign in!";
        //********** remove // after **************
        //echo "<meta http-equiv='refresh' content='2; url=$loginPage'>";
        }
    }

    function get_userName_loginPage(){
        $homePage = "home.php";
        if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $getUsername_sql = "SELECT userName FROM accountUser WHERE userId='$userId'";
        $userName_sql_result = mysqli_query($GLOBALS['connection'], $getUsername_sql);
        $username_row = mysqli_fetch_assoc($userName_sql_result);
        echo "Hi, ".$username_row['userName']. ",<br> You are Logged in. Directing to Home page.";
        echo "<meta http-equiv='refresh' content='2; url=$homePage'>";
        exit();
        }
    }
    

    function get_email(){
        if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $get_email_sql = "SELECT email FROM accountUser WHERE userId='$userId'";
        $email_sql_result = mysqli_query($GLOBALS['connection'], $get_email_sql);
        $email_row = mysqli_fetch_assoc($email_sql_result);
        echo $email_row['email'];
        }else {
        echo "Email Session Error!";
        }
    }

    function get_Fname(){
        if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $get_Fname_sql = "SELECT Fname FROM accountUser WHERE userId='$userId'";
        $Fname_sql_result = mysqli_query($GLOBALS['connection'], $get_Fname_sql);
        $Fname_row = mysqli_fetch_assoc($Fname_sql_result);
            if($Fname_row['Fname'] != ""){
                echo $Fname_row['Fname'];
            } else{
                echo "N/A";
            }
        }else {
        echo "Fname Session Error!";
        }
    }

    function get_Lname(){
        if(isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $get_Lname_sql = "SELECT Lname FROM accountUser WHERE userId='$userId'";
        $Lname_sql_result = mysqli_query($GLOBALS['connection'], $get_Lname_sql);
        $Lname_row = mysqli_fetch_assoc($Lname_sql_result);
            if($Lname_row['Lname'] != ""){
                echo $Lname_row['Lname'];
            } else{
                echo "N/A";
            }
        }else {
        echo "Lname Session Error!";
        }
    }

    function update_Fname(){
        if(isset($_POST['updateFname']) && isset($_SESSION['userId'])){
			$profilePage = "profile.php";
			$newFname = $_POST['newFname'];
			$userId = $_SESSION['userId'];
			$update_Fname_sql = "UPDATE accountUser SET Fname = '$newFname' WHERE userId ='$userId' ";
			$update_Fname_sql_result = mysqli_query($GLOBALS['connection'], $update_Fname_sql); 
			echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
        }
    }

    function update_Lname(){
        if(isset($_POST['updateLname']) && isset($_SESSION['userId'])){
			$newLname = $_POST['newLname'];
			$profilePage = "profile.php";
			$userId = $_SESSION['userId'];
			$update_Lname_sql = "UPDATE accountUser SET Lname = '$newLname' WHERE userId ='$userId' ";
			$update_Lname_sql_result = mysqli_query($GLOBALS['connection'], $update_Lname_sql); 
			echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
        }
    }

    function update_Username(){
        if(isset($_POST['newUsername']) && isset($_SESSION['userId'])){
			$newUname = $_POST['newUsername'];
			$profilePage = "profile.php";
			$userId = $_SESSION['userId'];
			$update_Uname_sql = "UPDATE accountUser SET userName = '$newUname' WHERE userId ='$userId' ";
			$update_Uname_sql_result = mysqli_query($GLOBALS['connection'], $update_Uname_sql); 
			echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
        }
    }

    function update_email(){
        if(isset($_POST['newEmail']) && isset($_SESSION['userId'])){
			$newEmail = $_POST['newEmail'];
			$profilePage = "profile.php";
			$emailsqli = "SELECT * FROM accountUser WHERE email='$newEmail'";
			$email_result = mysqli_query($GLOBALS['connection'], $emailsqli);
			if(mysqli_num_rows($email_result) == 0){
				$userId = $_SESSION['userId'];
				$update_email_sql = "UPDATE accountUser SET email = '$newEmail' WHERE userId ='$userId' ";
				$update_email_sql_result = mysqli_query($GLOBALS['connection'], $update_email_sql); 
				echo "<meta http-equiv='refresh' content='0; url=$profilePage'>";
			}else{
				echo "<script>alert('Email Already Exist! Use a Different Email!')</script>";
			}
        }
    }

    function resetPwProfilePage(){
  
        if(isset($_SESSION['userId'])){
			$Currentpassword = $_POST['Currentpassword'];
			$Newpassword = $_POST['Newpassword'];
			$RepeatNewpassword = $_POST['RepeatNewpassword'];
			$hashed_password = password_hash($Newpassword, PASSWORD_ARGON2I);
			$userId = $_SESSION['userId'];
			$getPWsql = "SELECT password FROM accountUser WHERE userId='$userId'";
			$getPWsql_result = mysqli_query($GLOBALS['connection'], $getPWsql);
			$oldPW_row = mysqli_fetch_assoc($getPWsql_result);
			$verified = password_verify($Currentpassword, $oldPW_row['password']);
			if($verified){
				$resetPw_sql = "UPDATE accountUser SET password = '$hashed_password' WHERE userId='$userId' ";
				$resetResult = mysqli_query($GLOBALS['connection'], $resetPw_sql);
				//echo "Successfully Reset Your Password!<br>";
				echo "<script>alert('Successfully Reset Your Password!')</script>";
			}else{
				//echo "Invalid Current Password!<br>";
				echo "<script>alert('Invalid Current Password! Try Again!')</script>";
			}
        }else{
            //echo "Reset Password Session Error!<br>";
            echo "<script>alert('Reset Password Session Error!')</script>";
        }
    }



?>