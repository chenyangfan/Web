<!-- CSCI2170 Author:YangfanChen Assignment2 Description: this is the entry point of the Picturgram page, will display all posts-->
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

  <title>Picturegram</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/clean-blog.min.css" rel="stylesheet">

</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <?php
      // this php code segements will handle file import, and return the user object
      include_once 'functions.php';
      $conn = connectToDB();
      $userId = $_SESSION['userId'];
      $result = getUserInfo($conn,$userId);
      $UserName = $result["Name"];
      $htmlSection = <<<HTML
    <a class="navbar-brand" href="about.php">$UserName</a>
    HTML;
      echo $htmlSection;
      ?>
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
            <span class="subheading">Your Life in Pictures</span>
          </div>
        </div>
      </div>
    </div>
  </header>

  <!-- Main Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-10 mx-auto">

        <!-- This part of the code is for loading the post info from files -->
        <?php
        // default time zone to current time zone
        date_default_timezone_set('America/Halifax');
        // query to select all the posts for userID = 1
        $my_query = "SELECT * FROM Posts ORDER BY Date DESC";
        $result = selectQuery($conn, $my_query,null);
        $posts = array();
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $post = array();
            $post["image"] = $row["PostImage"];
            $post["post"] = $row["Post"];
            $post["date"] = $row["Date"];
            $post["PostID"] = $row["PostID"];
            $post["UserID"] = $row["UserID"];
            $posts[] = $post;
          }
        }
        // load in the post and populate the index page.
        foreach ($posts as $post) {
          $postId = $post["PostID"];
          $date = $post["date"];
          $date = date_create($date);
          $date = date_format($date, "F jS, Y -g:ia");
          $image = $post["image"];
          $text  = $post["post"];
          $image = "img/" . $image;
          $post_user_id = $post["UserID"];
          $query_user = "SELECT * FROM Users where UserID = ?";
          $post_user_info = selectQuery($conn,$query_user,$post_user_id);
          $post_user = $post_user_info->fetch_assoc();
          $user = $post_user['Name'];
          /*
            * create the html template for each post and add querystring to pass
            * it into the post.php
            */
          $htmlSection = <<<HTML
              <div class="post-preview">
                <a href="post.php?postId=$postId&userId=$post_user_id">
                  <img src=$image style="width:720px;height: 380px;">
                  <h3 class="post-subtitle">
                    $text
                  </h3>
                </a>
                <p class="post-meta">Posted by
                  <a href="about.php?userId=$post_user_id">$user</a>
                  on $date</p>
              </div>
            HTML;
          echo $htmlSection;
          echo "<hr>";
        }
        closeConnection($conn);
        ?>
        <!-- Pager -->
        <div class="clearfix">
          <a class="btn btn-primary float-right" href="#">Older Posts &rarr;</a>
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