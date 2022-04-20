<?php
  session_start();
  require('./db.php');
  $id = $_SESSION['id'];
  $sql = "select * from users where id = {$id};";
  $res = $dbh->query($sql);
  $user = $res->fetch();
  $username = $user['name'];
  $email = $user['email'];
  $birthday = $user['birthday'];
  $introduction = $user['introduction'];
?>
<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <title>プロフィール</title>
</head>
<body>
  <h1>プロフィール</h1>
  <div class="container">
    <a href="./user_update.php">編集する</a>
    <img src="./images/person-icon.png" class='user-icon'>
    <p>名前</p>
    <div><?= $username?></div>
    <p>メールアドレス</p>
    <div><?= $email?></div>
    <p>生年月日</p>
    <div>
    <?php 
      if ($birthday === null) {
        echo '未設定';
      } else {
        echo $birthday;
      }
    ?>
    </div>
    <p>自己紹介</p>
    <div><?= $introduction ?></div>
  </div>
  <a href="./index.php">ホームへ</a>
  <a href="./procs/logout.php">ログアウト</a>
</body>
</html>