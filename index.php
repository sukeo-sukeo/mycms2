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
    <div class="menu">
      <button>
        <a href="./list.php">
          記事の作成
        </a>
      </button>
      <button>
        <a href="./media.php">
          画像の管理
        </a>
      </button>
      <button>
        <a href="./media.php">
          カテゴリの管理
        </a>
      </button>
      <button>
        <a href="./media.php">
          タグの管理
        </a>
      </button>
    </div>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>
  <!-- </div> -->