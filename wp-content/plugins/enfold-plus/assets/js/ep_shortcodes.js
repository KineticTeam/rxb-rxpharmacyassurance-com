"use strict";

(function ($) {
  $(document).ready(function () {
    if ($.fn.epPostsGrid) $('.ep-posts-load-more').epPostsGrid();
    if ($.fn.epResponsiveFlickitySlider) $('.ep-flickity-slider[data-ep-flickity]').epResponsiveFlickitySlider();
    if ($.fn.epItemGrid) $('.ep-item-grid-paged').epItemGrid();
  });
})(jQuery);