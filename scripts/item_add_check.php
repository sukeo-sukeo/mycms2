<?php
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $db = dbconnect();

  // カテゴリ、タグの登録
  if ((isset($_REQUEST['category']) && $_REQUEST['category'] !== '') ||
      (isset($_REQUEST['tag']) && $_REQUEST['tag'] !== '')) {
    $table_name = array_key_first($_REQUEST);
    $add_item =
      filter_input(INPUT_POST, $table_name, FILTER_SANITIZE_STRING);
    $item = db_find_one($table_name, $add_item, $db);
    if (empty($item)) {
      db_insert_one($table_name, $add_item, $db);
      header('Location: ../content.php');
      exit();
    } else {
      $_SESSION['add_item'] = 'duplicate';
      header('Location: ../content.php');
      exit();
    }
  } else {
    $_SESSION['add_item'] = 'blank';
    header('Location: ../content.php');
    exit();
  }

  // 画像の登録
  if (isset($_REQUEST['img']) && $_REQUEST['img'] !== '') {
    $img =
      filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
    db_insert_one('img', $img, $db);
  }
}

?>