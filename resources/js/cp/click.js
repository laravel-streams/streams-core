(function (window, document) {

    let hash = document.location.hash;
    let selector = decodeURIComponent(hash.substring(7));

    if (!selector) {
        return;
    }

    let target = document.querySelector(selector);

    if (hash && target && hash.lastIndexOf('#click:', 0) === 0) {
        target.click();
    }

})(window, document);
