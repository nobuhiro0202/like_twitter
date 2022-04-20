<?php
  require('../db/db.php');
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'] ?? "", PASSWORD_DEFAULT);

  $res = $dbh->query("select email from users where email = '{$email}'");
  $member = $res->fetch();
  if ($member['email'] === $email) {
    header('Location: ../procs/signup.php');
  } else {
    $sql = "insert into users (name, email, password) values ('{$name}', '{$email}', '{$password}');";
    $res = $dbh->query($sql);
    header('Location: ../procs/login.php');
  }