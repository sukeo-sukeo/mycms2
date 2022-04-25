<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  header('Location: ../index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mycms2_ログインページ</title>
</head>

<body>
  <h2>ログイン</h2>
  <form action="./login_check.php" method="POST">
    <label for="name">管理者名</label><br>
    <input type="text" name="name" id="name"><br>
    <label for="password">パスワード</label><br>
    <input type="password" name="password" id="password"><br>
    <label for="re_password">パスワード再入力</label><br>
    <input type="password" name="re_password"><br>
    <input type="submit" value="ログイン">
  </form>
  <div>
    <?php if (isset($_SESSION['error']['login'])) : ?>
      <?php if ($_SESSION['error']['login'] === 'blank') : ?>
        <p>管理者名とパスワードを正しく入力してください</p>
      <?php endif; ?>
      <?php if ($_SESSION['error']['login'] === 'nomuch') : ?>
        <p>パスワードが一致しません</p>
      <?php endif; ?>
      <?php if ($_SESSION['error']['login'] === 'failed') : ?>
        <p>ログインに失敗しました</p>
      <?php endif; ?>
    <?php endif; ?>
  </div>

</body>

</html>