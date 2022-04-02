<?php

function h($value)
{
  return htmlspecialchars($value, ENT_QUOTES);
}

function dbconnect() {
  // local
  require('./config/database/info_dev.php');
  // vartualbox
  // require('./config/database/info_test.php');
  // 本番
  // require('./config/database/info_pro.php');
  $dbinfo = get_dbinfo();

  
  $db = new mysqli($dbinfo['host'], $dbinfo['username'], $dbinfo['passwd'], $dbinfo['dbname']);

  if (!$db) {
    die($db->error);
  }

  return $db;
}

function db_insert_one($table, $item, $db) {
  $stmt = $db->prepare("insert into $table (name) values(?)");
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bind_param('s', $item);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  header('Location: content.php');
  exit(); 
}

function db_find_one($table, $item, $db) {
  $name = '';
  $stmt = $db->prepare("select name from $table where name=? limit 1");
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