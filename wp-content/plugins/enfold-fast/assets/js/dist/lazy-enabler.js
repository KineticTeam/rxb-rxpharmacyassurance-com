(function(){

    /* jQuery els */
    const jQueryEls = document.querySelectorAll(".ep-posts-load-more, .ep-item-grid-paged, .av-countdown-timer, .tabcontainer, .togglecontainer, .av_gmaps_main_wrap");
    Array.prototype.forEach.call(jQueryEls, function (el) {
        if(!el.dataset.lazyDep) el.dataset.lazyDep = "/wp-includes/js/jquery/jquery.js";
        if(!el.dataset.lazyDepObj) el.dataset.lazyDepObj = "window.jQuery";
    });

    const loadJquery = document.querySelectorAll(".load-jquery");
    Array.prototype.forEach.call(loadJquery, function (el) {
        if(!el.dataset.lazy) el.dataset.lazy = "/wp-includes/js/jquery/jquery.js";
    });

    const pg = document.querySelectorAll(".ep-posts-load-more");
    Array.prototype.forEach.call(pg, function (el) {
        if(!el.dataset.lazy) el.dataset.lazy = "/wp-content/plugins/enfold-fast/assets/js/dist/posts-grid.js";
    });

    const ig = document.querySelectorAll(".ep-item-grid-paged");
    Array.prototype.forEach.call(ig, function (el) {
        if(!el.dataset.lazy) el.dataset.lazy = "/wp-content/plugins/enfold-fast/assets/js/dist/item-grid.js";
    });

    const maps = document.querySelectorAll(".av_gmaps_main_wrap");
    Array.prototype.forEach.call(maps, function (el) {
        if(!el.dataset.lazy) el.dataset.lazy = "/wp-content/plugins/enfold-fast/assets/js/dist/avia/map-combo.js";
    });

    const animCountDowns = document.querySelectorAll(".av-countdown-timer");
    Array.prototype.forEach.call(animCountDowns, function (el) {
        if(!el.dataset.lazy) el.dataset.lazy = "/wp-content/plugins/enfold-fast/assets/js/dist/avia/countdown.js";
    });

    const tabs = document.querySelectorAll(".tabcontainer");
    Array.prototype.forEach.call(tabs, function (el) {
        if(!el.dataset.lazy) el.dataset.lazy = "/wp-content/plugins/enfold-fast/assets/js/dist/avia/tabs.js";
    });

    const toggles = document.querySelectorAll(".togglecontainer");
    Array.prototype.forEach.call(toggles, function (el) {
        if(!el.dataset.lazy) el.dataset.lazy = "/wp-content/plugins/enfold-fast/assets/js/dist/avia/toggles.js";
    });

})();