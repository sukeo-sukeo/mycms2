"use strict"

const publishedBtn = document.getElementById("publishedBtn");
const publisedMsg = document.getElementById("publishedMsg");
publishedBtn.addEventListener("click", (e) => {
  const isPublished = e.target.checked;
  if (isPublished) {
    publisedMsg.textContent = "公開";
    publisedMsg.classList.add("bg-dark");
    publisedMsg.classList.remove("bg-light", "text-muted");
  } else {
    publisedMsg.textContent = "非公開";
    publisedMsg.classList.add("bg-light", "text-muted");
    publisedMsg.classList.remove("bg-dark");
  }
});


