<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

var_dump($_SESSION);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ローカル開発環境</title>
</head>

<body>
  <?php echo "トップページ" ?>
  <div style="text-align: right"><a href="logout.php">ログアウト</a></div>
</body>

</html>