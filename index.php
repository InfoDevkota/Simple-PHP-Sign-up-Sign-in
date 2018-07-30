<?php
  include 'header.php';
  if(isset ($_SESSION["user_name"]))
  {
    echo 'Hello, ' . $_SESSION['user_name'] .'. Not you? <a href="signout.php">Sign out</a>';
  }
  else
  {
    echo '<a href="signin.php">Sign in</a> or <a href="signup.php">create an account</a>.';
  }
?>
