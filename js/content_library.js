"use strict";
// contetn_const.jsの後に読み込む

// 公開|非公開ボタンの挙動
const changePublish = (isPublished) => {
  if (isPublished) {
    publishedBtn.value = "true";
    publisedMsg.textContent = "公開";
    publisedMsg.classList.add("bg-dark");
    publisedMsg.classList.remove("bg-light", "text-muted");
  } else {
    publishedBtn.value = "false";
    publisedMsg.textContent = "非公開";
    publisedMsg.classList.add("bg-light", "text-muted");
    publisedMsg.classList.remove("bg-dark");
  }
};

const displayThumnail = () => {
  const idx = thumnailSelect.selectedIndex;
  const path = idx
    ? thumnailSelect.options[idx].dataset.path
    : "./image/sample.png";
  const name = idx ? thumnailSelect.options[idx].textContent : "";
  thumnailPath.textContent = idx ? path : "path to thumnail";
  thumnailSeo.value = name.split(".")[0];
  thumnail.src = path;
};

const togglePreview = () => {
  isPreview = !isPreview; //ローカルストレージに保存しリロード時に活用
  bodyWrapper.classList.toggle("col-6");
  bodyWrapper.classList.toggle("col-12");
  preview.classList.toggle("d-none");
};

const toPreview = () => {
  preview.innerHTML = marked.parse(body.value);
}

const insertBody = (item) => {
  body.value =
    body.value.substr(0, body.selectionStart) +
    item +
    body.value.substr(body.selectionStart);
};

// 値の一時保存
const save = (e) => {
  // e.preventDefault();
  const tags = [];
  const items = [...data].map((d) => {
    if (d.name === "tag[]") {
      if (d.checked) {
        tags.push(d.id);
      }
    } else {
      return [d.name, d.value];
    }
  });

  // メインデータ
  localStorage.setItem("mycms2", JSON.stringify(items));
  // タグデータ
  localStorage.setItem("mycms2-tags", JSON.stringify(tags));
  // サムネイルのパス
  localStorage.setItem("mycms2-path", thumnailPath.textContent);
  // プレビューの開閉状況
  localStorage.setItem("mycms2-isPreview", JSON.stringify(isPreview));
};

const reset = () => {
  localStorage.removeItem("mycms2");
  localStorage.removeItem("mycms2-tags");
  localStorage.removeItem("mycms2-path");
  localStorage.removeItem("mycms2-isPreview");
} 

const displayTag = () => {
  const tags = document.getElementsByClassName("tag");
  const vals = [...tags]
    .filter((tag) => tag.checked)
    .map((tag) => tag.nextElementSibling.textContent);
  tagInputBox.value = vals.toString();
};

// 値のロード
const onLoading = () => {
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
};

// 初期描画等
const init = () => {
  // オートセーブ処理の登録
  const inputs = document.getElementsByTagName("input");
  const textAreas = document.getElementsByTagName("textarea");
  const selects = document.getElementsByTagName("select");
  [...inputs].forEach((i) => i.id !== "uploadBtn" ? i.addEventListener("blur", (e) => save()) : "");
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
}