<?php
  session_start();
  require('./db.php');
  $id = $_SESSION['id'];
  $sql = "
  select c.id, c.comment, c.user_id as cuid, u.name, count(cl.id) as likes, c.created_at
  from comments c 
    left join users u on c.user_id = u.id
    left join (
      select * from comment_likes where l_deleted <> 1
      ) cl on c.id = cl.comment_id
    where c.l_deleted <> 1
    group by c.id
    order by c.created_at desc;
    ";
  $res = $dbh->query($sql);
  $comments = $res->fetchAll();
  $user_sql = "select * from users where id = {$id};";
  $userRes = $dbh-> query($user_sql);
  $user = $userRes-> fetch();
  $username = $user['name'];
  $email = $user['email'];

  if (isset($id)) {
      $msg = htmlspecialchars($username, \ENT_QUOTES, 'UTF-8');
      
  } else {
      header('Location: ./procs/login.php');
  }
?>
<!-- select *, EXISTS(SELECT * FROM comment_likes WHERE user_id = 2) liked from comment_likes where l_deleted <> 1; -->
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style.css">
    <script src="https://kit.fontawesome.com/3ddfae85ec.js" crossorigin="anonymous"></script>
    <script src="./js/index.js"></script>
    <title>like twitter</title>
  </head>
  <body>
    <input type="hidden" id="user_id" value=<?= $id?>>
    <div class="container">
    <div class="left-container">
      <h1><a href='./user_info.php'><?= $msg; ?></a></h1>
      <div>
        <label>コメント<label>
        <input type="text" name="comment" id="comment" required>
      </div>
      <input type="submit" id="comment-submit" value="送信">
    </div>
    <div class="main-container">
      <ul id='comment-list' class='comment-list'>
      <?php foreach ($comments as $comment): ?> 
        <li id=<?= $comment['id']?>>
          <div class="lihead">
            <div class="fana">
              <img src="./images/person-icon.png" class='user-icon'>
              <span class='person'><?= $comment['name'] ?></span>
            </div>
            <span><?= $comment['created_at'] ?></span>
          </div>
          <h5 class='statement'><?= $comment['comment'] ?></h5>
          <div class="lifoot">
          <?php if ($id === $comment['cuid']): ?>
            <i class="fa-solid fa-trash-can trash" style='color: red;'></i>
          <?php endif;?>
          <div class="like">
            <i class="fa-regular fa-heart heart"></i>
            <span id="count"><?= $comment['likes'] ?></span>
          </div>
          </div>
        </li>
      <?php endforeach; ?>
      </ul>
    </div>
    
    </div>
  </body>
</html>