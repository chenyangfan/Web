<!-- CSCI2170 Author:YangfanChen Assignment2 Description: Will load the content of each post, and save comments to a file -->
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

  <title>Post</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

  <!-- Custom styles for this template -->
  <link href="css/clean-blog.min.css" rel="stylesheet">
  <!-- php code for file import and db connection -->
  <?php
  include_once 'functions.php';
  $conn = connectToDB();
  $curr_user = $_SESSION['userId'];
  $result = getUserInfo($conn,$curr_user);
  $UserName = $result["Name"];
  ?>
  <?php
  // current location timezone
  date_default_timezone_set('America/Halifax');
  $request = $_SERVER['REQUEST_METHOD'];
  // Write comment only when the post request is in action.
  if (isset($_POST['comment'])) {
    if (empty($_POST['comment']) == 'Submit') {
    } else {
      $currentDate = date_create();
      $currentDate = date_format($currentDate, "Y-m-d H:i:s");
      $commentToWrite = $_POST['comment'];
      $userId = $_SESSION['userId'];
      $postId = $_POST['postId'];
      $my_query = "INSERT INTO Comments(UserID,PostID,Comment,Date) VALUES('$userId','$postId','$commentToWrite','$currentDate')";
      insertQuery($conn, $my_query);
    }
  }

  ?>

</head>

<body>
  <?php
  /**
   * The following code will store the important information of the post.
   * based on the request type from the php code above.
   */
  if ($request == "GET") {
    $postId = $_GET['postId'];
  } else {
    $postId = $_POST['postId'];
  }
  ?>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="about.php"><?php echo $UserName ?></a>
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
  <?php
  // load the apprioate contents based on the query string from the index page.
  $my_query = "SELECT * FROM Posts WHERE PostID =?";
  $result = selectQuery($conn, $my_query,$postId);
  $post = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $post["image"] = $row["PostImage"];
      $post["post"] = $row["Post"];
      $post["date"] = $row["Date"];
      $post["userId"] = $row["UserID"];
    }
  }
  $post_user = $post['userId'];
  $query_post_user = "SELECT * FROM Users WHERE UserID = ?";
  $result_user_info = selectQuery($conn,$query_post_user,$post_user);
  $user = $result_user_info->fetch_assoc();
  $name = $user['Name'];
  $postText = $post["post"];
  $imageName = "img/" . $post["image"];
  $date = $post["date"];
  $date = date_create($date);
  $date = date_format($date, "F jS, Y -g:ia");
  $pageHeader = <<<HTML
  <header class="masthead" style="background-image: url($imageName)">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-heading">
            <h3 class="post-subtitle"> $postText </h3>
            <span class="meta">Posted by
              <a href="about.php">$name</a>
              on $date</span>
          </div>
        </div>
      </div>
    </div>
  </header>
  HTML;
  echo $pageHeader;
  ?>
  <!-- Post Content -->
  <div class="container">
    <div class="row">
      <div class="col-lg-8 cold-md-10 mx-auto">
        <!-- Form for comment Section -->
        <div class="card my-4">
          <h5 class="card-header">Leave a Comment:</h5>
          <div class="card-body">
            <form method="post" action="post.php">
              <div class="form-group">
                <input type="hidden" name="postId" value="<?php echo $postId ?>">
                <textarea name="comment" class="form-control" rows="3"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Submit</button>
            </form>
          </div>
        </div>

        <!-- Select all the comments-->
        <?php

        $commentsForPost = array();
        $my_query = "SELECT * FROM Comments WHERE PostID = ? ORDER BY Date DESC";
        $result = selectQuery($conn, $my_query,$postId);
        if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
            $comment = array();
            $comment["comment"] = $row["Comment"];
            $comment["date"] = $row["Date"];
            $comment['userId'] = $row["UserID"];
            $commentsForPost[] = $comment;
          }
        }
        // display the comment based on the timestamp.
        foreach ($commentsForPost as $postComment) {
          $commentDate = date_create($postComment["date"]);
          $commentDate = date_format($commentDate, "F jS, Y -g:ia");
          $commentText = $postComment["comment"];
          $comment_user = $postComment["userId"];
          $query = "SELECT * FROM Users WHERE UserID = ?";
          $result = selectQuery($conn,$query,$comment_user);
          $user = $result->fetch_assoc();
          $comment_author = $user['Name'];
          $commentHtml = <<<HTML
                <div class="media mb-4">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">$commentDate Author: $comment_author</h5>
                $commentText
              </div>
            </div>
            HTML;
          echo $commentHtml;
        }
        closeConnection($conn);
        ?>


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