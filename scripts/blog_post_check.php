<?php
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // var_dump($_REQUEST);
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
    $table_name = 'blog';
    $items = [
      'title' => $title,
      'body' => $body,
      'summary' => $summary,
      'published' => $published,
    ];

    // まずはblog_idを取得
    if (isset($_SESSION['edit_id'])) {
      // update(既存記事の更新)
      $blog_id = $_SESSION['edit_id'];
    } else {
      // insert(新規)
      $blog_id = db_insert_many($table_name, $items, $db);
    }

    // blogに紐づくcategoryの登録
    $table_name2 = 'blog_category';
    $items2 = [
      'blog_id' => $blog_id,
      'category_id' => $category_id
    ];

    // blogに紐づくthumnailの登録
    $table_name3 = 'blog_thumnail';
    $items3 = [
      'blog_id' => $blog_id,
      'img_id' => $thumnail_id,
      'thumnail_seo' => $thumnail_seo
    ];
    
    // blogに紐づくtagの登録
    $table_name4 = 'blog_tag';
    $items4s = [];
    foreach ($tag_ids as $tag_id) {
      array_push($items4s, [
          'blog_id' => $blog_id,
          'tag_id' => $tag_id,
        ]);
    }

    if (isset($_SESSION['edit_id'])) {
      // update(既存記事の更新)
      $items = [
        'blog' => $items, 
        'blog_category' => $items2, 
        'blog_thumnail' => $items3, 
      ];
      db_update_blog($blog_id, $items, $db);
      db_update_blog_tag($blog_id, $items4s, $db);
    } else {
      // insert(新規)
      db_insert_many($table_name2, $items2, $db);
      db_insert_many($table_name3, $items3, $db);
      foreach ($items4s as $items4) {
        db_insert_many($table_name4, $items4, $db);
      }
    }

  } catch(Exception $e) {
    $db->rollback();
  }
  
  $db->commit();
  header('Location: ../content.php');
  exit();

}