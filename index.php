<?php
session_start();

// login check
if (isset($_SESSION['id']) && isset($_SESSION['name'])) {
  $name = $_SESSION['name'];
  $id = $_SESSION['id'];
} else {
  header('Location:  ./auth/login.php');
  exit();
}

?>

<!-- html -->
<?php require_once(__DIR__ . '/shared/head.php'); ?>
<link rel="stylesheet" href="./css/index.css">
</head>

<body>

  <?php require_once(__DIR__ . "/shared/header.php"); ?>

  <div class="container-fluid">

    <div class="row d-flex justify-content-center mt-5">
      <div class="col-9">
        <button class="btn btn-primary w-100">
          <a href="./content.php">
            <img src="./assets/icon/pencil.svg" alt="" width="50">
            <span class="ms-3">記事を書く</span>
          </a>
        </button>
      </div>
    </div>

    <div class="menu d-flex justify-content-center mt-3">
      <div class="row">
        <div class="col-6 d-flex justify-content-end">
          <button class="btn btn-dark w-75">
            <a href="./list.php" class="d-flex flex-column align-items-center">
              <img src="./assets/icon/list-check.svg" alt="">
              <span>記事の管理</span>
            </a>
          </button>
        </div>
        <div class="col-6 d-flex justify-content-start">
          <button class="btn btn-dark w-75">
            <a href="./media.php" class="d-flex flex-column align-items-center">
              <img src="./assets/icon/image.svg" alt="">
              <span>画像の管理</span>
            </a>
          </button>
        </div>
        <div class="col-6 d-flex mt-3 justify-content-end">
          <button class="btn btn-dark w-75">
            <a href="./category.php" class="d-flex flex-column align-items-center">
              <img src="./assets/icon/braces-asterisk.svg" alt="">
              <span>カテゴリの管理</span>
            </a>
          </button>
        </div>
        <div class="col-6 d-flex mt-3 justify-content-start">
          <button class="btn btn-dark w-75">
            <a href="./tag.php" class="d-flex flex-column align-items-center">
              <img src="./assets/icon/tag.svg" alt="">
              <span>タグの管理</span>
            </a>
          </button>
        </div>
      </div>


    </div>

  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <!-- </div> -->