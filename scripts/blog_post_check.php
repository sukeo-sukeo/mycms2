<?php
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  var_dump($_REQUEST);
  // dbに保存
  $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
  $body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);
  $summary = filter_input(INPUT_POST, 'summary', FILTER_SANITIZE_STRING);
  $published = filter_input(INPUT_POST, 'published', FILTER_SANITIZE_STRING);
  
  // $created = filter_input(INPUT_POST, 'created', FILTER_SANITIZE_STRING);
  $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
  $tag = filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_STRING);
  $thumnail = filter_input(INPUT_POST, 'thumnail', FILTER_SANITIZE_STRING);
  $thumnail_seo = filter_input(INPUT_POST, 'thumnail_seo', FILTER_SANITIZE_STRING);
  
  $db = dbconnect();

  $items = [
    'title' => $title,
    'body' => $body,
    'summary' => $summary,
    'published' => $published,
  ];
  
  $id = db_insert_many('blog', $items, $db);
  var_dump($id);
  exit();
  
  header('Location: ../content.php');
  exit();

}