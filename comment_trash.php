<?php
  ini_set('display_errors', 1);
  require('./db.php');
  $request = json_decode(file_get_contents("php://input"), true);
  $comment_id = $request['comment_id'];
  var_dump($comment_id);
  $updated_sql = "update comments set l_deleted = 1 where id = {$comment_id};";
  $dbh->query($updated_sql);
  $sql = "select c.id, c.comment, c.user_id as cuid, u.name, c.created_at from comments c left join users u on c.user_id = u.id where c.l_deleted <> 1 order by c.created_at desc;";
  $res = $dbh->query($sql);
  $results = $res->fetchAll();
  $json = json_encode($results, JSON_UNESCAPED_UNICODE);
  header("Content-Type: application/json; charset=UTF-8");
  echo $json;
  exit;
