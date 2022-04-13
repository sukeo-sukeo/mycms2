<?php
session_start();
require_once(__DIR__ . '/../lib/library.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 値のチェック
  $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_EMAIL);
  $pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
  $re_pass = filter_input(INPUT_POST, 're_password', FILTER_SANITIZE_STRING);
  
  var_dump([$name, $pass, $re_pass]);
  if ($name === '' || $pass === '') {
    $_SESSION['error']['login'] = 'blank';
    header('Location: ./login.php');
    exit();
  } elseif ($pass !== $re_pass) {
    $_SESSION['error']['login'] = 'nomuch';
    header('Location: ./login.php');
    exit();
  } else {
    $db = dbconnect();
    $stmt = $db->prepare('select id, name, password from user where name=? limit 1');
    if (!$stmt) {
      die($db->error);
    }
    $stmt->bind_param('s', $name);
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }
    $stmt->bind_result($id, $name, $hash);
    $stmt->fetch();
    
    if (password_verify($pass, $hash)) {
      session_regenerate_id();
      $_SESSION['id'] = $id;
      $_SESSION['name'] = $name;
      header('Location: ../index.php');
      exit();
    } else {
      $_SESSION['error']['login'] = 'failed';
      header('Location: ./login.php');
      exit();
    }
  }
} else {
  header('Location: ./login.php');
}
