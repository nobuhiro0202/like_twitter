<?php
  ini_set('display_errors', 1);
  require('./db.php');
  $request = json_decode(file_get_contents("php://input"), true);
  $comment_id = $request['comment_id'];
  $update_sql = "update comments set l_deleted = 1 where id = {$comment_id};";
  $dbh->query($update_sql);
  $update2_sql = "update comment_likes set l_deleted = 1 where comment_id = {$comment_id};";
  $dbh->query($update2_sql);
  $sql = "
    select * from (
      select c.id, c.comment, c.user_id as cuid, u.name, count(cl.id) as likes, c.created_at
      from comments c 
      left join users u on c.user_id = u.id
      left join (
        select * from comment_likes where l_deleted <> 1
        ) cl on c.id = cl.comment_id
      where c.l_deleted <> 1
      group by c.id
      order by c.created_at desc
      ) a 
    where a.cuid = {$id}
    order by a.created_at desc;
    ";
  $res = $dbh->query($sql);
  $results = $res->fetchAll();
  $json = json_encode($results, JSON_UNESCAPED_UNICODE);
  header("Content-Type: application/json; charset=UTF-8");
  echo $json;
  exit;
