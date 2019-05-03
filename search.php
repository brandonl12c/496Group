<!DOCTYPE html>

<head>

    <meta charset="utf-8">
    <?php include "functions.php"; dbConnect();
    ?>
    <title>Search Result</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map">
    <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
    <link href="./cssFiles/styleSheet.css" rel="stylesheet">
	
	

</head>


<body>
    <!--Top navigation part-->
<nav class="navbar navbar-expand navbar-dark bg-secondary fixed-top">

        <a class="navbar-brand mr-2"  id="title">NoteBox</a>
        <form class="form-inline">
                <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                          <a class="nav-link" href="./home.php" >Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                                <a class="nav-link" href="myNotes.php">MyNotes <span class="sr-only">(current)</span></a>
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
        <form class="d-none d-md-inline-block  ml-auto" name = "search_form" onsubmit = "return search_validate()" action="search.php" method="POST">
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
          <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" >
                    <i class="fas fa-envelope-square"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="#">stuff</a>
              <a class="dropdown-item" href="#">more stuff</a>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"  role="button" data-toggle="dropdown" >
             <i class="far fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right" >
              <a class="dropdown-item" href="#" id="getReq">School/Course Requests</a>
              <a class="dropdown-item" href="profile.php" >Profile</a>
              <a class="dropdown-item" href="ticket.php">Feedback</a>
              <a class="dropdown-item" href="FAQ.php">FAQ</a>

              <div class="dropdown-divider"></div>

              <!-- <form method="POST" action="home.php"> -->
              <a class="dropdown-item" href="logout.php" name="logoutBtn" id="logoutBtn">Logout</a>
              <!-- </form> -->

            </div>
          </li>
        </ul>
    
      </nav>

 <!--request pop-up -->
 <div id="reqModal" class="reqmodal" >
    <!-- reqModal content -->
    <div  class="reqmodal-content">
      <span class="close">&times;</span>

      <a style="font-size:28px;">School/Course Request</a><br><br>

      <div class="req-form-group">

           <form action="home.php" method="POST">
             <div class="reqrow">
              <div class="req-col-25">
                <label for="requestType">Request Type*</label>
              </div>
              <div class="req-col-75">
                <select id="requestTypeSlection" name="requestTypeSlection" onchange="reqFormDisplay()">
                  <option value="SCHOOL" id="requestSchool" >New School Request</option>
                  <option value="COURSE" selected>New Course Request</option>
                </select>
              </div>
            </div>
            <div class="reqrow">
              <div class="req-col-25">
                <label for="req_school">School Name*</label>
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
            <div class="reqrow" id="reqC_hidden_section">
              <div class="req-col-25">
                <label for="req_course">Course Name</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="cName" name="cName" placeholder="Enter Course Name">
              </div>
            </div>
            <div class="reqrow" id="reqS_hidden_section">
              <div class="req-col-25">
                <label for="section">Section</label>
              </div>
              <div class="req-col-75">
                <input type="text" id="section" name="section" placeholder="Enter Course Section">
              </div>
            </div>
            <!-- <div class="reqrow">
              <div class="req-col-25">
                <label for="subject">Subject</label>
              </div>
              <div class="req-col-75">
                <textarea id="subject" name="subject" placeholder="Write something.." style="height:200px"></textarea>
              </div>
            </div> -->
            <br>
            <div class="reqrow">
              <input type="submit" name="submitReq" value="Submit Request" id= "reqSubmit" style="background-color:goldenrod">
            </div>
            </form> 

            <?php
              if(isset($_POST['submitReq'])){
                echo '<script>
                  var modal = document.getElementById("reqModal");
                  modal.style.display = "none";
                </script>';
                sch_crs_request_submit();
                $alertMessage = $_SESSION['alertMessage'];
                echo "<script>alert('$alertMessage')</script>";

              }
            ?>

      </div>
    </div>
    
</div>

<script>
    // Get the modal
    var modal = document.getElementById('reqModal');
    // Get the button that opens the modal
    var reqbtn = document.getElementById("getReq"); 
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    var reqSubmit = document.getElementById('reqSubmit');
    // When the user clicks the button, open the modal 
    reqbtn.onclick = function() {
      modal.style.display = "block";
    }
    //clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    // reqSubmit.onclick = function() {
    //   modal.style.display = "none";
    // }

    //clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }

    //display course name and section if it's course request
    var reqS_hidden_section = document.getElementById('reqS_hidden_section');
    var reqC_hidden_section = document.getElementById('reqC_hidden_section');

    function reqFormDisplay() {
      var requestTypeSlection = document.getElementById("requestTypeSlection").value;
        if (requestTypeSlection == "COURSE"){
          reqS_hidden_section.style.display = "block";
          reqC_hidden_section.style.display = "block";
        } else{
          reqS_hidden_section.style.display = "none";
          reqC_hidden_section.style.display = "none";
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

      <table  id ="searchTable" class="table table-hover table-striped table-dark">
        <form name = "search_form2" onsubmit = "return search_validate2()" action="search.php" method="POST">
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

      </form>
      <tbody>
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
   margin-top:4%;
   min-height: 200px !important; 
   width: 85% !important; 
}</style>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.js"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script>
    $(document).ready(function(){
      $("#adminInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        if ((value.length)>2){
        $("#search tr").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
       });
        }
      });
    });
    </script>
</html>