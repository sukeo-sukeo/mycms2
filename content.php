<?php
require_once(__DIR__ . "/shared/head.php");
?>

</head>

<body>
  <?php require_once("./shared/header.php"); ?>
  <div class="menu">
    <div>
      <button>公開｜非公開</button>
      <button>アップロード</button>
    </div>
  </div>
  <div>
    <input type="text" placeholder="タイトル">
  </div>
  <div class="main">
    <textarea name="" id="" cols="30" rows="10"></textarea>
  </div>
  <div class="metadata">
    <dl>
      <dt>公開日</dt>
      <dd>2022-04-02 05:59:03</dd>
    </dl>
    <dl>
      <dt>カテゴリ</dt>
      <dd>
        <input type="text">
      </dd>
      <dd>
        <select name="" id="">
          <option value=""></option>
          <option value="">カテゴリ１</option>
          <option value="">カテゴリ２</option>
        </select>
      </dd>
    </dl>
    <dl>
      <dt>タグ</dt>
      <dd>
        <input type="text" placeholder="カンマ区切りで入力">
      </dd>
      <dd>
        <input type="checkbox" name="タグ1" id="タグ1">
        <label for="タグ1">タグ1</label>
        <input type="checkbox" name="タグ2" id="タグ2">
        <label for="タグ2">タグ2</label>
        <input type="checkbox" name="タグ3" id="タグ3">
        <label for="タグ3">タグ3</label>
      </dd>
    </dl>
    <dl>
      <dt>要約</dt>
      <dd>
        <textarea name="" id="" cols="30" rows="10" placeholder="空白であれば本文の先頭を表示"></textarea>
      </dd>
    </dl>
    <dl>
      <dt>サムネイル</dt>
      <dd>
        <img src="" alt="">
      </dd>
      <dd>
        <input type="file" name="" id="">
      </dd>
      <dd>
        <input type="text" placeholder="SEO">
      </dd>
    </dl>
  </div>
</body>

</html>