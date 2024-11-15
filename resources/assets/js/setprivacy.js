var cookiesPolicy = {
    popupTitle: "GDPR COOKIE POLICY",
    cookieGeneral: "blog.alessandrostella.it",
    cookieCheckPref: "preferences",
    cookieCheckStat: "statistics",
    cookieCheckMark: "marketing",
    urlCookiePolicy: "http://blog.alessandrostella.it/cookie-policy/",
    colorOfButton: "#007bce",
    cookieExpiresDays: 30,
    prefCheckValue: "checked",
    statCheckValue: "checked",
    markCheckValue: "checked",
    cookieValue: "0",
    showPopup: false,
    popup: null, 
  
    start: function() {
        window.addEventListener("load", cookiesPolicy.onLoad, false);
    },
    onLoad: function() {
        cookiesPolicy.getCookie();
        cookiesPolicy.createPopup();
    },
    getCookie: function() {
        var nameOfGeneral = cookiesPolicy.cookieGeneral+ "=";
        var nameOfPreferences = cookiesPolicy.cookieCheckPref+ "=";
        var nameOfStatistics = cookiesPolicy.cookieCheckStat+ "=";
        var nameOfMarketing = cookiesPolicy.cookieCheckMark+ "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for (var i = 0; i <ca.length; i++) {
            var c = ca[i];
                while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                }
                if (c.indexOf(nameOfGeneral) == 0) {
                    cookiesPolicy.cookieValue = c.substring(nameOfGeneral.length, c.length);
                }
                if (c.indexOf(nameOfPreferences) == 0) {
                    cookiesPolicy.prefCheckValue = c.substring(nameOfPreferences.length, c.length);
                }
                if (c.indexOf(nameOfStatistics) == 0) {
                    cookiesPolicy.statCheckValue = c.substring(nameOfStatistics.length, c.length);
                }
                if (c.indexOf(nameOfMarketing) == 0) {
                    cookiesPolicy.markCheckValue = c.substring(nameOfMarketing.length, c.length);
                }
        }
        return "";
    },
    createPopup: function() {
        cookiesPolicy.popup = document.createElement("div");
        var cssElement = document.createElement("style");
        cookiesPolicy.popup.id = "cookiePopup";
        cookiesPolicy.popup.innerHTML = cookiesPolicy.loadPopupContent();
        cssElement.innerHTML = cookiesPolicy.loadCSS();        
        var element = document.getElementsByTagName("body")[0];
        element.appendChild(cookiesPolicy.popup);
        element.appendChild(cssElement);
        if (window.location.href===cookiesPolicy.urlCookiePolicy) {
            cookiesPolicy.popup.style.display="none";
            if (cookiesPolicy.cookieValue==="1") {
                cookiesPolicy.loadScript();
            }
        } else if (cookiesPolicy.cookieValue==="1") {
            cookiesPolicy.popup.style.display="none"; 
            cookiesPolicy.loadScript();
        }
    },
    loadPopupContent: function() {
        var checkForPref = "<input type=\"checkbox\" name=\"preferences\" value=\"preferences\" " + cookiesPolicy.prefCheckValue + "><span class=\"checkboxtext\">Preferenze</span>";
        var checkForStat = "<input type=\"checkbox\" name=\"statistics\" value=\"statistics\" " + cookiesPolicy.statCheckValue + "><span class=\"checkboxtext\">Statistiche</span>";
        var checkForMark = "<input type=\"checkbox\" name=\"marketing\" value=\"marketing\" " + cookiesPolicy.markCheckValue + "><span class=\"checkboxtext\">Marketing</span>";
        var allPrefScript = document.querySelectorAll("script[data-starcookie=\"preferences\"]"); 
        if (allPrefScript.length===0) {
            checkForPref = "";
        }
        var allStatScript = document.querySelectorAll("script[data-starcookie=\"statistics\"]"); 
        if (allStatScript.length===0) {
            checkForStat = "";
        }
        var allMarkScript = document.querySelectorAll("script[data-starcookie=\"marketing\"]"); 
        if (allMarkScript.length===0) {
            checkForMark = "";
        }
        var htmlCode = "<div id=\"cookieBox\">" + 
                            "<h3>"+cookiesPolicy.popupTitle+"</h3>" + 
                            "<hr> " + 
                            "<p>Per poter gestire al meglio la tua navigazione su questo sito " + 
                            "verranno temporaneamente memorizzate alcune informazioni in piccoli file di testo denominati <strong>cookie</strong>.<br> " + 
                            "È molto importante che tu sia informato e che accetti la politica sulla privacy e sui cookie di questo sito Web. " + 
                            "Per ulteriori informazioni, leggi la nostra politica sulla privacy e sui cookie.</p>" + 
                            "<p><a href=\""+cookiesPolicy.urlCookiePolicy+"\" title=\"Leggi la Policy\">Politica sulla privacy e sui cookie</a></p>" + 
                            "<div id=\"checkboxContainer\"> " + 
                                "<div class=\"singleCheckBox\"><input type=\"checkbox\" name=\"necesse\" value=\"necesse\" checked disabled><span class=\"checkboxtext\">Cookie necessari</span></div> " + 
                                "<div class=\"singleCheckBox\">" + checkForPref + "</div>" + 
                                "<div class=\"singleCheckBox\">" + checkForStat + "</div>" + 
                                "<div class=\"singleCheckBox\">" + checkForMark + "</div>" + 
                            "</div>" + 
                            "<button onClick=\"cookiesPolicy.loadScript()\">OK, HO CAPITO E ACCETTO</button>" + 
                        "</div>";
        return htmlCode;
    },
    loadCSS: function() {
        var style = "#cookiePopup {" +
                        "font-family: sans-serif; " + 
                        "position: fixed; " + 
                        "z-index: 110; " + 
                        "left: 0; " + 
                        "top: 0; " + 
                        "height: 100vh; " + 
                        "width: 100%; " + 
                        "padding-top: 15vh; " + 
                        "color: #ddd;" +                         
                        "background-color: rgba(0,0,0,0.6);" + 
                        "} " + 
                    "#cookiePopup #cookieBox {" + 
                        "width: 90%; " + 
                        "max-width: 640px; " + 
                        "margin: 0 auto; " + 
                        "border: 2px solid white; " + 
                        "box-shadow: 2px 2px 5px #000;" + 
                        "padding: 25px; " + 
                        "background-color: #222;" + 
                    "} " + 
                    "#cookiePopup #cookieBox h3 {" + 
                        "color: #ddd; " + 
                        "font-size: 22px; " + 
                        "line-height: 22px; " + 
                        "font-weight: bold; " + 
                        "margin-top: 0; " + 
                        "margin-bottom: 0; " + 
                    "} " + 
                    "#cookiePopup #cookieBox hr {" + 
                        "background-color: #ddd; " + 
                        "width: 250px; " + 
                        "margin-top: 0; " + 
                        "margin-left: 0; " + 
                    "} " + 
                    "#cookiePopup #cookieBox p {" + 
                        "font-size: 12px; " + 
                        "text-align: justify; " + 
                        "line-height: 13px; " + 
                        "font-family: sans-serif; " +
                    "} " + 
                    "#cookiePopup #cookieBox p:nth-child(3) {" + 
                        "padding: 1rem 0; " +                     
                    "} " +                                         
                    "#cookiePopup #cookieBox a {" + 
                        "color: #fff; " + 
                    "} " + 
                    "#cookiePopup #cookieBox #checkboxContainer {" + 
                        "padding: 25px 10px; " + 
                    "} " + 
                    "#cookiePopup #cookieBox #checkboxContainer div.singleCheckBox{" + 
                        "display: inline-block; " + 
                    "} " + 
                    "#cookiePopup #cookieBox #checkboxContainer input[type=checkbox] {" + 
                        "-ms-transform: scale(1.5); " + 
                        "-moz-transform: scale(1.5); " + 
                        "-webkit-transform: scale(1.5); " + 
                        "-o-transform: scale(1.5); " + 
                        "padding: 10px; " + 
                        "margin-left: 15px; " + 
                        "width: auto; " + 
                        "cursor: pointer; " + 
                    "} " + 
                    "#cookiePopup #cookieBox #checkboxContainer .checkboxtext {" + 
                        "margin-left: 5px; " + 
                        "display: inline; " + 
                    "} " +                     
                    "#cookiePopup #cookieBox button {" + 
                        "background-color: " + cookiesPolicy.colorOfButton + "; " + 
                        "color: #fff; " + 
                        "font-size: 14px; " + 
                        "line-height: 14px; " + 
                        "border: thin solid white; " + 
                        "padding: 10px 20px; " + 
                        "cursor: pointer; " + 
                    "} " + 
                    "#cookiePopup #cookieBox button:hover {" + 
                        "color: " + cookiesPolicy.colorOfButton + " !important; " + 
                        "background-color: white;" + 
                    "} " + 
                    "@media screen and (max-width:768px) { " + 
                        "#cookiePopup {" +
                            "padding-top: 8vh; " + 
                        "} " + 
                        "#cookiePopup #cookieBox #checkboxContainer div.singleCheckBox{" + 
                            "display: block; " + 
                            "padding: 5px 0; " + 
                        "} " + 
                    "} ";
        return style;
    },
    loadScript: function() {
        var d = new Date();
        d.setTime(d.getTime() + (cookiesPolicy.cookieExpiresDays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        var popupIsVisible = (cookiesPolicy.popup.style.display==="block" || cookiesPolicy.popup.style.display ==="");
        if (popupIsVisible) {
            document.cookie = cookiesPolicy.cookieGeneral + "=1;" + expires + ";path=/";
        }
 
        if (document.querySelector("input[name=\"preferences\"]")!=null) {
            if (document.querySelector("input[name=\"preferences\"]").checked) {
                var allPrefScript = document.querySelectorAll("script[data-starcookie=\"preferences\"]"); 
                for (var i = 0; i < allPrefScript.length; i++) {
                    allPrefScript[i].setAttribute("type","text/javascript");
                    try {
                        eval(allPrefScript[i].text);
                    } catch (err) {
                        //doNothing
                    }
                }
                if (popupIsVisible) {
                    cookiesPolicy.prefCheckValue = "checked";
                    document.cookie = cookiesPolicy.cookieCheckPref + "=" + cookiesPolicy.prefCheckValue + ";" + expires + ";path=/";
                }
            } else if (popupIsVisible) {
                    cookiesPolicy.prefCheckValue = "";
                    document.cookie = cookiesPolicy.cookieCheckPref + "=" + cookiesPolicy.prefCheckValue + ";" + expires + ";path=/";
            }
        }
        if (document.querySelector("input[name=\"statistics\"]")!=null) {
            if (document.querySelector("input[name=\"statistics\"]").checked) {
                var allStatScript = document.querySelectorAll("script[data-starcookie=\"statistics\"]");
                for (var i = 0; i < allStatScript.length; i++) {
                    allStatScript[i].setAttribute("type","text/javascript");
                    try {
                        eval(allStatScript[i].text);
                    } catch (err) {
                        //doNothing
                    }
                }
                if (popupIsVisible) {
                    cookiesPolicy.statCheckValue = "checked";
                    document.cookie = cookiesPolicy.cookieCheckStat + "=" + cookiesPolicy.statCheckValue + ";" + expires + ";path=/";
                }
            } else if (popupIsVisible) {
                cookiesPolicy.statCheckValue = "";
                document.cookie = cookiesPolicy.cookieCheckStat + "=" + cookiesPolicy.statCheckValue + ";" + expires + ";path=/";
            }
        }
        if (document.querySelector("input[name=\"marketing\"]")!=null) {
            if (document.querySelector("input[name=\"marketing\"]").checked) {
                var allMarkScript = document.querySelectorAll("script[data-starcookie=\"marketing\"]");
                for (var i = 0; i < allMarkScript.length; i++) {
                    allMarkScript[i].setAttribute("type","text/javascript");
                    try {
                        eval(allMarkScript[i].text);
                    } catch (err) {
                        //doNothing
                    }
                }
                if (popupIsVisible) {
                    cookiesPolicy.markCheckValue = "checked";
                    document.cookie = cookiesPolicy.cookieCheckMark + "=" + cookiesPolicy.markCheckValue + ";" + expires + ";path=/"; 
                }
            } else if (popupIsVisible) {
                cookiesPolicy.markCheckValue = "";
                document.cookie = cookiesPolicy.cookieCheckMark + "=" + cookiesPolicy.markCheckValue + ";" + expires + ";path=/"; 
            }
        }
        if (popupIsVisible) {
            cookiesPolicy.popup.style.display="none";
        }
    },
    showPopup: function() {
        cookiesPolicy.popup.style.display="block"; 
    }
};
cookiesPolicy.start();
