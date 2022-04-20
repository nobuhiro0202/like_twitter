<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/style.css">
  <title>ログイン</title>
</head>
<body>
  <div class="login-container">
    <h2>ログイン</h2>
    <form action="../controllers/loginController.php" method="post" class="login-form">
      <div class="email">
        <label class="email-label">メールアドレス</label>
        <input type="text" name="email" required>
      </div>
      <div class="password">
        <label class="password-label">パスワード</label>
        <input type="password" name="password" required>
      </div>
      <div class="login-btn-container">
        <input type="submit" value="ログイン" class="login-btn">
      </div>
    </form>
    <p>新規登録は<a href="./signup.php">こちら</a></p>
  </div>
</body>
</html>