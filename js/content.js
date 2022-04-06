"use strict"

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

