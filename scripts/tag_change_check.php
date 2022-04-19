<?php 
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_REQUEST);
  
  if (isset($_REQUEST['trash'])) {
    $tag_id = (int) filter_input(INPUT_POST, 'trash', FILTER_SANITIZE_STRING);
  
    $db = dbconnect();
    
    $cnt = db_exist_check('blog_tag', $tag_id, 'tag_id', $db);
    
    if (!$cnt) {
      db_delete_one('tag', $tag_id, $db);
      header('Location: ../tag.php');
      exit();
    } else {
      $msg = '使用中のタグは削除できません';
      $_SESSION['change-msg'] = $msg;
      header('Location: ../tag.php');
      exit();
    }

  }

  if (isset($_REQUEST['change_name'])) {
    $tag_name = filter_input(INPUT_POST, 'change_name', FILTER_SANITIZE_STRING);
    $tag_id = (int) filter_input(INPUT_POST, 'change_id', FILTER_SANITIZE_STRING);

    $db = dbconnect();

    db_update_one('tag', $tag_name, $tag_id, $db);
    header('Location: ../tag.php');
    exit();
  }
}