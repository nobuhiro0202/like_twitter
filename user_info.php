<?php
  session_start();
  require('./db/db.php');
  $login_id = $_SESSION['id'];
  $sql = "select * from users where id = {$login_id};";
  $res = $dbh->query($sql);
  $user = $res->fetch();
  $username = $user['name'];
  $birthday = $user['birthday'];
  $introduction = $user['introduction'];
  $us_com_sql = "
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
    where a.cuid = {$login_id}
    order by a.created_at desc;
    ";
  $resp = $dbh->query($us_com_sql);
  $comments = $resp->fetchAll();
?>
<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/3ddfae85ec.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="./styles/style.css">
  <script src="./js/user_info.js"></script>
  <title>プロフィール</title>
</head>
<body>
<input type="hidden" id="user_id" value=<?= $login_id?>>
  <div class="container">
    <div class="left-container">
      <div class='left-comment'>
        <label>コメント<label>
        <input type="text" name="comment" id="comment" required>
      </div>
      <input type="submit" id="comment-submit" value="送信">
    </div>
    <div class="main-container">
      <div class="profile">
        <div class="profile-header"></div>
        <div class="una">
          <div class="ifo">
            <img src="./images/person-icon.png" class='user-icon-pro'>
            <div class='unarea'><?= $username?></div>
          </div>
          <a href="./user_update.php" class='edit-profile-btn'>編集する</a>
        </div>
        <div class='intro-container'>
          <?= $introduction ?>
        </div>
        <div class='birthday'>
          <?php 
            if ($birthday !== null) {
              echo "誕生日: {$birthday}";
            }
          ?>
        </div>
      </div>
      <ul id='comment-list' class='comment-list user-info'>
        <?php if(!$comments): ?>
            <p>投稿がありません</p>
        <?php else: ?>
            <?php include('./views/commentsList.php'); ?>
        <?php endif; ?>
      </ul>
    </div>
    <div class="right-container">
      <div><a href="./index.php">ホームへ</a></div>
      <div><a href="./procs/logout.php">ログアウト</a></div>
    </div>
  </div>
</body>
</html>