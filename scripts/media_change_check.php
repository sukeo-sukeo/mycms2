<?php 
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_REQUEST);
  
  if (isset($_REQUEST['trash'])) {
    $img_id = (int) filter_input(INPUT_POST, 'trash', FILTER_SANITIZE_STRING);
  
    $db = dbconnect();
    
    db_delete_one('img', $img_id, $db);
    header('Location: ../media.php');
    exit();
  }

  if (isset($_REQUEST['change_name'])) {
    var_dump("change!");
    exit();
    $img_id = (int) filter_input(INPUT_POST, 'change', FILTER_SANITIZE_STRING);

    $db = dbconnect();

    db_delete_one('img', $img_id, $db);
    header('Location: ../media.php');
    exit();
  }
}