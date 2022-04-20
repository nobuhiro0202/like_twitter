<?php
  require('./db.php');
  session_start();
  $id = $_SESSION['id'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $birthday = $_POST['birthday'];
  $introduction = $_POST['introduction'];
  $update_sql = "update users set name = '{$username}', email = '{$email}', birthday = '{$birthday}', introduction = '{$introduction}' where id = {$id};";
  print $update_sql;
  $dbh->query($update_sql);
  header('Location: ./user_info.php');