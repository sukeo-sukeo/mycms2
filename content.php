<?php
require_once('./lib/library.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $db = dbconnect();

  // カテゴリの登録
  if (isset($_REQUEST['category']) && $_REQUEST['category'] !== '') {
    $category =
      filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $item = db_find_one('category', $category, $db);
    if (empty($item)) {
      db_insert_one('category', $category, $db);
    } else {
      header('Location: content.php');
      exit();
    }
  }

  // タグの登録
  if (isset($_REQUEST['tag']) && $_REQUEST['tag'] !== '') {
    $tag =
      filter_input(INPUT_POST, 'tag', FILTER_SANITIZE_STRING);
    $item = db_find_one('tag', $tag, $db);
    if (empty($item)) {
      db_insert_one('tag', $tag, $db);
    } else {
      header('Location: content.php');
      exit();
    }
  }

  // 画像の登録
  if (isset($_REQUEST['img']) && $_REQUEST['img'] !== '') {
    $img =
      filter_input(INPUT_POST, 'img', FILTER_SANITIZE_STRING);
    db_insert_one('img', $img, $db);
  }
}

require_once(__DIR__ . "/shared/head.php");
?>

</head>

<body>

  <?php require_once(__DIR__ . "/shared/header.php"); ?>

  <div class="container-fluid">

    <div class="accordion mt-3" id="top-accordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="top-accordion-heading">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#top-accordion-collapse" aria-expanded="true" aria-controls="top-accordion-collapse">
            素材を追加
          </button>
        </h2>

        <div id="top-accordion-collapse" class="accordion-collapse collapse show" aria-labelledby="top-accordion-heading" data-bs-parent="#top-accordion">
          <div class="accordion-body">

            <form action="" method="POST" class="row mb-2">
              <div class="input-group col">
                <span class="input-group-text">カテゴリ</span>
                <input class="form-control" type="text" name="category" placeholder="複数登録はカンマ区切りで入力">
              </div>
              <div class="col">
                <input type="submit" value="カテゴリを追加" class="btn btn-secondary">
              </div>
            </form>

            <form action="" method="POST" class="row mb-2">
              <div class="input-group col">
                <span class="input-group-text">タグ</span>
                <input class="form-control" type="text" name="tag" placeholder="複数登録はカンマ区切りで入力">
              </div>
              <div class="col">
                <input type="submit" value="タグを追加" class="btn btn-secondary">
              </div>
            </form>

            <form action="" method="POST" class="row">
              <div class="col">
                <span class="form-label"></span>
                <input class="form-control" type="file" name="img">
              </div>
              <div class="col">
                <input type="submit" value="画像をアップロード" class="btn btn-secondary">
              </div>
            </form>

          </div>
        </div>

      </div>
    </div>

    <form action="content_check.php" method="POST" class="mt-3 container">
      <div class="row d-flex">
        <div class="col-6">
          <input class="form-control" type="text" placeholder="Title" name="title">
        </div>
        <div class="col d-flex justify-content-end align-items-center">
          <div class="form-check form-switch me-3 d-flex align-items-center">
            <input class="form-check-input mt-0" style="width:50px; height:25px; cursor: pointer;" type="checkbox" id="publishedBtn" checked>
            <span id="publishedMsg" class="badge bg-dark ms-1">公開</span>
          </div>
          <input type="submit" value="アップロード" class="btn btn-success">
        </div>
      </div>

      <div class="form-floating mt-3">
        <textarea class="form-control" style="height: 800px" id="body" name="body" placeholder="Just do it!"></textarea>
        <label for="body">Just do it!</label>
      </div>

      <div class="metadata card d-flex mt-3">
        <div class="row">
          <div class="col">
            <div class="input-group">
              <span class="input-group-text">公開日</span>
              <input class="form-control" type="text" name="created" value="2022-04-03 06:34:56">
            </div>
            <div class="input-group">
              <span class="input-group-text">カテゴリ</span>
              <select class="form-select" name="category">
                <option selected>選んでください</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>
            <div class="input-group">
              <span class="input-group-text">タグ</span>
              <input class="form-control" type="text" placeholder="選んでください" data-bs-toggle="modal" data-bs-target="#tagModal">
            </div>
            <!-- tag Modal -->
            <div class="modal fade" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="tagModalLabel">タグ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body form-check">
                    <input class="form-check-input" type="checkbox" name="tag[]">
                    <input type="checkbox" name="tag[]">
                    <input type="checkbox" name="tag[]">
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="btn-group">
              <input type="checkbox" class="btn-check" id="tag1" name="tag[]">
              <label class="btn btn-outline-primary" for="tag1">タグ1</label>
              <input type="checkbox" class="btn-check" id="tag2" name="tag[]">
              <label class="btn btn-outline-primary" for="tag2">タグ2</label>
              <input type="checkbox" class="btn-check" id="tag3" name="tag[]">
              <label class="btn btn-outline-primary" for="tag3">タグ3</label>
            </div> -->
            <dl>
              <dt>要約</dt>
              <dd>
                <textarea name="sumarry" id="" cols="30" rows="10" placeholder="空白であれば本文の先頭を表示"></textarea>
              </dd>
            </dl>
          </div>

          <div class="col">
            <dl>
              <dt>サムネイル</dt>
              <dd>
                <img src="" alt="">
              </dd>
              <dd>
                <select name="thumnail">
                  <option value=""></option>
                  <option value="a">thumnail１</option>
                  <option value="b">thumnail２</option>
                </select>
              </dd>
              <dd>
                <input type="text" placeholder="SEO" name="thumnail_seo">
              </dd>
            </dl>
          </div>

        </div>
      </div>

    </form>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <script src="./js/content.js"></script>