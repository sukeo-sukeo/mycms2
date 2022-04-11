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
$img = db_first_get('img', $db);
var_dump($img);
?>

<!-- html -->
<?php require_once(__DIR__ . "/shared/head.php"); ?>
<!-- css -->
<link rel="stylesheet" href="./css/media.css">
</head>

<body>

  <?php require_once(__DIR__ . "/shared/header.php"); ?>

  <div class="container-fluid">
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