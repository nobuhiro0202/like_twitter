<?php
  session_start();
  require('./db.php');
  $username = $_SESSION['name'];
  $email = $_SESSION['email'];
  $sql = "
    select c.id, c.comment, c.user_id as cuid, u.name, count(cl.id) as likes, c.created_at
    from comments c 
    left join users u on c.user_id = u.id
    left join (
      select * from comment_likes where l_deleted <> 1
    ) cl on c.id = cl.comment_id
    group by c.id
    order by c.created_at desc;
    ";
  $res = $dbh->query($sql);
  $comments = $res->fetchAll();
  if (isset($_SESSION['id'])) {
      $msg = htmlspecialchars($username, \ENT_QUOTES, 'UTF-8');
      $link = '<a href="./procs/logout.php">ログアウト</a>';
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
    <link rel="stylesheet" type="text/css" href="./style.css"></link>
    <script src="https://kit.fontawesome.com/3ddfae85ec.js" crossorigin="anonymous"></script>
    <script src="./index.js"></script>
    <title>like twitter</title>
  </head>
  <body>
    <input type="hidden" id="user_id" value=<?= $_SESSION['id'];?>>
    <h1><?= $msg; ?></h1>
    <div>
      <label>コメント<label>
        <input type="text" name="comment" id="comment" required>
      </div>
      <input type="submit" id="comment-submit" value="送信">
      <ul id='comment-list'>
    <?php foreach ($comments as $comment): ?> 
      <li id=<?= $comment['id']?>>
        <h2><?= $comment['comment'] ?></h2>
        <span>投稿日: <?= $comment['created_at'] ?></span>
        <span>投稿者: <?= $comment['name'] ?></span>
        <?php if ($_SESSION['id'] === $comment['cuid']): ?>
          <i class="fa-solid fa-trash-can trash"></i>
        <?php endif;?>
        <i class="fa-regular fa-heart heart"></i>
        <span id="count"><?= $comment['likes'] ?></span>
      </li>
    <?php endforeach; ?>
    </ul>
    <?= $link; ?>
  </body>
</html>