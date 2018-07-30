<?php
include 'header.php';
unset($_SESSION["user_name"]);
unset($_SESSION["user_id"]);
header('Location:index.php')
?>
