(function() {
    document.addEventListener("DOMContentLoaded", function() {
        var dataElement = document.getElementById("yanws-data");
        var data = JSON.parse(dataElement.getInnerText());

        (function() {
            var shortenEditorRow = document.getElementsByName("shorten_article")[0].parentElement.parentElement;
            var shortenCheckbox = document.getElementById("is_shorten");

            var check = function() {
                //shortenCheckbox.value = shortenCheckbox.checked ? 1 : 0;
                //console.log(shortenCheckbox.value);
                var shortenActive = !!shortenCheckbox.checked;
                if(shortenActive) {
                    shortenEditorRow.style.display = "table-row";
                } else {
                    shortenEditorRow.style.display = "none";
                }
            };

            shortenCheckbox.addEventListener('click', function() {
                check();
            });

            check();
        })();

        (function() {
            var urlInput = document.getElementsByName("url")[0];
            var titleInput = document.getElementsByName("title")[0];
            var exampleOutput = document.getElementById("url-view-helper-url");
            var baseURL = data.url + data.base_route + "/";

            urlInput.addEventListener("keyup", function() {
                showExample();
            });

            titleInput.addEventListener("keyup", function() {
                showExample();
            });

            var customTrim = function(str) {
                return (str.replace(/-*(.*)/gi, '$1')).replace(/\-*$/gi, '');
            };

            var prepareUrl = function(url) {
                var readyUrl =  url.replace(/[^0-9a-z]+/gi, '-').toLowerCase().trim('-');
                return customTrim(readyUrl);
            };

            var showExample = function() {
                if(urlInput.value !== "") {
                    exampleOutput.innerText = baseURL + encodeURI(prepareUrl(urlInput.value));
                } else {
                    exampleOutput.innerText = baseURL +
                    encodeURI(prepareUrl(strtr(titleInput.value.toLowerCase(), convertTable)));
                }
            };
            
            var convertTable = data.convert_table;

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
