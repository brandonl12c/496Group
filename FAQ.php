<!DOCTYPE html>

<head>

    <meta charset="utf-8">

    <title>FAQ</title>
    <!-- <link href="cssFiles/bootstrap/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="jsFiles/bootstrap/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <link href="cssFiles/visual.css" rel="stylesheet"> -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
    <script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
    <script src="./jsFiles/bootstrap/bootstrap.js"></script>
    <script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>

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
                          <a class="nav-link" href="./home.php" style="background-color:goldenrod;">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                                <a class="nav-link" href="myNotes.php">MyNotes <span class="sr-only">(current)</span></a>
                              </li>
                              <li class="nav-item active">
                                    <a class="nav-link" href="#">Favorites<span class="sr-only">(current)</span></a>
                                  </li>
                        </ul>
        </form>

        <!--  -->
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

        <script>

        </script>

        <style>

        </style>

    
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
    <!--main view -->
    <div class="FAQmain">

        <div class="container">

            <h2>Welcome to NoteBox's FAQ's</h2>
            <br />
            <div id="FAQTable">
                <h2>Frequently Asked Questions: </h2>

                <div class="panel-group" id="accordion">
                    <div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Did you forget your password?</a>
                                </h4>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                                    Open Notbox.com/login, in this page you will find a forget password link to click on this lik will guide you to reset your password and have a new password.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTen">How to create a note?</a>
                                </h4>
                            </div>
                            <div id="collapseTen" class="panel-collapse collapse">
                                <div class="panel-body">
                                    After you successfully enter your username and password, you will be directed to the homepage, where you will have a link to upload note. Upload window will drop down.
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseEleven">Question 3?</a>
                                </h4>
                            </div>
                            <div id="collapseEleven" class="panel-collapse collapse">
                                <div class="panel-body">
                                    Answer 3
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>



</body>


</html>