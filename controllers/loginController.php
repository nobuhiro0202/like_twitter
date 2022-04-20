<?php
  require('../db/db.php');
  session_start();
  $email = $_POST['email'];
  $res = $dbh->query("select * from users where email = '{$email}';");
  $member = $res->fetch();
  if (password_verify($_POST['password'], $member['password'])) {
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['name'];
    $_SESSION['email'] = $member['email'];
    header('Location: ../index.php');
  } else {
    header('Location: ../procs/login.php');
  }