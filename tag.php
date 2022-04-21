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

// dbからアイテム読み込み
$db = dbconnect();
$tag = db_first_get('tag', $db);

?>

<!-- html -->
<?php require_once(__DIR__ . "/shared/head.php"); ?>
<!-- css -->
<link rel="stylesheet" href="./css/media.css">
</head>

<body>

  <?php require_once(__DIR__ . "/shared/header.php"); ?>

  <div class="container-fluid">
    <h2 class="mt-3">タグの管理</h2>
    <p style="height: 24px;">
      <?php if (isset($_SESSION['change-msg'])) {
        echo $_SESSION['change-msg'];
        unset($_SESSION['change-msg']);
      } ?>
    </p>
    <ul class="list-group list-group-flush">
      <?php foreach ($tag as $t) : ?>

        <li class="list-group-item row d-flex align-items-center" id="<?php echo $t[0] ?>">
          <div class="col-10 col-md-6">
            <form action="./scripts/tag_change_check.php" method="post" class="mb-0">
              <input type="text" style="width: 60%;" value="<?php echo $t[1] ?>" name="change_name">
              <button type="submit" class="btn btn-success btn-sm">
                done
              </button>
              <input type="hidden" name="change_id" value="<?php echo $t[0] ?>">
            </form>
          </div>
          <div class="col-1 trashBtn">
            <form action="./scripts/tag_change_check.php" method="post" class="mb-0">
              <button type="submit">
                <img src="./assets/icon/trash.svg" alt="">
              </button>
              <input type="hidden" name="trash" value="<?php echo $t[0] ?>">
            </form>
          </div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <!-- script -->
  <script src="./js/media.js"></script>