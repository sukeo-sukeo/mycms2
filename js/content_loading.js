// ローカルストレージに保存データがあれば読み込み
(() => {
  if (localStorage.getItem("mycms2") !== null) {
    onLoading();
  }
})();
