"use strict";

const copyPaths = document.getElementsByClassName("copyPath");

[...copyPaths].forEach((c) => {
  c.addEventListener("click", (e) => {
    console.log(e.target);
    const path = e.target.parentElement.dataset.path;
    // li要素だったらキャンセル

    console.log(path);
    const input = document.createElement("input");
    // input.setAttribute("type", "hidden");
    document.body.appendChild(input);
    input.value = path;
    input.select();
    document.execCommand("copy");
    document.body.removeChild(input);
    alert(path + ": copyed!");
  });
});