<?php
  $dsn = 'mysql:dbname=xrecruit5107_recruit;host=mysql5011.xserver.jp';
  $db_user = 'xrecruit5107_31u';
  $db_password = 'dt9lletfe5';
//   $dsn = 'mysql:dbname=twitter;host=localhost';
//   $db_user = 'root';
//   $db_password = 'root';
  try{
      $dbh = new PDO($dsn, $db_user, $db_password);
  } catch (PDOException $e){
      print('Error:'.$e->getMessage());
      die();
  }