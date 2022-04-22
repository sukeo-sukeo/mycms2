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

if (isset($_SESSION['add_item_msg'])) {
  $_SESSION['change-msg'] =
    $_SESSION['add_item_msg'];
  unset($_SESSION['add_item_msg']);
}

// dbからアイテム読み込み
$db = dbconnect();
$category = db_first_get('category', $db);

?>

<!-- html -->
<?php require_once(__DIR__ . "/shared/head.php"); ?>
<!-- css -->
<link rel="stylesheet" href="./css/media.css">
</head>

<body>

  <?php require_once(__DIR__ . "/shared/header.php"); ?>

  <div class="container-fluid">
    <!-- アップロード機構 -->
    <div class="row mt-3 d-flex">
      <span class="h3 col-3">カテゴリの管理</span>
      <form action="./scripts/item_add_check.php" method="POST" class="col d-flex">
        <div class="input-group col">
          <span class="input-group-text">カテゴリ</span>
          <input class="form-control" type="text" name="category" placeholder="複数登録はカンマ区切りで入力" id="val">
        </div>
        <div class="col ms-2">
          <input type="submit" value="カテゴリを追加" class="btn btn-secondary" id="addBtn">
        </div>
      </form>
    </div>

    <!-- アナウンス -->
    <p style="height: 24px;">
      <?php if (isset($_SESSION['change-msg'])) {
        echo $_SESSION['change-msg'];
        unset($_SESSION['change-msg']);
      } ?>
    </p>
    <ul class="list-group list-group-flush">
      <?php foreach ($category as $c) : ?>

        <li class="list-group-item row d-flex align-items-center" id="<?php echo $c[0] ?>">
          <div class="col-10 col-md-6">
            <form action="./scripts/category_change_check.php" method="post" class="mb-0">
              <input type="text" style="width: 60%;" value="<?php echo $c[1] ?>" name="change_name">
              <button type="submit" class="btn btn-success btn-sm">
                done
              </button>
              <input type="hidden" name="change_id" value="<?php echo $c[0] ?>">
            </form>
          </div>
          <div class="col-1 trashBtn">
            <form action="./scripts/category_change_check.php" method="post" class="mb-0">
              <button type="submit">
                <img src="./assets/icon/trash.svg" alt="">
              </button>
              <input type="hidden" name="trash" value="<?php echo $c[0] ?>">
            </form>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <!-- script -->
  <script src="./js/media.js"></script>