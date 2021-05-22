<!-- CSCI2170 Author:YangfanChen Assignment2 Description: this is the createAccount.php that will create an account-->

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/clean-blog.min.css" rel="stylesheet">

  <?php
  include_once 'functions.php';
  $conn = connectToDB();
  $result = getUserInfo($conn);
  $UserName = $result["Name"];
  ?>
  <?php
  // current location timezone
  date_default_timezone_set('America/Halifax');
  $request = $_SERVER['REQUEST_METHOD'];
  // Write comment only when the post request is in action.
  if (isset($_POST['name'])&&isset($_POST['selfIntro'])
      &&isset($_POST['imageName'])&&isset($_POST['username'])&&isset($_POST['password'])) {
    if (empty($_POST['name']) == 'Submit'||empty($_POST['selfIntro']) == 'Submit'||
        empty($_POST['imageName']) == 'Submit'||empty($_POST['username']) == 'Submit'||
        empty($_POST['password']) == 'Submit') {
    } else {
      $name = $_POST['name'];
      $selfIntro = $_POST['selfIntro'];
      $imageName = $_POST['imageName'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $query_username = "SELECT * FROM Login WHERE Username=?";
      $result = selectQuery($conn,$query_username,$username);
      if($result->num_rows > 0){
        $error_msg = "Error: Username already exists, select another username";
      }else{
        $my_query = "INSERT INTO Users(Name,About,AboutImage) VALUES('$name','$selfIntro','$imageName')";
        insertQuery($conn, $my_query);
        $id = $conn ->insert_id;
        $query2 = "INSERT INTO Login(UserID,Username,Password) VALUES('$id','$username','$password')";
        insertQuery($conn,$query2);
        header("location:login.php");
      }
    }
  }

  ?>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand">Picturegram</a>
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
          <div class="page-heading">
            <h1>Picturegram</h1>
            <span class="subheading">CREATE ACCOUNT</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">
        <form method="post" action="createAccount.php">
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Name</label>
              <input type="text" class="form-control" placeholder="name" id="name" name ="name" required data-validation-required-message="Please enter your name.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Tell us about you</label>
              <input type="text" class="form-control" placeholder="tell us about yourself" id="selfIntro" name="selfIntro" required data-validation-required-message="Please tell us about you.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Image</label>
              <input type="text" class="form-control" placeholder="Name of the Image" id="imageName" name="imageName" required data-validation-required-message="Please provide an image about you.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>UserName</label>
              <input type="text" class="form-control" placeholder="UserName" id="username" name="username" required data-validation-required-message="Please enter your user name.">
              <p class="help-block text-danger"></p>
            </div>
          </div>

          <div class="control-group">
            <div class="form-group floating-label-form-group controls">
              <label>Password</label>
              <input type="password" class="form-control" placeholder="password" id="password" name="password" required data-validation-required-message="Please enter your password.">
              <p class="help-block text-danger"></p>
            </div>
          </div>
          <br>
          <div id="success"></div>
          <button type="submit" class="btn btn-primary" id="submitFormButton">CREATE ACCOUNT</button>
          <p><?php echo $error_msg?></p>
        </form>
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

  <!-- Contact Form JavaScript -->
  <script src="js/jqBootstrapValidation.js"></script>
  <script src="js/contact_me.js"></script>

  <!-- Custom scripts for this template -->
  <script src="js/clean-blog.min.js"></script>

</body>

</html>
