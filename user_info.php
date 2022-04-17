<?php
  session_start();
  require('./db.php');
  $id = $_SESSION['id'];
  $username = $_SESSION['name'];
  $email = $_SESSION['email'];
?>
<!DOCTYPE html>
<html lang="">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>プロフィール</title>
</head>
<body>
  <h1>プロフィール</h1>
  <p>名前</p>
  <div><?= $username?></div>
  <p>メールアドレス</p>
  <div><?= $email?></div>
  <p>生年月日</p>
  <div><?= $email?></div>

</body>
</html>