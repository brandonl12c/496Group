<!DOCTYPE html>

<head>

  <meta charset="utf-8">
 
  <title>My Notes - Home</title>
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
                <form class="d-none d-md-inline-block  ml-auto ">
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
        
                      <a class="dropdown-item" href="#" >Logout</a>
                    </div>
                  </li>
                </ul>
            
              </nav>
              
    <h2 id="msgHD">Messages</h2>
    <div class="d-flex flex-column h-100">
    <div class="card  w-75 bg-secondary text-center mx-auto">
            <div class="card-header">
              <ul class="nav nav-pills mb-3 " id="pills-tab" role="tablist">
                <li class="nav-item ">
                        <a class="nav-link active bg-warning" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">All Messages</a>
                    </li>
                <li class="nav-item">
                        <a class="nav-link active bg-light" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Unread Messages</a>
                    </li>
              </ul>
            </div>
            <div class="card-body">
              <p  id ="msgTxt" class="card-text" >Messages</p>
              <a id="msg" href="#" >Or echo messages here and make them clickable</a>
            </div>
          </div>
          </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.min.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.bundle.js.map"></script>
<script src="./jsFiles/bootstrap/bootstrap.js"></script>
<script src ="./jsFiles/script.js">


</script>
</html>