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
  $category_id = (int) filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
  $tag = filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_STRING);
  $thumnail_id = (int) filter_input(INPUT_POST, 'thumnail', FILTER_SANITIZE_STRING);
  $thumnail_seo = filter_input(INPUT_POST, 'thumnail_seo', FILTER_SANITIZE_STRING);
  
  $db = dbconnect();

  // blog本体の登録
  $items = [
    'title' => $title,
    'body' => $body,
    'summary' => $summary,
    'published' => $published,
  ];
  $table_name = 'blog';
  $blog_id = db_insert_many($table_name, $items, $db);
  var_dump($blog_id);
  
  // blogに紐づくcategoryの登録
  $items = [
    'blog_id' => $blog_id,
    'category_id' => $category_id
  ];
  $table_name = 'blog_category';
  db_insert_many($table_name, $items, $db);
  
  // blogに紐づくthumnailの登録
  $items = [
    'blog_id' => $blog_id,
    'img_id' => $thumnail_id,
    'thumnail_seo' => $thumnail_seo
  ];
  $table_name = 'blog_thumnail';
  db_insert_many($table_name, $items, $db);
  
  exit();
  header('Location: ../content.php');
  exit();

}
