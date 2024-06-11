"use strict";

// -------------------------------------------------------------------------------------------
// Flickity Slider
// -------------------------------------------------------------------------------------------
(function ($) {
  "use strict";

  $.fn.epResponsiveFlickitySlider = function (options) {
    //return if we didnt find anything
    if (!this.length) return this;

    var applyFlickity = function applyFlickity(el, options) {
      return new Flickity(el, options);
    };

    return this.each(function () {
      var thisItem = this;
      var parsedOptions = JSON.parse(thisItem.dataset.epFlickity);
      var parsedOptionsTablet = thisItem.dataset.epFlickityTablet !== undefined ? JSON.parse(thisItem.dataset.epFlickityTablet) : false;
      var parsedOptionsMobile = thisItem.dataset.epFlickityMobile !== undefined ? JSON.parse(thisItem.dataset.epFlickityMobile) : false;
      var thisSlider = applyFlickity(thisItem, parsedOptions);

      if (parsedOptionsTablet) {
        enquire.register("screen and (max-width: 1023px)", {
          match: function match() {
            thisSlider.destroy();
            thisSlider = applyFlickity(thisItem, parsedOptionsTablet);
          },
          unmatch: function unmatch() {
            thisSlider.destroy();
            thisSlider = applyFlickity(thisItem, parsedOptions);
          }
        });
      }

      if (parsedOptionsMobile) {
        enquire.register("screen and (max-width: 767px)", {
          match: function match() {
            thisSlider.destroy();
            thisSlider = applyFlickity(thisItem, parsedOptionsMobile);
          },
          unmatch: function unmatch() {
            thisSlider.destroy();
            thisSlider = applyFlickity(thisItem, parsedOptionsTablet ? parsedOptionsTablet : parsedOptions);
          }
        });
      }
    });
  };
})(jQuery);