<?php
require_once(__DIR__ . "/shared/head.php");
?>
<link rel="stylesheet" href="./css/list.css">
</head>

<body>
  <?php require_once("./shared/header.php"); ?>
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
</body>

</html>