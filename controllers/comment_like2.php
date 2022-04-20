<?php
  ini_set('display_errors', 1);
  require('../db/db.php');
  $request = json_decode(file_get_contents("php://input"), true);
  $user_id = $request['user_id'];
  $comment_id = $request['comment_id'];
  $check_sql = "select * from comment_likes where user_id = {$user_id} and comment_id = {$comment_id};";
  $checked = $dbh->query($check_sql);
  $already_like = $checked->fetch();

  if ($already_like == null) {
    $insert_sql = "insert into comment_likes (user_id, comment_id) values ({$user_id}, {$comment_id});"; 
    $dbh->query($insert_sql);
  } else {
    $check2_sql = "select * from comment_likes where user_id = {$user_id} and comment_id = {$comment_id} and l_deleted = 1";
    $responce = $dbh->query($check2_sql);
    $didlike = $responce->fetch();
    if ($didlike == null) {
      $update_sql = "update comment_likes set l_deleted = 1 where user_id = {$user_id} and comment_id = {$comment_id}";
      $dbh->query($update_sql);
    } else {
      $update_sql = "update comment_likes set l_deleted = 0 where user_id = {$user_id} and comment_id = {$comment_id}";
      $dbh->query($update_sql);
    }
  }
  $res_sql = "select count(*) as likes from comment_likes where comment_id = {$comment_id} and l_deleted <> 1;";
  $res = $dbh->query($res_sql);
  $results = $res->fetchAll();
  $json = json_encode($results, JSON_UNESCAPED_UNICODE);
  header("Content-Type: application/json; charset=UTF-8");
  echo $json;
  exit;
