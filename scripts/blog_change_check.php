<?php 
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_REQUEST);
  
  if (isset($_REQUEST['trash'])) {
    $blog_id = (int) filter_input(INPUT_POST, 'trash', FILTER_SANITIZE_STRING);
  
    $db = dbconnect();
    
    db_delete_one('blog', $blog_id, $db);
    header('Location: ../list.php');

  }

}