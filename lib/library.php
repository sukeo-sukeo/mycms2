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
  $id = '';
  $name = '';
  $path = '';
  $created = '';
  $results = [];

  if ($table_name === 'img') {
    $stmt = $db->prepare("select id, name, path, created from $table_name order by created desc");
  } else {
    $stmt = $db->prepare("select id, name from $table_name");
  }

  if (!$stmt) {
    die($db->error);
  }
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  if ($table_name === 'img') {
    $stmt->bind_result($id, $name, $path, $created);
    while ($stmt->fetch()) {
      array_push($results, [$id, $name, $path, $created]);
    }
  } else {
    $stmt->bind_result($id, $name);
    while ($stmt->fetch()) {
      array_push($results, [$id, $name]);
    }
  }

  return $results;
}