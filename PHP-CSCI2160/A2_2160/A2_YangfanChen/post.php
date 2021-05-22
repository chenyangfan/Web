<!-- CSCI2170 Author:YangfanChen Assignment2 Description: Will load the content of each post, and save comments to a file -->
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
  <!-- php code for write comments to a file based on the query string -->
  <?php
    // current location timezone
    date_default_timezone_set('America/Halifax');
    $request = $_SERVER['REQUEST_METHOD'];
    // Write comment only when the post request is in action.
    if(isset($_POST['comment'])){
      if(empty($_POST['comment']) == 'Submit'){ 
      }else{
        $currentDate = date_create();
        $currentDateTimeStamp = date_timestamp_get($currentDate);
        $fileName = $_POST['commentFileName'];
        $commentToWrite = $_POST['comment'];
        $fileToWrite = fopen("files/".$fileName,'a') or die('unable to open file');
        fwrite($fileToWrite,"\n\n");
        fwrite($fileToWrite,$currentDateTimeStamp."\n");
        fwrite($fileToWrite,$commentToWrite);
        fclose($fileToWrite);
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
    if($request == "GET"){
        $author = $_GET['author'];
        $timestamp = $_GET['date'];
        $postFileName = $_GET['postFileName'];
        $commentFileName = $_GET['commentFileName'];
        $imageName = $_GET['image'];
    }else{
        $author = $_POST['author'];
        $timestamp = $_POST['date'];
        $postFileName = $_POST['postFileName'];
        $commentFileName = $_POST['commentFileName'];
        $imageName = $_POST['imageName'];
        $addComment = $_POST['comment'];
    }


  ?>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand" href="about.php">Yangfan Chen</a>
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
  <?php
   // load the apprioate contents based on the query string from the index page.
   $formatDate =  date("F jS,Y - g:ia",$timestamp);
   $comments = file_get_contents("files/".$postFileName);
   $pageHeader = <<<HTML
  <header class="masthead" style="background-image: url($imageName)">
    <div class="overlay"></div>
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="post-heading">
            <h3 class="post-subtitle"> $comments </h3>
            <span class="meta">Posted by
              <a href="about.php">$author</a>
              on $formatDate</span>
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
                  <input type = "hidden" name="author" value="<?php echo $author?>">
                  <input type = "hidden" name="date" value="<?php echo $timestamp?>">
                  <input type = "hidden" name="postFileName" value="<?php echo $postFileName?>">
                  <input type = "hidden" name="commentFileName" value="<?php echo $commentFileName?>">
                  <input type = "hidden" name="imageName" value="<?php echo $imageName?>">
                  <textarea name="comment" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
        </div>

        <!-- Single Comment -->
        <?php
          $commentsForPost = array();
          $fr = fopen("files/".$commentFileName,'r') or die("Failed to open file");
          // load the comments from the corresponding file.
          while(!feof($fr)){
            $singleComment = array();
            $singleComment[0] = date("F jS,Y - g:ia",fgets($fr));
            $singleComment[1] = fgets($fr);
            fgets($fr);
            $commentsForPost[] = $singleComment;
          }
          fclose($fr);
          // sort the comments based on the timestamp.
          krsort($commentsForPost);
          // display the comment based on the timestamp.
          foreach($commentsForPost as $postComment){
            $commentHtml = <<<HTML
                <div class="media mb-4">
              <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
              <div class="media-body">
                <h5 class="mt-0">$postComment[0]</h5>
                $postComment[1]
              </div>
            </div>
            HTML;
            echo $commentHtml;
          }
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
