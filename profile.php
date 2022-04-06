<?php 

  session_start();

  require 'connect.php';
  require 'functions.php';

  if(isset($_SESSION['email'], $_SESSION['password'])) {

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Profile - Student Information System</title>

  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="assets/css/main.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

	
    
</head>
<body>

  <?php include 'header.php'; ?>

  <section>

    <div class="container">
      <strong class="title">My Profile</strong>
    </div>
    <div class="w-50 p-3">
    <div class="alert alert-success alert-dismissible text-center ">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Success!</strong>  <?php echo "Welcome, <a href='profile.php'>".$_SESSION['email']."</a>!";?>
  </div>
  </div>
    <div class="profile-box box-left">

      <?php

        if(isset($_SESSION['prompt'])) {
          showPrompt();
        }


        $query = "SELECT * FROM students WHERE email = '".$_SESSION['email']."' AND password = '".$_SESSION['password']."'";

        ;

        if($result = mysqli_query($con, $query)) {

          $row = mysqli_fetch_assoc($result);

          echo "<div class='info'><strong>Student No:</strong> <span>".$row['studentno']."</span></div>";
          echo "<div class='info'><strong>Student Name:</strong> <span>".$row['firstname']." ".$row['lastname']."</span></div>";
          
          // echo "<div class='info'><strong>Email:</strong> <span>".$row['email']."</span></div>";
          echo "<div class='info'><strong>Course:</strong> <span>".$row['course']."</span></div>";
          echo "<div class='info'><strong>Year Level:</strong> <span>".$row['yrlevel']."</span></div>";

          $query_date = "SELECT DATE_FORMAT(date_joined, '%m/%d/%Y') FROM students WHERE id = '".$_SESSION['userid']."'";
          $result = mysqli_query($con, $query_date);

          $row = mysqli_fetch_row($result);

          echo "<div class='info'><strong>Date Joined:</strong> <span>".$row[0]."</span></div>";

        } else {

          die("Error with the query in the database");

        }

      ?>
      
      <div class="options">
        <a class="btn btn-primary" href="editprofile.php">Edit Profile</a>
        <a class="btn btn-success" href="changepassword.php">Change Password</a>
      </div>

      
    </div>

  </section>


	<script src="assets/js/jquery-3.1.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/main.js"></script>
</body>
</html>

<?php


  } else {
    header("location:index.php");
    exit;
  }

  unset($_SESSION['prompt']);
  mysqli_close($con);

?>