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

function db_exist_check($table_name, $id, $col, $db) {
  $cnt = 0;
  $stmt = $db->prepare("select count(*) from $table_name where $col=?");
  if (!$stmt) {
    die($db->error);
  }
  $stmt->bind_param('i', $id);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  $stmt->bind_result($cnt);
  $stmt->fetch();
  return $cnt;
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
function db_first_get($table_name, $db, $blog_id='', $search_type='', $search_type2='') {
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

  // single
  $body = '';
  $summary = '';
  $category_id = '';
  $thumnail_id = '';
  $thumnail_seo = '';
  $tag_id = '';

  $results = [];
  
  switch ($table_name) {
    case 'blog':
      if ($search_type === '') {
        // 全件取得
        $query = "
        select b.id, b.title, b.published, b.updated, i.id, i.path 
        from 
        $table_name b 
        left join 
        blog_thumnail t 
        on b.id = t.blog_id
        left join
        img i
        on t.img_id = i.id
        order by b.updated desc";
      } else {

        // category絞り込み
        if ($search_type === 'category') {
          $cate_id = $blog_id;
          $cond = '';
          if ($search_type2 === 'pub') {
            $cond = (string) 'true';   
          }
          if ($search_type2 === 'un_pub') {
            $cond = (string) 'false';   
          }
          $query = "
          select b.id, b.title, b.published, b.updated, i.id, i.path 
          from
          blog_category bc
          left join
          $table_name b
          on bc.blog_id = b.id
          left join 
          blog_thumnail t 
          on b.id = t.blog_id
          left join
          img i
          on t.img_id = i.id
          where bc.category_id = $cate_id";
          $query2 = " and b.published = '$cond'";
          $query3 = " order by b.updated desc";
          $query .= $cond ? $query2.$query3 : $query3;
        }
        // 公開｜非公開の取得
        if ($search_type === 'published' || $search_type === 'un_published') {
          
          if ($search_type === 'published') {
            $cond = (string) 'true';
          }
          if ($search_type === 'un_published') {
            $cond = (string) 'false';
          }

          $query = "
          select b.id, b.title, b.published, b.updated, i.id, i.path 
          from
          $table_name b 
          left join 
          blog_thumnail t 
          on b.id = t.blog_id
          left join
          img i
          on t.img_id = i.id
          where b.published = '$cond'
          order by b.updated desc";
          }
        }
    break;
    case 'img':
      $query = "select id, name, path, created from $table_name order by id desc";
    break;
    case 'single':
      $query = "select 
      b.id, b.title, b.body, b.summary, b.published, b.updated, bc.category_id, bt.img_id, bt.thumnail_seo 
      from 
      blog b
      left join
      blog_category bc
      on b.id = bc.blog_id
      left join
      blog_thumnail bt
      on b.id = bt.blog_id
      where b.id = $blog_id limit 1";
    break;
    case 'tag_single':
      $query = "select tag_id from blog_tag where blog_id = $blog_id";
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
    case 'single':
      $stmt->bind_result($id, $title, $body, $summary, $published, $updated, $category_id, $thumnail_id, $thumnail_seo);
      $stmt->fetch();
      $results['id'] = $id;
      $results['title'] = $title;
      $results['body'] = $body;
      $results['summary'] = $summary;
      $results['published'] = $published;
      $results['updated'] = $updated;
      $results['category_id'] = $category_id;
      $results['thumnail_id'] = $thumnail_id;
      $results['thumnail_seo'] = $thumnail_seo;
    break;
    case 'tag_single':
      $stmt->bind_result($tag_id);
      while ($stmt->fetch()) {
        array_push($results, $tag_id);
      };
    break;
    default:
      $stmt->bind_result($id, $name);
      while ($stmt->fetch()) {
        array_push($results, [$id, $name]);
      }
    break;
  }

  return $results;
}

function db_update_blog($blog_id, $items, $db) {

  $table_names = array_keys($items);
 
  foreach ($table_names as $table_name) {
    // 本文の更新
    if ($table_name === 'blog') {
      $query = "update blog set title = ?, body = ?, summary = ?, published = ? where id = $blog_id ";
      $stmt = $db->prepare($query);
      if (!$stmt) {
        die($db->error);
      }
      $blog = $items[$table_name];
      $stmt->bind_param('ssss', $blog['title'], $blog['body'], $blog['summary'], $blog['published']);
    }
    // カテゴリの更新
    if ($table_name === 'blog_category') {
      $query = "update $table_name set category_id = ? where blog_id = $blog_id ";
      $stmt = $db->prepare($query);
      if (!$stmt) {
        die($db->error);
      }
      $blog = $items[$table_name];
      $stmt->bind_param('i', $blog['category_id']); 
    }
    // サムネイルの更新
    if ($table_name === 'blog_thumnail') {
      $query = "update $table_name set img_id = ?, thumnail_seo = ? where blog_id = $blog_id ";
      $stmt = $db->prepare($query);
      if (!$stmt) {
        die($db->error);
      }
      $blog = $items[$table_name];
      $stmt->bind_param('is', $blog['img_id'], $blog['thumnail_seo']); 
    }
  
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }
  }
}

function db_update_blog_tag($blog_id, $items, $db) {
  $table_name = 'blog_tag';
  $tag_ids = $items;//[blog_id, tag_id]

  // まず削除
  $query = "delete from $table_name where blog_id = ?";
  $stmt = $db->prepare($query);
  if (!$stmt) {
    die($db->error);
  }

  $stmt->bind_param('i', $blog_id);
  $success = $stmt->execute();
  if (!$success) {
    die($db->error);
  }

  // 改めてインサート
  foreach ($tag_ids as $tag_id) {
    $query = "insert into $table_name (blog_id, tag_id) values (?, ?)";
    $stmt = $db->prepare($query);
    if (!$stmt) {
      die($db->error);
    }

    $stmt->bind_param('ii', $blog_id, $tag_id['tag_id']);
    $success = $stmt->execute();
    if (!$success) {
      die($db->error);
    }
  }
  
}