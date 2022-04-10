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
  
  if (!$published) {
    $published = (string) 'false';
  }
  
  $category_id = (int) filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
  $tag_ids = filter_input(INPUT_POST, 'tag',FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
  $thumnail_id = (int) filter_input(INPUT_POST, 'thumnail', FILTER_SANITIZE_STRING);
  $thumnail_seo = filter_input(INPUT_POST, 'thumnail_seo', FILTER_SANITIZE_STRING);

  $db = dbconnect();

  $db->begin_transaction();
  try {
    // blog本体の登録
    $items = [
      'title' => $title,
      'body' => $body,
      'summary' => $summary,
      'published' => $published,
    ];
    $table_name = 'blog';
    $blog_id = db_insert_many($table_name, $items, $db);
    
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
    
    // blogに紐づくtagの登録
    foreach ($tag_ids as $tag_id) {
      $items = [
        'blog_id' => $blog_id,
        'tag_id' => $tag_id,
      ];
      $table_name = 'blog_tag';
      db_insert_many($table_name, $items, $db);
    }
  } catch(Exception $e) {
    $db->rollback();
  }
  
  $db->commit();
  header('Location: ../content.php');
  exit();

}
