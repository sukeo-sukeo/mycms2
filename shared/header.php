<nav class="navbar sticky-top navbar-dark bg-dark">
  <div class="container-fluid">
    <a href="index.php" class="navbar-brand">
      <span class="h2">
        mycms2
      </span>
      <small>
        user: <?php echo $name; ?>
      </small>
    </a>

    <div class="menu d-flex justify-content-center">
      <div class="d-flex justify-content-end">
        <button class="btn btn-dark">
          <a href="./content.php" class="d-flex flex-column align-items-center">
            <img src="./assets/icon/pencil.svg" alt="" width="25">
            <small>記事を書く</small>
          </a>
        </button>
      </div>
      <div class="d-flex justify-content-end">
        <button class="btn btn-dark">
          <a href="./list.php" class="d-flex flex-column align-items-center">
            <img src="./assets/icon/list-check.svg" alt="" width="25">
            <small>記事の管理</small>
          </a>
        </button>
      </div>
      <div class="d-flex justify-content-start">
        <button class="btn btn-dark">
          <a href="./media.php" class="d-flex flex-column align-items-center">
            <img src="./assets/icon/image.svg" alt="" width="25">
            <small>画像の管理</small>
          </a>
        </button>
      </div>
      <div class="d-flex justify-content-end">
        <button class="btn btn-dark">
          <a href="./category.php" class="d-flex flex-column align-items-center">
            <img src="./assets/icon/braces-asterisk.svg" alt="" width="25">
            <small>カテゴリの管理</small>
          </a>
        </button>
      </div>
      <div class="d-flex justify-content-start">
        <button class="btn btn-dark">
          <a href="./tag.php" class="d-flex flex-column align-items-center">
            <img src="./assets/icon/tag.svg" alt="" width="25">
            <small>タグの管理</small>
          </a>
        </button>
      </div>

    </div>

    <button class="btn btn-outline-secondary"><a href="./auth/logout.php" class="text-muted">ログアウト</a></button>
  </div>
</nav>