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
$img = db_first_get('img', $db);

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
      <span class="h3 col-3">画像の管理</span>
      <form action="./scripts/item_add_check.php" method="POST" class="col d-flex" enctype="multipart/form-data">
        <div class="col">
          <span class="form-label"></span>
          <input class="form-control" type="file" name="img">
        </div>
        <div class="col ms-2">
          <input type="submit" value="画像をアップロード" class="btn btn-secondary" id="addBtnImg">
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
      <?php foreach ($img as $i) : ?>

        <li class="list-group-item row d-flex align-items-center" id="<?php echo $i[0] ?>">
          <div class="col">
            <img src="<?php echo $i[2] ?>" class="img-thumbnail">
          </div>
          <div class="col-4">
            <form action="./scripts/media_change_check.php" method="post" class="mb-0">
              <input type="text" style="width: 60%;" value="<?php echo explode('.', $i[1])[0] ?>" name="change_name">
              <span><?php echo '.' . explode('.', $i[1])[1] ?></span>
              <button type="submit" class="btn btn-success btn-sm">
                done
              </button>
              <input type="hidden" name="change_id" value="<?php echo $i[0] ?>">
              <input type="hidden" name="ext" value="<?php echo '.' . explode('.', $i[1])[1] ?>">
            </form>
          </div>
          <div class="col-2 copyPath" data-path="<?php echo $i[2] ?>">
            <img src="./assets/icon/link-45deg.svg" alt="">
            <span class="text-muted">copy</span>
          </div>
          <div class="col-3">
            <span class="text-muted">
              <img src="./assets/icon/alarm.svg" alt="">
              created <?php echo explode(" ", $i[3])[0]; ?></div>
          </span>
          <div class="col-1 trashBtn">
            <form action="./scripts/media_change_check.php" method="post" class="mb-0">
              <button type="submit">
                <img src="./assets/icon/trash.svg" alt="">
              </button>
              <input type="hidden" name="trash" value="<?php echo $i[0] ?>">
            </form>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <!-- script -->
  <script src="./js/media.js"></script>