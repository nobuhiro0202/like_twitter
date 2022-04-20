<?php
  session_start();
  require('./db/db.php');
  $login_id = $_SESSION['id'];
  $sql = "select * from users where id = {$login_id};";
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
  <title>プロフィール</title>
</head>
<body>
  <h1>プロフィール</h1>
  <button onClick="history.back();">キャンセル</button>
  <form action="./controllers/userController.php" method='post'>
    <p>名前</p>
    <input type="text" name='username' value=<?= $username?> />
    <p>メールアドレス</p>
    <input type="email" name='email' value=<?= $email?> />
    <p>生年月日</p>
    <?php if ($birthday === null): ?>
      <input type="date" name='birthday' />
      <?php else: ?>
        <input type="date" value=<?= $birthday ?> name='birthday' />
    <?php endif; ?>
    <p>自己紹介</p>
    <textarea name="introduction" id="introduction" cols="30" rows="10"><?= $introduction ?></textarea>
    <input type="submit" value="保存する">
  </form>
</body>
</html>