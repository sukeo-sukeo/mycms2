"use strict";

// marked設定
marked.setOptions({
  // 改行を反映
  breaks: true,
  // code要素にdefaultで付くlangage-を削除
  langPrefix: "",
  // highlightjsを使用したハイライト処理を追加
  highlight: function (code, lang) {
    return hljs.highlightAuto(code, [lang]).value;
  },
});
