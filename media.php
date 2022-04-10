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
            <input type="text" class="w-75" value="<?php echo explode('.', $i[1])[0] ?>">
            <span><?php echo '.' . explode('.', $i[1])[1] ?></span>
          </div>
          <div class="col-1">copy path</div>
          <div class="col-3">created <?php echo explode(" ", $i[3])[0]; ?></div>
          <div class="col-1">削除</div>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <!-- script -->