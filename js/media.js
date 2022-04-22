"use strict";

const copyPaths = document.getElementsByClassName("copyPath");
const trashBtns = document.getElementsByClassName("trashBtn");
const addBtn = document.getElementById("addBtn");

[...copyPaths].forEach((c) => {
  c.addEventListener("click", (e) => {
    const path = e.currentTarget.dataset.path;

    const input = document.createElement("input");
    document.body.appendChild(input);
    input.value = path;
    input.select();
    document.execCommand("copy");
    document.body.removeChild(input);
    
    toast(e.currentTarget, "copied!");
  });
});

[...trashBtns].forEach(t => {
  t.addEventListener("click", e => {
    if (!confirm("削除してよろしいですか?")) {
      e.preventDefault();
      return 
    }
  })
})

const toast = (parent, msg) => {
  const elm = document.createElement("span");
  let opacity = 1;
  elm.textContent = msg;
  elm.style.opacity = opacity;
  elm.style.borderRadius = "3px";
  elm.style.color = "white";
  elm.style.padding = "2px 3px";
  elm.style.backgroundColor = "green";
  parent.appendChild(elm);
  
  const sid = setInterval(() => elm.style.opacity = (opacity -= 1 / 20), 50);
  setTimeout(() => {
    parent.removeChild(elm);
    clearInterval(sid);
  }, 2000);
}

addBtn.addEventListener("click", e => {
  const elm = document.getElementById("val");
  const name = elm.name;
  let val = elm.value;
  console.log(name);
  // 空白の場合の処理はPHPに書いてある
  if (name === 'img' && val !== "") {
    if (val.includes("fakepath")) {
      // fakepathを除去
      val = val.split("\\fakepath\\")[1];
    }
  
    if (val.split(".").length !== 2) {
      alert("ファイル名が不正です");
      e.preventDefault();
      return;
    }
  }
});