<?php
session_start();

// login check
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
  $id = $_SESSION['id'];
} else {
  header('Location: ./auth/login.php');
  exit();
}

// issetはkeyがあるかないかを判定する
// タグと共通のキーにする
if (isset($_SESSION['add_item'])) {
  $cate = $_SESSION['add_item'];

  if ($cate === 'blank') {
    echo '空白です';
  }

  if ($cate === 'duplicate') {
    echo '既に登録があります';
  }

  unset($_SESSION['add_item']);
  
} else {
  echo "追加に成功！";
}
?>

<!-- html -->
<?php require_once(__DIR__ . "/shared/head.php"); ?>
</head>

<body>

  <?php require_once(__DIR__ . "/shared/header.php"); ?>

  <div class="container-fluid">

    <!-- 新規素材の追加メニューボックス -->
    <div class="accordion mt-3" id="top-accordion">
      <div class="accordion-item">
        <h2 class="accordion-header" id="top-accordion-heading">
          <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#top-accordion-collapse" aria-expanded="true" aria-controls="top-accordion-collapse">
            素材を追加
          </button>
        </h2>

        <div id="top-accordion-collapse" class="accordion-collapse collapse show" aria-labelledby="top-accordion-heading" data-bs-parent="#top-accordion">
          <div class="accordion-body">

            <form action="./scripts/item_add_check.php" method="POST" class="row mb-2">
              <div class="input-group col">
                <span class="input-group-text">カテゴリ</span>
                <input class="form-control" type="text" name="category" placeholder="複数登録はカンマ区切りで入力">
              </div>
              <div class="col">
                <input type="submit" value="カテゴリを追加" class="btn btn-secondary">
              </div>
            </form>

            <form action="./scripts/item_add_check.php" method="POST" class="row mb-2">
              <div class="input-group col">
                <span class="input-group-text">タグ</span>
                <input class="form-control" type="text" name="tag" placeholder="複数登録はカンマ区切りで入力">
              </div>
              <div class="col">
                <input type="submit" value="タグを追加" class="btn btn-secondary">
              </div>
            </form>

            <form action="./scripts/item_add_check.php" method="POST" class="row">
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

    <!-- 記事作成 -->
    <form action="./scripts/blog_post_check.php" method="POST" class="mt-3 container">

      <!-- トップ -->
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

      <!-- 本文 -->
      <div class="form-floating mt-3">
        <textarea class="form-control" style="height: 800px" id="body" name="body" placeholder="Just do it!"></textarea>
        <label for="body">Just do it!</label>
      </div>

      <!-- データ付与 -->
      <div class="metadata card d-flex mt-3 mb-5 p-3">
        <div class="row">

          <div class="col-6">
            <dt>メタデータ</dt>
            <div class="input-group">
              <span class="input-group-text">公開日</span>
              <input class="form-control" type="text" name="created" value="2022-04-03 06:34:56">
            </div>

            <div class="input-group mt-2">
              <span class="input-group-text">カテゴリ</span>
              <select class="form-select" name="category">
                <option selected>選んでください</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
              </select>
            </div>

            <div class="input-group mt-2">
              <span class="input-group-text">タグ</span>
              <input class="form-control" type="text" placeholder="選んでください" data-bs-toggle="modal" data-bs-target="#tagModal">
            </div>

            <div class="form-floating mt-2">
              <textarea class="form-control" style="height: 150px" id="body" name="summary" placeholder="要約"></textarea>
              <label for="body">要約</label>
            </div>
          </div>

          <!-- <div class="col-1"></div> -->

          <div class="col">
            <dl>
              <dt>サムネイル</dt>
              <dd>
                <img src="./image/sample.png" alt="" class="img-thumbnail" style="max-height: 350px;">
              </dd>

              <dd>
                <div class="input-group">
                  <span class="input-group-text">PATH</span>
                  <input class="form-control" type="text" placeholder="画像のパス" name="thumnail">
                </div>
              </dd>
              <dd>
                <div class="input-group">
                  <span class="input-group-text">SEO</span>
                  <input class="form-control" type="text" placeholder="altタグの値として使用" name="thumnail_seo">
                </div>
              </dd>
            </dl>
          </div>

        </div>
      </div>

      <!-- tag Modal -->
      <div class="modal fade" id="tagModal" tabindex="-1" aria-labelledby="tagModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="top: 50%;">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="tagModalLabel">タグ</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <div class="form-check">
                <input class="form-check-input" id="tag1" type="checkbox" name="tag[]" value="tag1">
                <label class="form-check-label" for="tag1">
                  tag1
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" id="tag2" type="checkbox" name="tag[]" value="tag2">
                <label class="form-check-label" for="tag2">
                  tag2
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" id="tag3" type="checkbox" name="tag[]" value="tag3">
                <label class="form-check-label" for="tag3">
                  tag3
                </label>
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <script src="./js/content.js"></script>