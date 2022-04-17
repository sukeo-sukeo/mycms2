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

$db = dbconnect();

// 表示の絞り込み
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['all'])) {
    header('Location: ./list.php');
    exit();
  }
  if (isset($_POST['un_published'])) {
    $blogs = db_first_get('blog', $db, '', 'un_published');
  }
  if (isset($_POST['published'])) {
    $blogs = db_first_get('blog', $db, '',  'published');
  }
  if (isset($_POST['category'])) {
    $cate_id = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_NUMBER_INT);
    $blogs = db_first_get('blog', $db, $cate_id, 'category');
  }
} else {
  // 一覧を取得
  $blogs = db_first_get('blog', $db);
}

$categorys = db_first_get('category', $db);
$tags = db_first_get('tag', $db);

// var_dump($blogs);
// exit();
// 
?>

<!-- html -->
<?php require_once(__DIR__ . "/shared/head.php"); ?>
<link rel="stylesheet" href="./css/list.css">
</head>

<body>
  <?php require_once(__DIR__ . "/shared/header.php"); ?>

  <div class="container-fluid">

    <div class="row ms-1">
      <button class="btn btn-primary mt-2" style="width: fit-content;">
        <a href="content.php">
          新規作成
        </a>
      </button>
    </div>
    <div class="d-flex row mt-2">
      <div class="col-4 d-flex">
        <form action="" method="post" class="mb-0">
          <button class="btn btn-secondary" name="all">全て</button>
        </form>
        <form action="" method="post" class="mx-1 mb-0">
          <button class="btn btn-secondary" type="submit" name="un_published">非公開</button>
        </form>
        <form action="" method="post" class="mb-0">
          <button class="btn btn-secondary" type="submit" name="published">公開中</button>
        </form>
      </div>
      <form action="" method="post" class="mb-0 input-group col">
        <span class="input-group-text">カテゴリ</span>
        <select class="form-select" name="category">
          <option value="" selected>カテゴリ検索</option>
          <?php foreach ($categorys as $c) : ?>
            <option value="<?php echo $c[0] ?>"><?php echo $c[1] ?></option>
          <?php endforeach; ?>
        </select>
        <button class="btn btn-success" type="submit"><img src="./assets/icon/search.svg" alt=""></button>
      </form>

      <div class="col-3"></div>
    
    </div>

    <div class="container-fluid">
      <ul class="list-group list-group-flush">
        <?php foreach ($blogs as $b) : ?>

          <li class="list-group-item row d-flex align-items-center" id="<?php echo $b[0] ?>">
            <div class="col">
              <a href="./media.php?id=<?php echo $b[4] ?>">
                <img src="<?php echo $b[5] ?>" class="img-thumbnail">
              </a>
            </div>
            <a href="./content.php?id=<?php echo $b[0] ?>" class="col-6">
              <?php echo $b[1] ?>
              <input type="hidden" name="published" value="<?php echo $b[2] ?>">
            </a>
            <div class="col-3">
              <span class="text-muted">
                <?php if ($b[2] === "true") : ?>
                  <img src="./assets/icon/bookmark-check.svg" alt="">
                <?php else : ?>
                  <img src="./assets/icon/bookmark-check-current.svg" alt="">
                <?php endif; ?>
                <?php echo explode(" ", $b[3])[0]; ?>
              </span>
            </div>
            <div class="col-1 trashBtn">
              <form action="./scripts/blog_change_check.php" method="post" class="mb-0">
                <button type="submit">
                  <img src="./assets/icon/trash.svg" alt="">
                </button>
                <input type="hidden" name="trash" value="<?php echo $b[0] ?>">
              </form>
            </div>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
  <?php require_once(__DIR__ . "/shared/footer.php"); ?>