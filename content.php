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

$add_item_msg = '追加したいアイテムを入力してください';

// issetはkeyがあるかないかを判定する
if (isset($_SESSION['add_item_msg'])) {
  $add_item_msg =
    $_SESSION['add_item_msg'];
  unset($_SESSION['add_item_msg']);
}

// dbからアイテム読み込み
$db = dbconnect();
$category = db_first_get('category', $db);
$tag = db_first_get('tag', $db);
$img = db_first_get('img', $db);
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

            <span>
              <?php echo $add_item_msg; ?>
            </span>

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

            <form action="./scripts/item_add_check.php" method="POST" class="row" enctype="multipart/form-data">
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
          <input class="form-control blog-data" type="text" placeholder="Title" name="title">
        </div>
        <div class="col d-flex justify-content-end align-items-center">
          <div class="form-check form-switch me-3 d-flex align-items-center">
            <input class="form-check-input mt-0 blog-data" style="width:50px; height:25px; cursor: pointer;" type="checkbox" id="publishedBtn" checked name="published" value="true">
            <span id="publishedMsg" class="badge bg-dark ms-1">公開</span>
          </div>
          <input type="submit" value="アップロード" class="btn btn-success" id="uploadBtn">
        </div>
      </div>

      <!-- 本文 -->
      <div class="form-floating mt-3">
        <textarea class="form-control blog-data" style="height: 800px" id="body" name="body" placeholder="Just do it!"></textarea>
        <label for="body">Just do it!</label>
      </div>

      <!-- データ付与 -->
      <div class="metadata card d-flex mt-3 mb-5 p-3">
        <div class="row">

          <div class="col-6">
            <dt>メタデータ</dt>
            <div class="input-group mt-2">
              <span class="input-group-text">カテゴリ</span>
              <select class="form-select blog-data" name="category">
                <option selected>選んでください</option>
                <?php foreach ($category as $c) : ?>
                  <option value="<?php echo $c[0] ?>"><?php echo $c[1] ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="input-group mt-2">
              <span class="input-group-text">タグ</span>
              <input class="form-control" type="text" placeholder="選んでください" id="tagInputBox" data-bs-toggle="modal" data-bs-target="#tagModal" autocomplete=off>
            </div>

            <div class="form-floating mt-2">
              <textarea class="form-control blog-data" style="height: 150px" id="summary" name="summary" placeholder="要約" maxlength="200"></textarea>
              <label for="body">要約</label>
              <div class="d-flex justify-content-between">
                <span class="btn btn-secondary btn-sm mt-1" id="summaryInputBtn">冒頭を挿入</span>
                <span class="text-muted" id="summaryCount">0/200</span>
              </div>
            </div>
          </div>

          <!-- <div class="col-1"></div> -->

          <div class="col">
            <dl>
              <dt>サムネイル</dt>
              <dd>
                <img src="./image/sample.png" alt="" class="img-thumbnail" style="max-height: 350px;" id="thumnail">
              </dd>

              <dd>
                <div class="input-group">
                  <span class="input-group-text">画像</span>
                  <select class="form-select blog-data" name="thumnail" id="thumnailSelect">
                    <option selected>選んでください</option>
                    <?php foreach ($img as $i) : ?>
                      <!-- 検証画面でpath全見え。自分がｔ使うだけだから良いけど -->
                      <option value="<?php echo $i[0] ?>" id="<?php echo $i[2] ?>"><?php echo $i[1] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <span class="text-muted" id="thumnailPath" style="font-size: 12px;">path to thumnail</span>
              </dd>
              <dd>
                <div class="input-group">
                  <span class="input-group-text">SEO</span>
                  <input class="form-control blog-data" type="text" placeholder="altタグの値として使用" name="thumnail_seo">
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
              <?php foreach ($tag as $t) : ?>
                <div class="form-check">
                  <input class="form-check-input blog-data tag" id="<?php echo $t[1]; ?>" type="checkbox" name="tag[]" value="<?php echo $t[0]; ?>">
                  <label class="form-check-label" for="<?php echo $t[1]; ?>">
                    <?php echo $t[1]; ?>
                  </label>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="tagOkBtn">OK</button>
            </div>
          </div>
        </div>
      </div>

    </form>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <script src="./js/content.js"></script>