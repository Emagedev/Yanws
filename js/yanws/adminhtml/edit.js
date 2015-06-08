/**
 * Created by skm293504 on 05.06.15.
 */

(function() {
    document.addEventListener("DOMContentLoaded", function(event) {
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
            var baseURL = location.protocol + "//" + location.hostname + "/index.php/news/index/view/page/";

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
            
            var convertTable = {
                "&amp;": "and",   "@": "at",    "©": "c", "®": "r", "À": "a",
                "Á": "a", "Â": "a", "Ä": "a", "Å": "a", "Æ": "ae","Ç": "c",
                "È": "e", "É": "e", "Ë": "e", "Ì": "i", "Í": "i", "Î": "i",
                "Ï": "i", "Ò": "o", "Ó": "o", "Ô": "o", "Õ": "o", "Ö": "o",
                "Ø": "o", "Ù": "u", "Ú": "u", "Û": "u", "Ü": "u", "Ý": "y",
                "ß": "ss","à": "a", "á": "a", "â": "a", "ä": "a", "å": "a",
                "æ": "ae","ç": "c", "è": "e", "é": "e", "ê": "e", "ë": "e",
                "ì": "i", "í": "i", "î": "i", "ï": "i", "ò": "o", "ó": "o",
                "ô": "o", "õ": "o", "ö": "o", "ø": "o", "ù": "u", "ú": "u",
                "û": "u", "ü": "u", "ý": "y", "þ": "p", "ÿ": "y", "Ā": "a",
                "ā": "a", "Ă": "a", "ă": "a", "Ą": "a", "ą": "a", "Ć": "c",
                "ć": "c", "Ĉ": "c", "ĉ": "c", "Ċ": "c", "ċ": "c", "Č": "c",
                "č": "c", "Ď": "d", "ď": "d", "Đ": "d", "đ": "d", "Ē": "e",
                "ē": "e", "Ĕ": "e", "ĕ": "e", "Ė": "e", "ė": "e", "Ę": "e",
                "ę": "e", "Ě": "e", "ě": "e", "Ĝ": "g", "ĝ": "g", "Ğ": "g",
                "ğ": "g", "Ġ": "g", "ġ": "g", "Ģ": "g", "ģ": "g", "Ĥ": "h",
                "ĥ": "h", "Ħ": "h", "ħ": "h", "Ĩ": "i", "ĩ": "i", "Ī": "i",
                "ī": "i", "Ĭ": "i", "ĭ": "i", "Į": "i", "į": "i", "İ": "i",
                "ı": "i", "Ĳ": "ij","ĳ": "ij","Ĵ": "j", "ĵ": "j", "Ķ": "k",
                "ķ": "k", "ĸ": "k", "Ĺ": "l", "ĺ": "l", "Ļ": "l", "ļ": "l",
                "Ľ": "l", "ľ": "l", "Ŀ": "l", "ŀ": "l", "Ł": "l", "ł": "l",
                "Ń": "n", "ń": "n", "Ņ": "n", "ņ": "n", "Ň": "n", "ň": "n",
                "ŉ": "n", "Ŋ": "n", "ŋ": "n", "Ō": "o", "ō": "o", "Ŏ": "o",
                "ŏ": "o", "Ő": "o", "ő": "o", "Œ": "oe","œ": "oe","Ŕ": "r",
                "ŕ": "r", "Ŗ": "r", "ŗ": "r", "Ř": "r", "ř": "r", "Ś": "s",
                "ś": "s", "Ŝ": "s", "ŝ": "s", "Ş": "s", "ş": "s", "Š": "s",
                "š": "s", "Ţ": "t", "ţ": "t", "Ť": "t", "ť": "t", "Ŧ": "t",
                "ŧ": "t", "Ũ": "u", "ũ": "u", "Ū": "u", "ū": "u", "Ŭ": "u",
                "ŭ": "u", "Ů": "u", "ů": "u", "Ű": "u", "ű": "u", "Ų": "u",
                "ų": "u", "Ŵ": "w", "ŵ": "w", "Ŷ": "y", "ŷ": "y", "Ÿ": "y",
                "Ź": "z", "ź": "z", "Ż": "z", "ż": "z", "Ž": "z", "ž": "z",
                "ſ": "z", "Ə": "e", "ƒ": "f", "Ơ": "o", "ơ": "o", "Ư": "u",
                "ư": "u", "Ǎ": "a", "ǎ": "a", "Ǐ": "i", "ǐ": "i", "Ǒ": "o",
                "ǒ": "o", "Ǔ": "u", "ǔ": "u", "Ǖ": "u", "ǖ": "u", "Ǘ": "u",
                "ǘ": "u", "Ǚ": "u", "ǚ": "u", "Ǜ": "u", "ǜ": "u", "Ǻ": "a",
                "ǻ": "a", "Ǽ": "ae","ǽ": "ae","Ǿ": "o", "ǿ": "o", "ə": "e",
                "Ё": "jo","Є": "e", "І": "i", "Ї": "i", "А": "a", "Б": "b",
                "В": "v", "Г": "g", "Д": "d", "Е": "e", "Ж": "zh","З": "z",
                "И": "i", "Й": "j", "К": "k", "Л": "l", "М": "m", "Н": "n",
                "О": "o", "П": "p", "Р": "r", "С": "s", "Т": "t", "У": "u",
                "Ф": "f", "Х": "h", "Ц": "c", "Ч": "ch","Ш": "sh","Щ": "sch",
                "Ъ": "-", "Ы": "y", "Ь": "-", "Э": "je","Ю": "ju","Я": "ja",
                "а": "a", "б": "b", "в": "v", "г": "g", "д": "d", "е": "e",
                "ж": "zh","з": "z", "и": "i", "й": "j", "к": "k", "л": "l",
                "м": "m", "н": "n", "о": "o", "п": "p", "р": "r", "с": "s",
                "т": "t", "у": "u", "ф": "f", "х": "h", "ц": "c", "ч": "ch",
                "ш": "sh","щ": "sch","ъ": "-","ы": "y", "ь": "-", "э": "je",
                "ю": "ju","я": "ja","ё": "jo","є": "e", "і": "i", "ї": "i",
                "Ґ": "g", "ґ": "g", "א": "a", "ב": "b", "ג": "g", "ד": "d",
                "ה": "h", "ו": "v", "ז": "z", "ח": "h", "ט": "t", "י": "i",
                "ך": "k", "כ": "k", "ל": "l", "ם": "m", "מ": "m", "ן": "n",
                "נ": "n", "ס": "s", "ע": "e", "ף": "p", "פ": "p", "ץ": "C",
                "צ": "c", "ק": "q", "ר": "r", "ש": "w", "ת": "t", "™": "tm"
            };

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
