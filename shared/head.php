<?php
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
  $id = $_SESSION['id'];
} else {
  header('Location: login.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mycms2</title>
  <link rel="stylesheet" href="./css/common.css">