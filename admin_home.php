<!DOCTYPE html>

<?php 
	include 'functions.php';

	if(isset($_SESSION['adminId'])) {
    $userId = $_SESSION['adminId'];
    }else {
	  header('Location: ' . "./");
  }
	?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<title>NoteBox Admin</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
<link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
<link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
<link href="./cssFiles/styleSheet.css" rel="stylesheet">
</head>
<style>
  th{
    color: gold;
  }
</style>
<body>
    <nav class="navbar navbar-expand navbar-dark bg-secondary fixed-top">

        <a class="navbar-brand mr-2"  id="title">My Notes</a>
        <form class="form-inline">
                <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                          <a class="nav-link" href="#" style="background-color:goldenrod;">Admin - Home <span class="sr-only">(current)</span></a>
                        </li>

                        <!-- <li class="nav-item active">
                                <a class="nav-link" href="#">Search<span class="sr-only">(current)</span></a>
                              </li> -->
                              
                        </ul>
        </form>

        <!-- search form -->
        <script>
          function search_validate(){
            var search_input = document.forms["search_form"]["search_keyword"].value;
              if(search_input == ""){
                alert("Please Enter a Keyword for search");
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
        <div class="head">
              <h1>
                <?php
                  get_Admin_userName();
                ?>
              </h1>
            </div>
      </header>

      <div class="row">
      <div class="col-6" style="height:280px; overflow: scroll; background-color:grey;margin-bottom:20px;">
      
      <table  id ="schoolTable" class="table table-hover table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Schools
            <button id="add_school_btn" style="padding:8px;border-radius:12px;background-color:goldenrod;margin-left:30px;">Add New School</button>
            <button id="delete_school_btn" style="padding:8px;border-radius:12px;background-color:goldenrod;margin-left:30px;">Delete School</button>
              <input id="adminInputS"  placeholder="Search School..." style="margin-left:160px"></a></th>
           
          </tr>
        </thead>
        
        <tbody id="myTableS">

          <?php
            listSch_admin();
          ?>

        </tbody>
      </table>
      </div>

      <div class="col-6" style="height:280px; overflow: scroll; background-color:grey;margin-bottom:20px;">
      <table id ="ticketTable" class="table table-hover table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Tickets<input id="adminInputT"  placeholder="Search Tickets..." style="margin-left:508px"></a></th>
           
          </tr>
        </thead>
        <tbody id="myTableT">
          <?php
            listT_admin();
          ?>  

        </tbody>
      </table>
      </div>
    </div>
</div>

<div class="row">
  <div class="col-6" style="height:280px; overflow: scroll; background-color:grey">
  <table  id ="courseTable" class="table table-hover table-striped table-dark">
    <thead>
      <tr>
        <th scope="col">Course
            <button id="add_c_btn" style="padding:8px;border-radius:12px;background-color:goldenrod;margin-left:32px;">Add New Course</button>
            <button id="delete_c_btn" style="padding:8px;border-radius:12px;background-color:goldenrod;margin-left:30px;">Delete Course</button>
          <input id="adminInputR"  placeholder="Filter Courses..." style="margin-left:160px"></a></th>
      </tr>
    </thead>
    <tbody id="myTableR">
      <?php
        listCrs_admin();
      ?>
    </tbody>
  </table>
  </div>

  <div class="col-6" style="height:280px; overflow: scroll; background-color:grey">
  <table  id ="RequestTable" class="table table-hover table-striped table-dark">
    <thead>
      <tr>
        <th scope="col">School/Course Request<input id="adminInputC"  placeholder="Filter Request..." style="margin-left:380px"></a></th>
       
      </tr> 
    </thead>

    <tbody id="myTableC" >

      <?php
        ListSCR_admin();
      ?>

    </tbody>
  </table>
  </div>

</div>
</div>


<!--add school pop-up -->
<div id="AddSchoolModal" class="reqmodal" >
    <!-- reqModal content -->
    <div  class="reqmodal-content">
      <span class="close close1">&times;</span>

      <a style="font-size:28px;">Add a School</a><br><br>
      <form action="admin_home.php" method="POST">
            <div class="reqrow">
              <div class="req-col-25">
                <label for="add_school">School Name*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="sName" name="sName" placeholder="Enter School Name" required="required">
              </div>
            </div>

            <div class="reqrow" id="reqAcro_hidden_section">
              <div class="req-col-25">
                <label for="req_acronym">Acronym*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="acronym" name="acronym" placeholder="Enter School Acronym" required="required">
            </div>
            </div>

            <div class="reqrow">
              <input type="submit" name="submitAddS" value="Add School" id= "submitAddS" style="background-color:goldenrod; margin-top:10px;">
            </div>
        </form>
            <?php
              if(isset($_POST['submitAddS'])){
                echo '<script>
                  var modal = document.getElementById("AddSchoolModal");
                  modal.style.display = "none";
                </script>';
                  createSchool();
                echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
              }
            ?>
      </div>
    </div>

    <!--delete school pop-up -->
  <div id="DeleteSchoolModal" class="reqmodal" >
    <!-- reqModal content -->
    <div  class="reqmodal-content">
      <span class="close close2">&times;</span>

      <a style="font-size:28px;">Delete a School</a><br><br>
      <form action="admin_home.php" method="POST">
            <div class="reqrow">
              <div class="req-col-25">
                <label for="add_school">School Name*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="sName1" name="sName1" placeholder="Enter School Name" required="required">
              </div>
            </div>
 

            <div class="reqrow">
              <input type="submit" name="submitDeleteS" value="Delete School" id= "submitDeleteS" style="background-color:goldenrod; margin-top:10px;">
            </div>
        </form>
            <?php
              if(isset($_POST['submitDeleteS'])){
                echo '<script>
                  var modal = document.getElementById("DeleteSchoolModal");
                  modal.style.display = "none";
                </script>';
                deleteSchool();
                echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
              }
            ?>
      </div>
    </div>

<!--add course pop-up -->
<div id="AddCModal" class="reqmodal" >
    <!-- reqModal content -->
    <div  class="reqmodal-content">
      <span class="close close3">&times;</span>

      <a style="font-size:28px;">Add a Course</a><br><br>
      <form action="admin_home.php" method="POST">
            <div class="reqrow">
              <div class="req-col-25">
                <label for="add_school">School Name*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="sName" name="sName" placeholder="Enter School Name" required="required">
              </div>
            </div>

            <div class="reqrow">
              <div class="req-col-25">
                <label for="add_school">Course Name*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="cName" name="cName" placeholder="Enter Course Name" required="required">
              </div>
            </div>

            <div class="reqrow" id="reqAcro_hidden_section">
              <div class="req-col-25">
                <label for="req_acronym">Section*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="section" name="section" placeholder="Enter Course Section" required="required">
            </div>
            </div>

            <div class="reqrow">
              <input type="submit" name="submitAddc" value="Add Course" id= "submitAddc" style="background-color:goldenrod; margin-top:10px;">
            </div>
        </form>
            <?php
              if(isset($_POST['submitAddc'])){
                echo '<script>
                  var c_modal = document.getElementById("AddCModal");
                  c_modal.style.display = "none";
                </script>';
                  createCourse();
                echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
              }
            ?>
      </div>
    </div>
    
    
    <!--delete course pop-up -->
  <div id="DeleteCModal" class="reqmodal" >
    <!-- reqModal content -->
    <div  class="reqmodal-content">
      <span class="close close4">&times;</span>

      <a style="font-size:28px;">Delete a Course</a><br><br>
      <form action="admin_home.php" method="POST">
            <div class="reqrow">
              <div class="req-col-25">
                <label for="add_school">School Acronym*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="sName1" name="sName1" placeholder="Enter School Acronym" required="required">
              </div>
            </div>
            <div class="reqrow">
              <div class="req-col-25">
                <label for="add_school">Course Section*</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="cName1" name="cName1" placeholder="Enter Course Section" required="required">
              </div>
            </div>
 

            <div class="reqrow">
              <input type="submit" name="submitDeleteC" value="Delete Course" id= "submitDeleteC" style="background-color:goldenrod; margin-top:10px;">
            </div>
        </form>
            <?php
              if(isset($_POST['submitDeleteC'])){
                echo '<script>
                  var modal = document.getElementById("DeleteCModal");
                  modal.style.display = "none";
                </script>';
                deleteCourse();
                echo "<meta http-equiv='refresh' content='0; url=admin_home.php'>";
              }
            ?>
      </div>
    </div>


</body>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.js"></script>

<script>
 // $("#myTable").hide();
    $(document).ready(function(){
      $("#adminInputS").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        if ((value.length)>1 || value.length==0){
        $("#myTableS tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
       });
        }
      });

      $("#adminInputT").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        if ((value.length)>1 || value.length==0){
        $("#myTableT tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
       });
        }
      });


      $("#adminInputR").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        if ((value.length)>1 ||value.length==0){
        $("#myTableR tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
       });
        }
      });



      $("#adminInputC").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        if ((value.length)>1 ||value.length==0) {
        $("#myTableC tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
       });
        }
      });
    });

    var AddSchoolModal = document.getElementById('AddSchoolModal');
    var add_school_btn = document.getElementById("add_school_btn");
    var span1 = document.getElementsByClassName("close1")[0];
    add_school_btn.onclick = function() {
      AddSchoolModal.style.display = "block";
    }
    span1.onclick = function() {
      AddSchoolModal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == AddSchoolModal) {
        AddSchoolModal.style.display = "none";
      }
    }

    var DeleteSchoolModal = document.getElementById('DeleteSchoolModal');
    var delete_school_btn = document.getElementById("delete_school_btn");
    var span2 = document.getElementsByClassName("close2")[0];
    delete_school_btn.onclick = function() {
      DeleteSchoolModal.style.display = "block";
    }
    span2.onclick = function() {
      DeleteSchoolModal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == DeleteSchoolModal) {
        DeleteSchoolModal.style.display = "none";
      }
    }

    var AddCModal = document.getElementById('AddCModal');
    var add_c_btn = document.getElementById("add_c_btn");
    var span3 = document.getElementsByClassName("close3")[0];
    add_c_btn.onclick = function() {
      AddCModal.style.display = "block";
    }
    span3.onclick = function() {
      AddCModal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == AddCModal) {
        AddCModal.style.display = "none";
      }
    }

    var DeleteCModal = document.getElementById('DeleteCModal');
    var delete_c_btn = document.getElementById("delete_c_btn");
    var span4 = document.getElementsByClassName("close4")[0];
    delete_c_btn.onclick = function() {
      DeleteCModal.style.display = "block";
    }
    span4.onclick = function() {
      DeleteCModal.style.display = "none";
    }
    window.onclick = function(event) {
      if (event.target == DeleteCModal) {
        DeleteCModal.style.display = "none";
      }
    }

    </script>




    <style>
        
        /* The Modal (background) */
            .reqmodal {
              display: none; /* Hidden by default */
              position: fixed; /* Stay in place */
              z-index: 1; /* Sit on top */
              padding-top: 100px; /* Location of the box */
              left: 0;
              top: 0;
              width: 100%; /* Full width */
              height: 100%; /* Full height */
              overflow: auto; /* Enable scroll if needed */
              background-color: rgb(0, 0, 0); /* Fallback color */
              background-color: rgba(0,0,0,0.6); /* Black w/ opacity */
            }
    
            /* Modal Content */
            .reqmodal-content {
              background-color:white;
              margin: auto;
              padding: 20px;
              border: 1px solid #888;
              width: 50%;
              height:fill;
            }
    
            /* The Close Button */
            .close {
              color:grey;
              float: right;
              font-size: 28px;
              font-weight: bold;
            }
    
            .close:hover,
            .close:focus {
              color: goldenrod;
              text-decoration: none;
              cursor: pointer;
            }
    
            /* req from */
            * {
              box-sizing: border-box;
            }
    
            input[type=text], select, textarea {
              width: 100%;
              padding: 12px;
              border: 1px solid #ccc;
              border-radius: 4px;
              resize: vertical;
            }
    
            label {
              padding: 12px 12px 12px 0;
              display: inline-block;
            }
    
            input[type=submit] {
              background-color: #4CAF50;
              color: white;
              padding: 12px 20px;
              border: none;
              border-radius: 4px;
              cursor: pointer;
              float: right;
            }
    
            input[type=submit]:hover {
              background-color: #45a049;
            }
    
            .container {
              border-radius: 5px;
              background-color: #f2f2f2;
              padding: 20px;
            }
    
            .req-col-25 {
              float: left;
              width: 25%;
              margin-top: 6px;
              padding-left:5px;
            }
    
            .req-col-75 {
              float: left;
              width: 75%;
              margin-top: 6px;
            }
    
            /* Clear floats after the columns */
            .reqrow:after {
              content: "";
              display: table;
              clear: both;
            }
    
            /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
            @media screen and (max-width: 600px) {
              .col-25, .col-75, input[type=submit] {
                width: 100%;
                margin-top: 0;
              }
            }
            </style>
</html>