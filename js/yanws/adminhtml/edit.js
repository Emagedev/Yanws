/**
 * Created by skm293504 on 05.06.15.
 */

(function() {
    document.addEventListener("DOMContentLoaded", function(event) {
        var dataElement = document.getElementById("yanws-data");
        var data = JSON.parse(dataElement.getInnerText());

        (function() {
            var shortenEditorRow = document.getElementsByName("shorten_article")[0].parentElement.parentElement;
            var shortenCheckbox = document.getElementById("is_shorten");

            var check = function() {
                var shortenActive = !!shortenCheckbox.checked;
                if(shortenActive) {
                    shortenEditorRow.style.display = "table-row";
                } else {
                    shortenEditorRow.style.display = "none";
                }
            };

            shortenCheckbox.onclick = function() {
                check();
            };

            check();
        })();

        (function() {
            var urlInput = document.getElementsByName("url")[0];
            var titleInput = document.getElementsByName("title")[0];
            var exampleOutput = document.getElementById("url-view-helper-url");
            var baseURL = data.url + "news/index/view/page/";

            titleInput.onkeyup = urlInput.onkeyup = function() {
                showExample();
            };

            var showExample = function() {
                if(urlInput.value !== "") {
                    exampleOutput.innerText = baseURL + encodeURI(urlInput.value);
                } else {
                    exampleOutput.innerText = baseURL + encodeURI(strtr(titleInput.value, convertTable));
                }
            };
            
            var convertTable = data["convert_table"];
            console.log(convertTable);

            var strtr = function (str, replacePairs) {
                var key, re;
                for (key in replacePairs) {
                    if (replacePairs.hasOwnProperty(key)) {
                        re = new RegExp(key, "g");
                        str = str.replace(re, replacePairs[key]);
                    }
                }
                return str;
            };

            showExample();
        })();
    });
})();
