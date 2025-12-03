(function($) {
    'use strict';
    var banner = document.querySelector('#proBanner');
    var closeBtn = document.querySelector('#bannerClose');
    if (!banner || !closeBtn || typeof $.cookie !== 'function') {
      return;
    }
    if ($.cookie('corona-pro-banner') != "true") {
      banner.classList.add('d-flex');
    } else {
      banner.classList.add('d-none');
    }
    closeBtn.addEventListener('click', function() {
      banner.classList.add('d-none');
      banner.classList.remove('d-flex');
      var date = new Date();
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
      $.cookie('corona-pro-banner', "true", { expires: date });
    });
})(jQuery);
