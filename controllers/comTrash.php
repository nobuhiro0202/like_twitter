<?php
  ini_set('display_errors', 1);
  require('../db/db.php');
  $request = json_decode(file_get_contents("php://input"), true);
  $user_id = $request['user_id'];
  $comment_id = $request['comment_id'];
  $up_sql = "update comments set l_deleted = 1 where id = {$comment_id};";
  $dbh->query($up_sql);
  $up2_sql = "update comment_likes set l_deleted = 1 where comment_id = {$comment_id};";
  $dbh->query($up2_sql);
  exit;
