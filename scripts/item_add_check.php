<?php
session_start();
require_once(__DIR__ . '/../lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $db = dbconnect();
  
  // カテゴリ、タグの登録
  if (isset($_REQUEST['category']) || isset($_REQUEST['tag'])) {
    $table_name = array_key_first($_REQUEST);
    $add_item = filter_input(INPUT_POST, $table_name, FILTER_SANITIZE_STRING);
    
    // 空白の場合
    if ($add_item === '') {
      $_SESSION['add_item_msg'] = '空白です';
      header('Location: ../content.php');
      exit();
    }

    // カンマ区切りに対応
    $add_items = explode(',', str_replace('、',',',$add_item));
    
    foreach ($add_items as $add_item) {
      $item = db_find_one($table_name, trim($add_item), $db);
      // itemが存在しなかったら新規登録
      if (empty($item)) {
        db_insert_one($table_name, $add_item, 'name', $db);
        $_SESSION['add_item_msg'] .= $add_item . '<span class="badge bg-success">OK</span> ';
      } else {
        $_SESSION['add_item_msg'] .= $add_item . '<span class="badge bg-secondary">Already</span> ';
      }
    };
    header('Location: ../content.php');
    exit(); 
  }

  // 画像の登録
  if (isset($_FILES['img'])) {
    $img = $_FILES['img'];
    
    // 空白の場合
    if ($img['name'] === '') {
      $_SESSION['add_item_msg'] = 'ファイルが選択されていません';
      header('Location: ../content.php');
      exit();
    }

    // ファイルタイプのチェック
    $type = mime_content_type($img['tmp_name']);
    if ($type !== 'image/png' && $type !== 'image/jpeg') {
      $_SESSION['add_item_msg'] = '.png か .jpg を選択してください';
      header('Location: ../content.php');
      exit();
    }

    // 画像のアップロード
    $img_name = basename($img['name']);
    $filename = date('YmdHis') . '_' . $img_name;
    $path = 'image/contents/' . $filename;
    // move_uploaded_fileは失敗するとfalseを返す
    if (!move_uploaded_file($img['tmp_name'], '../' . $path)) {
      die('ファイルのアップロードに失敗しました');
    }

    // dbへパスを保存
    $items = [
      'path' => './' . $path,
      'name' => $img_name,
      'meta_name' => $filename
    ];
    db_insert_many('img', $items, $db);
    

    $_SESSION['add_item_msg'] = $img['name'] . ' をアップロードしました';
    header('Location: ../content.php');
    exit();
  }

}

?>