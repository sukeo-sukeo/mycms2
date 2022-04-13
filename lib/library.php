<?php

function h($value)
{
  return htmlspecialchars($value, ENT_QUOTES);
}

function dbconnect() {
  // local
  require(__DIR__ . '/../config/database/info_dev.php');
  // vartualbox
  // require(__DIR__ . '/../config/database/info_test.php');
  // 本番
  // require(__DIR__ . '/../config/database/info_pro.php');
  $dbinfo = get_dbinfo();

  
  $db = new mysqli($dbinfo['host'], $dbinfo['username'], $dbinfo['passwd'], $dbinfo['dbname']);

  if (!$db) {
    die($db->error);
  }

  return $db;
}

function db_insert_one($table_name, $item, $column, $db) {
  $stmt = $db->prepare("insert into $table_name ($column) values(?)");
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bind_param('s', $item);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }
  $id = $stmt->insert_id;
  return $id;
}

function db_insert_many($table_name, $items, $db) {
  
  $columns = implode(',', array_keys($items));
  $values = array_values($items);
  $questions = '';
  for ($i=0; $i<count($items); $i++) {
    $questions .= '?,';
  };
  $questions = rtrim($questions, ',');
  
  $query = "insert into $table_name ($columns) values ($questions)";
  
  $stmt = $db->prepare($query);

  if (!$stmt) {
    die($db->error);
  }
 
  // $type = $table_name === 'blog' ? 's' : 'i';
  $stmt->bind_param(str_repeat('s', count($items)), ...$values);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  };
  $id = $stmt->insert_id;
  return $id;
}

// idで検索すればよかった...初期の頃に組んだ関数
function db_find_one($table_name, $item, $db) {
  $name = '';
  $stmt = $db->prepare("select name from $table_name where name=? limit 1");
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bind_param('s', $item);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  $stmt->bind_result($name);
  $stmt->fetch();
  return $name;
}

function db_find_blog($table_name, $blog_id, $db) {
  $result = [];

  $id = '';
  $title = '';
  $body = '';
  $published = '';
  $summary = '';
  $thumnail_seo = '';
  $path = '';
  $category = '';

  $query = "
      select b.id, b.title, b.body, b.published, b.summary, bi.thumnail_seo, i.path, c.name
      from 
      $table_name b 
      left join 
      blog_thumnail bi 
      on b.id = bi.blog_id
      left join 
      blog_category bc
      on b.id = bc.blog_id
      left join 
      blog_tag bt
      on b.id = bt.blog_id
      left join
      img i
      on bi.img_id = i.id
      left join
      category c
      on bc.category_id = c.id
      where b.id = ? limit 1";

  $stmt = $db->prepare($query);
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bind_param('s', $blog_id);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  };

  $stmt->bind_result($id, $title, $body, $published, $summary, $thumnail_seo, $path, $category);
  $stmt->fetch();

  $result['id'] = $id;
  $result['title'] = $title;
  $result['body'] = $body;
  $result['published'] = $published;
  $result['summary'] = $summary;
  $result['thumnail_seo'] = $thumnail_seo;
  $result['path'] = $path;
  $result['category'] = $category;

  // ここでもう一回タグをとってくる...
  var_dump($result);
  exit();
  return $result;
}


function db_delete_one($table_name, $id, $db) {
  $stmt = $db->prepare("delete from $table_name where id=? limit 1");
  if (!$stmt) {
    die($db->error);
  }

  $stmt->bind_param('i', $id);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }
}

function db_update_one($table_name, $name, $id, $db) {
  $stmt = $db->prepare("update $table_name set name=? where id=?");
  if (!$stmt) {
    die($db->error);
  }

  $stmt->bind_param('si', $name, $id);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }
}

// 初期表示データの取得
function db_first_get($table_name, $db) {
  // 変数列挙->改善の余地あり
  $id = '';
  $name = '';
  $path = '';
  $created = '';
  $title = ''; 
  $published = ''; 
  $updated = '';
  $img_id = '';
  $img_path = '';

  $results = [];

  switch ($table_name) {
    case 'blog':
      $query = "
      select b.id, b.title, b.published, b.updated, i.id, i.path 
      from 
      $table_name b 
      left join 
      blog_thumnail t 
      on b.id = t.blog_id
      left join
      img i
      on t.img_id = i.id";
    break;
    case 'img':
      $query = "select id, name, path, created from $table_name order by id desc";
    break;
    default:
      $query = "select id, name from $table_name order by id desc";
    break;
  }


  $stmt = $db->prepare($query);

  if (!$stmt) {
    die($db->error);
  }
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  switch ($table_name) {
    case 'blog':
      $stmt->bind_result($id, $title, $published, $updated, $img_id, $img_path);
      while ($stmt->fetch()) { 
        array_push($results, [$id, $title, $published, $updated, $img_id, $img_path]);
      }
    break;
    case 'img':
      $stmt->bind_result($id, $name, $path, $created);
      while ($stmt->fetch()) {
        array_push($results, [$id, $name, $path, $created]);
      }
    break;
    default:
      $stmt->bind_result($id, $name);
      while ($stmt->fetch()) {
        array_push($results, [$id, $name]);
      }
  }

  return $results;
}