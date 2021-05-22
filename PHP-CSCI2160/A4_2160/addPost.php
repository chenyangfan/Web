<!-- CSCI2170 Author:YangfanChen Assignment2 Description: This page will add new posts for the picturgram site, full functions are not implemented yet -->
<?php
  session_start();
  if(isset($_SESSION["loggedin"])&&$_SESSION["loggedin"]=== true){
  }else{
    header("location:login.php");
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>addPost</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/clean-blog.min.css" rel="stylesheet">
  <?php
  // file import and db connection setup.
  include_once 'functions.php';
  $conn = connectToDB();
  $userId = $_SESSION['userId'];
  $result = getUserInfo($conn,$userId);
  $UserName = $result["Name"];
  date_default_timezone_set('America/Halifax');
  $request = $_SERVER['REQUEST_METHOD'];
  // Write a post only when the user click to submit the request.
  if ((isset($_POST['comment'])) && (isset($_POST['filename']))) {
    if ((empty($_POST['comment']) == 'Submit') || (empty($_POST['filename']) == 'Submit')) {
    } else {
      $currentDate = date_create();
      $currentDate = date_format($currentDate, "Y-m-d H:i:s");
      $commentToWrite = $_POST['comment'];
      $filename = $_POST['filename'];
      $my_query = "INSERT INTO Posts(UserID,PostImage,Post,Date) VALUES('$userId','$filename','$commentToWrite','$currentDate')";
      insertQuery($conn, $my_query);
    }
  }
  // close the connection
  closeConnection($conn);
  ?>
</head>

<body>
  <?php
  if ($request == "POST") {
    $comment = $_POST["comment"];
    $filename = $_POST["filename"];
  }
  ?>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="about.php"><?php echo $UserName?></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="addPost.php">Add Post</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Header -->
  <header class="masthead" style="background-image: url('img/logo.jpg')">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="site-heading">
            <h1>Picturegram</h1>
            <h2>Add NEW POST</h2>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <div class="card my-4">
          <h5 class="card-header">Add a Post:</h5>
          <div class="card-body">
            <form method="post" action="addPost.php">
              <div class="form-group">
                <label for="comment">Post:</label>
                <textarea name="comment" id="comment" class="form-control" rows="3"></textarea>
                <label for="filename">Image Filename:</label>
                <textarea name="filename" id="filename" class="form-control" rows="1"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <hr>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <p class="copyright text-muted">Copyright &copy; Your Website 2020</p>
        </div>
      </div>
    </div>
  </footer>

  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/clean-blog.min.js"></script>

</body>

</html>