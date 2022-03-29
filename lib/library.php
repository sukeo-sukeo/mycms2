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

?>