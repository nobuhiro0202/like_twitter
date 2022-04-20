<?php
  $dsn = 'mysql:dbname=twitter;host=localhost';
  $db_user = 'root';
  $db_password = 'root';
  try{
      $dbh = new PDO($dsn, $db_user, $db_password);
  } catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
  }