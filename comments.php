<?php
  ini_set('display_errors',1);
  require('./db.php');
  $request = json_decode(file_get_contents("php://input"), true);
  $user_id = $request['user_id'];
  $comment = $request['comment'];
  $dbh->query("insert into comments (user_id, comment) values ({$user_id}, '{$comment}');");
  $sql = "select c.id, c.comment, c.user_id as cuid, c.created_at, u.name from comments c left join users u on c.user_id = u.id order by c.created_at desc limit 1;";
  $res = $dbh->query($sql);
  $results = $res->fetchAll();
  $json = json_encode($results, JSON_UNESCAPED_UNICODE);
  header("Content-Type: application/json; charset=UTF-8");
  echo $json;
  exit;