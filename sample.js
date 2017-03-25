//var id = chrome.contextMenus.create({"title": "gang", "contexts":["all"],"onclick": genericOnClick});
chrome.browserAction.onClicked.addListener(function(tab) { 
    console.log("icon clicked");
    console.log($("html").html());
    chrome.tabs.executeScript(null, { file: "content.js" });

});
