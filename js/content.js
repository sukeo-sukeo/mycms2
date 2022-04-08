"use strict"

// 公開|非公開 切り替えボタン
const publishedBtn = document.getElementById("publishedBtn");
const publisedMsg = document.getElementById("publishedMsg");
publishedBtn.addEventListener("click", (e) => {
  const isPublished = e.target.checked;
  if (isPublished) {
    publishedBtn.value = "true"
    publisedMsg.textContent = "公開";
    publisedMsg.classList.add("bg-dark");
    publisedMsg.classList.remove("bg-light", "text-muted");
  } else {
    publishedBtn.value = "false"
    publisedMsg.textContent = "非公開";
    publisedMsg.classList.add("bg-light", "text-muted");
    publisedMsg.classList.remove("bg-dark");
  }
});

// アップロードボタン押下時のvalidation
const uploadBtn = document.getElementById("uploadBtn");
uploadBtn.addEventListener("click", (e) => {
  const data = document.getElementsByClassName("blog-data");
  if (![...data].filter(d => d.value === "").length) {
    alert("入力不足があります");
    e.preventDefault();
    return;
  }
})

// 選択したタグの表示
const tagOkBtn = document.getElementById("tagOkBtn");
const tagInputBox = document.getElementById("tagInputBox");
tagOkBtn.addEventListener("click", (e) => {
  const tags = document.getElementsByClassName("tag");
  const vals = [...tags].filter(tag => tag.checked).map(tag => tag.id);
  tagInputBox.value = vals.toString();
})

// 要約のコントロール
const summaryInputBtn = document.getElementById("summaryInputBtn");
const body = document.getElementById("body");
const summary = document.getElementById("summary");
const summaryCount = document.getElementById("summaryCount"); 
const max = 200;
summaryInputBtn.addEventListener("click", (e) => {
  summary.value = body.value.substring(0, max);
  summaryCount.textContent = `${summary.value.length}/${max}`;
});
summary.addEventListener("change", (e) => {
  summaryCount.textContent = `${e.target.value.length}/${max}`
})

const thumnailSelect = document.getElementById("thumnailSelect");
const thumnailPath = document.getElementById("thumnailPath");
const thumnail = document.getElementById("thumnail");

thumnailSelect.addEventListener("change", e => {;
  const idx = thumnailSelect.selectedIndex;
  const path = idx ? thumnailSelect.options[idx].id : "./image/sample.png";
  thumnailPath.textContent = idx ? path : "path to thumnail";
  thumnail.src = path
})
