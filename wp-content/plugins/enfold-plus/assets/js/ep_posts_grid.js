"use strict";

// -------------------------------------------------------------------------------------------
// Post Grid
// -------------------------------------------------------------------------------------------
(function ($) {
  "use strict";

  $.fn.epPostsGrid = function (options) {
    //return if we didnt find anything
    if (!this.length) return this;
    var methods = {
      show_bricks: function show_bricks(bricks, callback, newlyLoaded) {
        bricks.each(function (brick) {
          var currentLink = $(this);

          if (newlyLoaded) {
            currentLink.addClass('newly-loaded');
          } else {
            currentLink.addClass('already-loaded');
          }

          setTimeout(function () {
            if (brick == bricks.length - 1 && typeof callback == 'function') {
              callback.call();
            }
          }, 100);
        });
      },
      loadMore: function loadMore(e) {
        e.preventDefault();
        var current = $(this),
            currentLabel = current.find(".avia_iconbox_title"),
            masonry = current.parent().prev('.ep-posts-load-more'),
            aSingleColumn = masonry.children(".entry").first().outerHeight(),
            scrollTopValue = masonry.offset().top + masonry.outerHeight() - aSingleColumn - 80,
            // dynamically update this
        data = current.data(); //calculate a new offset	

        if (!data.offset) data.offset = 0;
        data.offset += data.items;
        data.action = 'ep_post_grid_more';
        currentLabel.text(current.data('loadingLabel'));
        $.ajax({
          url: avia_framework_globals.ajaxurl,
          type: "POST",
          data: data,
          success: function success(response) {
            $('html, body').animate({
              scrollTop: scrollTopValue
            }, 50);
            currentLabel.text(current.data('buttonLabel'));

            if (response.indexOf("{post-grid-loaded}") !== -1) {
              //fetch the response. if any php warnings were displayed before rendering of the items the are removed by the string split
              var response = response.split('{post-grid-loaded}'),
                  new_items = $(response.pop()).filter('.entry'); //check if we got more items than we need. if not we have reached the end of items

              if (new_items.length > data.items) {
                new_items = new_items.not(':last');
              } else {
                current.addClass('ep-no-more-items');
              }

              masonry.append(new_items);
              setTimeout(function () {
                methods.show_bricks(new_items, false, true);
              }, 50);
            }
          }
        });
      }
    };
    return this.each(function () {
      var grid = $(this),
          container = $(this).parent(),
          bricks = grid.find('> *'),
          load_more = container.find('.ajax-load-more').css({
        visibility: "visible",
        opacity: 0
      });
      methods.show_bricks(bricks, function () {
        load_more.css({
          opacity: 1
        }).on('click', methods.loadMore);
      }, false);
    });
  };
})(jQuery);