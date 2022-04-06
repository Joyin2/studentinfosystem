<?php

session_start();

require 'connect.php';
require 'functions.php';


if (isset($_POST['register'])) {

  $uname = clean($_POST['email']);
  $pword = clean($_POST['password']);
  $studentno = clean($_POST['studentno']);
  $fname = clean($_POST['firstname']);
  $lname = clean($_POST['lastname']);
  // $lname = clean($_POST['email']); 
  $course = clean($_POST['course']);
  $yrlevel = clean($_POST['yrlevel']);

  $query = "SELECT email FROM students WHERE email = '$uname'";
  $result = mysqli_query($con, $query);
  // start


  // $query = mysqli_query($con,"SELECT * FROM `user` WHERE studentno = '$studentno'");
  // if(mysqli_num_rows($query)>0)
  // {
  //   echo "phone no already use";
  // }


  // end
  if (mysqli_num_rows($result) == 0) {

    $query = "SELECT studentno FROM students WHERE studentno = '$studentno'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 0) {

      $query = "INSERT INTO students (email, password, studentno, firstname, lastname, course, yrlevel, date_joined)
        VALUES ('$uname', '$pword', '$studentno', '$fname', '$lname', '$course', '$yrlevel', NOW())";

      if (mysqli_query($con, $query)) {

        $_SESSION['prompt'] = "Account registered. You can now log in.";
        header("location:index.php");
        exit;
      } else {

        // die("Error with the query");
        $_SESSION['errprompt'] = "That student number already exists.";
      }
    } else {

      $_SESSION['errprompt'] = "That student number already exists.";
    }
  } else {

    $_SESSION['errprompt'] = "email already exists.";
  }
}

?>

<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Register - Student Information System</title>

  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">



</head>

<body>

  <?php include 'header.php'; ?>

  <section class="center-text">

    <strong>Register</strong>

    <div class="registration-form box-center clearfix">

      <?php
      if (isset($_SESSION['errprompt'])) {
        showError();
      }
      ?>

      <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">

        <div class="row">
          <div class="account-info col-sm-6">

            <fieldset>
              <legend>Account Info</legend>

              <div class="form-group">
                <label for="email">email</label>
                <input type="text" class="form-control" name="email" placeholder="email (must be unique)" required>
              </div>

              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
              </div>
              <!-- pss -->
              <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" id="confirm_password" class="form-control" placeholder="Confirm Password" required>
              </div>



              <!-- new -->





              <!-- pss -->

            </fieldset>


          </div>

          <div class="personal-info col-sm-6">

            <fieldset>
              <legend>Personal Info</legend>

              <div class="form-group">
                <label for="studentno">Student Number</label>
                <input type="text" class="form-control" name="studentno" placeholder="Student Number (must be unique)" required>
              </div>

              <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" name="firstname" placeholder="First Name" required>
              </div>

              <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" name="lastname" placeholder="Last Name" required>
              </div>

              <!-- new -->
              <!-- <div class="form-group">
                <label for="lastname">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" required>
              </div> -->

              <div class="form-group">
                <label for="course">Course</label>

                <select class="form-control" name="course">
                  <option value="BSBA">BSBA</option>
                  <option value="BSOA">BSOA</option>
                  <option value="BSIT">BSIT</option>
                  <option value="BSCS">BSCS</option>
                  <option value="BSCE">BSCE</option>

                </select>

              </div>

              <div class="form-group">
                <label for="yrlevel">Year Level</label>

                <select class="form-control" name="yrlevel">
                  <option>1st year</option>
                  <option>2nd year</option>
                  <option>3rd year</option>
                  <option>4th year</option>
                </select>

              </div>

            </fieldset>


          </div>
        </div>



        <a href="index.php">Go back</a>
        <input class="btn btn-primary" type="submit" name="register" value="Register">



      </form>
    </div>

  </section>


  <script src="assets/js/jquery-3.1.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script type="text/javascript">
    var password = document.getElementById("password"),
      confirm_password = document.getElementById("confirm_password");

    function validatePassword() {
      if (password.value != confirm_password.value) {
        confirm_password.setCustomValidity("Passwords Don't Match");
      } else {
        confirm_password.setCustomValidity('');
      }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
  </script>
</body>

</html>

<?php

unset($_SESSION['errprompt']);
mysqli_close($con);

?>