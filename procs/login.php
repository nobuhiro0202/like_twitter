<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログインフォーム</title>
</head>
<body>
  <h1>ログインページ</h1>
  <form action="../controllers/loginController.php" method="post">
    <div>
      <label>メールアドレス：<label>
      <input type="text" name="email" required>
    </div>
    <div>
      <label>パスワード：<label>
      <input type="password" name="password" required>
    </div>
    <input type="submit" value="ログイン">
  </form>
  <p>新規登録は<a href="./signup.php">こちら</a></p>
</body>
</html>