<?php
session_start();
require_once(__DIR__ . '/lib/library.php');

// login check
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
  $id = $_SESSION['id'];
} else {
  header('Location: ./auth/login.php');
  exit();
}

$db = dbconnect();
// 一覧を取得
?>

<!-- html -->
<?php require_once(__DIR__ . "/shared/head.php"); ?>
<link rel="stylesheet" href="./css/list.css">
</head>

<body>
  <?php require_once(__DIR__ . "/shared/header.php"); ?>
  
  <div class="container-fluid">
    <div>
      <button><a href="content.php">新規作成</a></button>
    </div>
    <div class="menu">
      <div class="search1">
        <button>全て</button>
        <button>下書き</button>
        <button>公開済</button>
      </div>
      <div class="search2">
        <select name="" id="">
          <option value="カテゴリ">カテゴリ</option>
          <option value="">サンプル１</option>
          <option value="">サンプル２</option>
        </select>
      </div>
    </div>
    <div>
      <ul style="display: flex; list-style:none; background:gray;">
        <li>
          <img src="" alt="">
        </li>
        <li>
          <a href="content.php">タイトル</a>
        </li>
        <li>
          <span>最終更新日</span>
        </li>
      </ul>
    </div>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>