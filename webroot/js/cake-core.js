(function () {
    var postLinkFunction = function () {
        var elements = document.getElementsByClassName('cake-core-postLink');

        var postLinkFunction = function (event) {
            var formName = this.getAttribute("data-cake-core-form");
            var confirmMessage = this.getAttribute('data-cake-core-confirm');
            if (confirmMessage !== null && confirmMessage !== 'undefined') {
                if (confirm(confirmMessage)) {
                    document[formName].submit();
                    return false;
                }
                return true;
            }
            document[formName].submit();
            event.returnValue = false;
            event.preventDefault();
            return false;
        };

        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];
            element.onclick = postLinkFunction;
        }
    };


    function bindReady(handler) {

        var called = false;

        function ready() {
            if (called) return;
            called = true;
            handler()
        }

        if (document.addEventListener) { // native event
            document.addEventListener("DOMContentLoaded", ready, false);
        } else if (document.attachEvent) {  // IE

            try {
                var isFrame = window.frameElement != null
            } catch (e) {
            }

            // IE, the document is not inside a frame
            if (document.documentElement.doScroll && !isFrame) {
                function tryScroll() {
                    if (called) return;
                    try {
                        document.documentElement.doScroll("left");
                        ready();
                    } catch (e) {
                        setTimeout(tryScroll, 10);
                    }
                }

                tryScroll();
            }

            // IE, the document is inside a frame
            document.attachEvent("onreadystatechange", function () {
                if (document.readyState === "complete") {
                    ready();
                }
            })
        }

        // Old browsers
        else if (window.addEventListener)
            window.addEventListener('load', ready, false);
        else if (window.attachEvent)
            window.attachEvent('onload', ready);
        else {
            var fn = window.onload; // very old browser, copy old onload
            window.onload = function () { // replace by new onload and call the old one
                fn && fn();
                ready();
            }
        }
    }

    var readyList = [];

    function onReady(handler) {
        if (handler == undefined || handler == null) return;

        function executeHandlers() {
            for (var i = 0; i < readyList.length; i++) {
                var elem = readyList[i];
                if (elem == null || elem == undefined) continue;
                elem();
            }
        }

        if (!readyList.length) { // set handler on first run
            bindReady(executeHandlers);
        }

        readyList.push(handler);
    }

    onReady(postLinkFunction);
}());
