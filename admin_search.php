<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<?php
include 'functions.php';
  dbConnect();
  $loginPage = "login.php";
if(isset($_SESSION['adminId'])) {
	$userId = $_SESSION['adminId'];
	}else {
    $user = null;
	header('Location: ' . "./");
    //direct back to login page if not logged in
    //echo "<meta http-equiv='refresh' content='1; url=$loginPage'>";
	}
?>
<title>Admin Search Result</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
<link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
<link href="./cssFiles/styleSheet.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand navbar-dark bg-secondary fixed-top">

        <a class="navbar-brand mr-2"  id="title">My Notes</a>
        <form class="form-inline">
                <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                          <a class="nav-link" href="admin_home.php">Admin - Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                                    <a class="nav-link" href="#" style="background-color:goldenrod;">Search<span class="sr-only">(current)</span></a>
                                  </li>
                        </ul>
        </form>

        <script>
          function search_validate(){
            var search_input = document.forms["search_form"]["search_keyword"].value;
              if(search_input == ""){
                alert("Please Enter a Keyword");
                return false;
                // window.location.replace("home.php");
              }
          }
          function search_validate2(){
            var search_input = document.forms["search_form2"]["searchPage_search_input"].value;
              if(search_input == ""){
                alert("Please Enter a Keyword");
                return false;
                // window.location.replace("home.php");
              }
          }
        </script>
        <form class="d-none d-md-inline-block  ml-auto" name = "search_form" onsubmit = "return search_validate()" action="admin_search.php" method="POST">
          <div class="input-group" >
            <input type="text" class="form-control" name="search_keyword" id="search_keyword" placeholder="Search for Notes">
            <div class="input-group-append" >
                <button type="submit" name="searchBtn" id="searchBtn" class="btn btn-primary" >
                  <i class="fa fa-search"></i>
                </button>
            </div>
          </div>
        </form>
    
        <ul class="navbar-nav ml-auto ml-md-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"  role="button" data-toggle="dropdown" >
             <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" >
              <a class="dropdown-item" href="admin_profile.php">Profile</a>
              <div class="dropdown-divider"></div>

              <a class="dropdown-item" href="logout.php" name="logoutBtn" id="logoutBtn">Logout</a>
            </div>
          </li>
        </ul>
    
      </nav>
      <header>
        <div class="head2">
              <h1></h1>
            </div>
          
      </header>
      
      <table  id ="searchTable" class="table table-hover table-striped table-dark">
      <form name = "search_form2" onsubmit = "return search_validate2()" action="admin_search.php" method="POST"> 
      <thead>
          <tr>
            <th scope="col" style="padding:20px;">
              <input id="searchPage_search_input" name="searchPage_search_input" type="text" placeholder="Search..." style="position: relative;left:-33%;width:30%;" 
              value="<?php 
              if (isset($_POST['searchPage_search_Btn']) || isset($_POST['display_notes_SR']) || isset($_POST['display_all_SR']) || isset($_POST['display_courses_SR'])) {
                echo isset($_POST['searchPage_search_input']) ? $_POST['searchPage_search_input'] : '' ;
              } else{
                echo isset($_POST['search_keyword']) ? $_POST['search_keyword'] : '';
              }
              ?>"></a>
                <span>
                <button id="searchPage_search_Btn" name="searchPage_search_Btn" type="submit" style="position: relative;left:-33%;width:5%;background: goldenrod; padding:10px;border-radius: 12px;"><i class="fa fa-search"></i></button>
                </span>
                </th>
          </tr>
        </thead>
        <tr></tr>
        <tr><td>
        <style>
        .search_nav_button {
          background-color: grey;
          border: none;
          color: goldenrod;
          padding-left: 20px;
          padding-right: 20px;
          padding-top: 8px;
          padding-bottom: 8px;
          text-align: center;
          text-decoration: none;
          display: inline-block;
          font-size: 16px;
          margin: 4px 2px;
          cursor: pointer;
          border-radius: 12px;
          margin-right:20px;
        }
        </style>

        <button type="submit" id="display_all_SR" name="display_all_SR" class="search_nav_button">ALL</button>
        <button type="submit" id="display_notes_SR" name="display_notes_SR" class="search_nav_button">Notes</button>
        <button type="submit" id="display_courses_SR" name="display_courses_SR" class="search_nav_button">Courses</button>
      </td></tr>
      </form>
        <tbody>
         
          <?php
            search();
          ?>

        </tbody>
      </table>
    </body>

<style>
table th {
   text-align: center; 
}

.table {
   margin: auto;
   min-height: 200px !important; 
   width: 80% !important; 
}</style>


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.js"></script>
<script>

    </script>
</html>