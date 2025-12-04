(function($) {
  'use strict';
  $(function() {
    var body = $('body');
    var contentWrapper = $('.content-wrapper');
    var scroller = $('.container-scroller');
    var footer = $('.footer');
    var sidebar = $('.sidebar');

    //Add active class to nav-link based on full pathname (avoid substring clashes like /outlet/manage vs /services/manage)
    function normalizePath(pathname) {
      return pathname.replace(/\/+$/, '') || '/';
    }

    function addActiveClass(element) {
      var href = element.attr('href') || '';

      // Ignore anchors/collapse toggles without a real path
      if (href === '#' || href.startsWith('#') || href.toLowerCase().startsWith('javascript:')) {
        return;
      }

      var linkPath = normalizePath(element[0].pathname);
      var currentPath = normalizePath(location.pathname);

      // Skip anchors without a real path
      if (!linkPath || linkPath === '#') return;

      var isSame = currentPath === linkPath;
      var isDescendant = currentPath.startsWith(linkPath + '/');

      if (isSame || isDescendant) {
        element.parents('.nav-item').last().addClass('active');
        if (element.parents('.sub-menu').length) {
          element.closest('.collapse').addClass('show');
          element.addClass('active');
        }
        if (element.parents('.submenu-item').length) {
          element.addClass('active');
        }
      }
    }

    $('.nav li a', sidebar).each(function() {
      addActiveClass($(this));
    })

    $('.horizontal-menu .nav li a').each(function() {
      addActiveClass($(this));
    })

    //Close other submenu in sidebar on opening any

    sidebar.on('show.bs.collapse', '.collapse', function() {
      sidebar.find('.collapse.show').collapse('hide');
    });


    //Change sidebar and content-wrapper height
    applyStyles();

    function applyStyles() {
      //Applying perfect scrollbar
      if (!body.hasClass("rtl")) {
        if ($('.settings-panel .tab-content .tab-pane.scroll-wrapper').length) {
          const settingsPanelScroll = new PerfectScrollbar('.settings-panel .tab-content .tab-pane.scroll-wrapper');
        }
        if ($('.chats').length) {
          const chatsScroll = new PerfectScrollbar('.chats');
        }
        if (body.hasClass("sidebar-fixed")) {
          var fixedSidebarScroll = new PerfectScrollbar('#sidebar .nav');
        }
      }
    }

    $('[data-toggle="minimize"]').on("click", function() {
      if ((body.hasClass('sidebar-toggle-display')) || (body.hasClass('sidebar-absolute'))) {
        body.toggleClass('sidebar-hidden');
      } else {
        body.toggleClass('sidebar-icon-only');
      }
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append('<i class="input-helper"></i>');

    //fullscreen
    $("#fullscreen-button").on("click", function toggleFullScreen() {
      if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
          document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
          document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
          document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
          document.documentElement.msRequestFullscreen();
        }
      } else {
        if (document.cancelFullScreen) {
          document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
          document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
          document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
          document.msExitFullscreen();
        }
      }
    })
    
  });
})(jQuery);
