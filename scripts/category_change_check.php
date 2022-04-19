<?php 
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_REQUEST);
  
  if (isset($_REQUEST['trash'])) {
    $cate_id = (int) filter_input(INPUT_POST, 'trash', FILTER_SANITIZE_STRING);
  
    $db = dbconnect();
    
    $cnt = db_exist_check('blog_category', $cate_id, 'category_id', $db);
    
    if (!$cnt) {
      db_delete_one('category', $cate_id, $db);
      header('Location: ../category.php');
      exit();
    } else {
      $msg = '使用中のカテゴリーは削除できません';
      $_SESSION['change-msg'] = $msg;
      header('Location: ../category.php');
      exit();
    }

  }

  if (isset($_REQUEST['change_name'])) {
    $cate_name = filter_input(INPUT_POST, 'change_name', FILTER_SANITIZE_STRING);
    $cate_id = (int) filter_input(INPUT_POST, 'change_id', FILTER_SANITIZE_STRING);

    $db = dbconnect();

    db_update_one('category', $cate_name, $cate_id, $db);
    header('Location: ../category.php');
    exit();
  }
}