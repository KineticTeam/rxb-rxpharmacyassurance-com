"use strict";

// -------------------------------------------------------------------------------------------
// Logo Grid
// -------------------------------------------------------------------------------------------
(function ($) {
  "use strict";

  $.fn.epItemGrid = function (options) {
    //return if we didnt find anything
    if (!this.length) return this;
    return this.each(function () {
      var thisGrid = $(this);
      var thisGridInner = $(this).find(".ep-item-grid");
      var elementsToPaginate = parseInt($(this).data("pages"));
      var loadMoreBtn = thisGrid.find(".ep-item-grid-load-more");
      var thisGridPosition = thisGridInner.offset().top;
      thisGrid.find(".ep-item-grid-item").slice(0, elementsToPaginate).addClass("is-shown");
      loadMoreBtn.click(function () {
        thisGrid.find(".ep-item-grid-item:not(.is-shown)").slice(0, elementsToPaginate).addClass("is-shown");

        if (thisGrid.find(".ep-item-grid-item:not(.is-shown)").length == 0) {
          loadMoreBtn.addClass("ep-no-more-items");
        }

        $('html:not(:animated),body:not(:animated)').animate({
          scrollTop: thisGridPosition + thisGridInner.height() / 2
        });
      });
    });
  };
})(jQuery);