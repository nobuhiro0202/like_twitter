<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/style.css">
  <title>signup</title>
</head>
<body>
  <div class="signup-container">
    <h2>新規会員登録</h2>
    <form action="../controllers/registerController.php" method="post" class="signup-form">
      <div class="username">
        <label class="username-label">名前</label>
        <input type="text" name="name" required>
      </div>
      <div class="email">
      <label class="email-label">メールアドレス</label>
        <input type="text" name="email" required>
      </div>
      <div class="password">
        <label class="password-label">パスワード</label>
        <input type="password" name="password" required>
      </div>
      <div class="signup-btn-container">
        <input type="submit" value="新規登録"  class="signup-btn">
      </div>
    </form>
    <p>すでに登録済みの方は<a href="./login.php">こちら</a></p>
  </div>
</body>
</html>