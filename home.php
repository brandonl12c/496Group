<!DOCTYPE html>

<head>
	<?php 
	include 'functions.php';
	dbConnect(); 
	session_start();
	//SESSION INFORMATION HERE
	/*Need
		userId
		userType
	*/
	$_SESSION['userId'] = 1000000000;
	
	?>
  <meta charset="utf-8">
 
  <title>My Notes - Home</title>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css.map" >
  <link rel="stylesheet" href="./cssFiles/bootstrap/bootstrap.min.css">
  <link href="./cssFiles/styleSheet.css" rel="stylesheet">

</head>

    
<body >
       <nav class="navbar navbar-expand navbar-dark bg-secondary fixed-top">

        <a class="navbar-brand mr-2"  id="title">My Notes</a>
        <form class="form-inline">
                <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                        </li>
                        <li class="nav-item active">
                                <a class="nav-link" href="#">School <span class="sr-only">(current)</span></a>
                              </li>
                              <li class="nav-item active">
                                    <a class="nav-link" href="#">Favorites<span class="sr-only">(current)</span></a>
                                  </li>
                        </ul>
        </form>
        <form class="d-none d-md-inline-block  ml-auto">
          <div class="input-group" >
            <input type="text" class="form-control" placeholder="Search for Notes" aria-label="Search" >
            <div class="input-group-append">
              <button class="btn btn-primary" type="button">
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
              <a class="dropdown-item" href="#">Settings</a>
              <a class="dropdown-item" href="#">Help</a>
              <a class="dropdown-item" href="#">Feedback</a>
              <a class="dropdown-item" href="#">FAQ</a>
              <div class="dropdown-divider"></div>

              <a class="dropdown-item" href="./logout.php" >Logout</a>
            </div>
          </li>
        </ul>
    
      </nav>
      
      <header>
            <div class="head">
                  <h1>Welcome Username</h1>
                </div>
              
          </header>
          
          <div class="row" >
            <div class="card w-50 bg-secondary mb-3 rounded-0" style="width: 18rem;" >
                 <div class="card-header" id="courseListTxt">
                   Schools
                 </div>
                 <ul class="list-group list-group-flush"  >
                   <?php showUserSchools(1000000000); ?>
                   <!--
				   <li class="list-group-item" role="button" href="#collapseONE" data-toggle="collapse" id="courseListTxt">CS 496</li>
                         <div class="collapse" id="collapseONE">
                                 <a class="dropdown-item" href="#" id="courseListTxt">Lecture 1</a>
                                 <a class="dropdown-item" href="#" id="courseListTxt">Lecture 2</a>
                         </div>
                   <li class="list-group-item" role="button" data-toggle="dropdown" id="courseListTxt">CS 101</li>
                   <li class="list-group-item" role="button" data-toggle="dropdown" id="courseListTxt">MKT 702</li>
				   -->
                   <li class="list-group-item" href="#" id="courseListTxt">Add a Course</li>
                 </ul>
               </div>
        
               <div class="card w-50 bg-secondary mb-3 rounded-0" style="width: 18rem;" >
                     <div  class="card-header" id="courseListTxt">
                       Favorite Notes
                     </div>
                     <ul class="list-group list-group-flush"  >
						<?php showUserNotes(1000000000); ?>
                       <!--
					   <li class="list-group-item" href="#"  id="courseListTxt"> Lecture 1</li>
                       <li class="list-group-item" href="#"  id="courseListTxt">Lecture 2</li>
                       <li class="list-group-item" href="#"  id="courseListTxt">Lecture 3</li>
					   -->
                     </ul>
                   </div>
       
         </div>
 
      
        </div>
        <div class="footerDiv">
          <ul id="footer">
            <li><a href="#">Send Feedback</a></li>
                <li><a href="#">Help</a></li>
                <li><a href="#">FAQ</a></li>
                </li>
         </ul>
        </div>
 
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.js"></script>

</html>
