// 初期設定
(() => {
  if (localStorage.getItem("mycms2") !== null) {
    const items = JSON.parse(localStorage.getItem("mycms2"));
    const tags = JSON.parse(localStorage.getItem("mycms2-tags"));
    [...data].forEach((d, i) => {
      if (d.name !== "tag[]") {
        d.value = items[i][1];
      } else {
        tags.forEach((tag) => {
          if (tag === d.id) {
            d.checked = true;
          }
        });
      }
    });
  }
})();
