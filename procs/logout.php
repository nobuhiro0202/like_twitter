<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>logout</title>
</head>
<body>
  <?php
    session_start();
    $_SESSION = array();//セッションの中身をすべて削除
    session_destroy();//セッションを破壊
    header('Location: ./login.php');
  ?>

  <p>ログアウトしました。</p>
  <a href="./login.php">ログインへ</a>
</body>
</html>