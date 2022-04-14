"use strict";
// const.js,library.jsを先に読み込む
  
(() => {
  // オートセーブ処理の登録
  const inputs = document.getElementsByTagName("input");
  const textAreas = document.getElementsByTagName("textarea");
  const selects = document.getElementsByTagName("select");
  [...inputs].forEach((i) => i.addEventListener("blur", (e) => save()));
  [...textAreas].forEach((i) => i.addEventListener("blur", (e) => save()));
  [...selects].forEach((i) => i.addEventListener("change", (e) => save()));

  // タグ描画の連動
  displayTag();
  // サムネイル描画の連動
  displayThumnail();
  // プレビューの開閉の連動
  if (JSON.parse(localStorage.getItem("mycms2-isPreview"))) {
    togglePreview();
  }
  // プレビュー描画の連動
  toPreview();
  // 公開|非公開のボタン表現の連動
  const isPublished = JSON.parse(publishedBtn.value);
  if (!isPublished) {
    publishedBtn.removeAttribute("checked");
  }
  changePublish(isPublished);
})();
// 10秒ごとに自動保存
setInterval(save, 10000);

// アップロード時のバリデーション
uploadBtn.addEventListener("click", (e) => {
  if ([...data].filter(d => d.value === "").length) {
    alert("入力不足があります");
    e.preventDefault();
    return;
  } else {
    if (confirm("アップロードしますか？")) {
      // 自動保存データをクリア
      localStorage.removeItem("mycms2");
      localStorage.removeItem("mycms2-tags");
      localStorage.removeItem("mycms2-path");
      localStorage.removeItem("mycms2-isPreview");
     
      // 万が一DBエラーが出た場合用のバックアップ
      // save();
    } else {
      e.preventDefault();
    }

  }
});

// 素材を追加したときに本文等の値が消えないように保持
addBtnCate.addEventListener("click", e => save(e));
addBtnTag.addEventListener("click", e => save(e));
addBtnImg.addEventListener("click", e => save(e));

// 公開|非公開 切り替え
publishedBtn.addEventListener("click", (e) => {
  const isPublished = e.target.checked;
  changePublish(isPublished);
});

// 選択したタグの表示
tagOkBtn.addEventListener("click", (e) => displayTag());

// 要約のコントロール 
const max = 200;
summaryInputBtn.addEventListener("click", (e) => {
  summary.value = body.value.substring(0, max);
  summaryCount.textContent = `${summary.value.length}/${max}`;
});
summary.addEventListener("change", (e) => {
  summaryCount.textContent = `${e.target.value.length}/${max}`
})

// サムネイルのプレビュー
thumnailSelect.addEventListener("change", e => displayThumnail());

// プレビューの表示
body.addEventListener("keyup", e => toPreview());

// プレビュー表示のオンオフ
previewBtn.addEventListener("click", e => togglePreview());

// マークダウンの制御パネル
// テーブルの挿入
ctl_table.addEventListener("click", e => {
  const yoko = document.getElementById("ctl_yoko");
  const tate = document.getElementById("ctl_tate");
  const y_cnt = yoko.options[yoko.selectedIndex].value;
  const t_cnt = tate.options[tate.selectedIndex].value;

  let table = "|";
  for (let i = 0; i < y_cnt; i++) {
    table += `|`
  }
  table += `\n|`;
  for (let i = 0; i < y_cnt; i++) {
    table += `-|`
  }
  for (let i = 0; i < t_cnt; i++) {
    table += `\n|`;
    for (let n = 0; n < y_cnt; n++) {
      table += `|`
    }
  }

  insertBody(table);
  toPreview();
});

ctl_img.addEventListener("click", e => {
  insertBody("![]()");
  toPreview();
})

ctl_img_select.addEventListener("change", e => {
  const idx = ctl_img_select.selectedIndex;
  const path = idx
    ? ctl_img_select.options[idx].dataset.path
    : "";
  const name = idx ? ctl_img_select.options[idx].textContent : "";
  insertBody(`![${name}](${path})`);
  toPreview();
});