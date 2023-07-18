
!function($) {
    "use strict";

    var MainApp = function() {
        this.$btnFullScreen = $("#btn-fullscreen")
    };

    //full screen
    MainApp.prototype.initFullScreen = function () {
        var $this = this;
        $this.$btnFullScreen.on("click", function (e) {
            e.preventDefault();

            if (!document.fullscreenElement && /* alternative standard method */ !document.mozFullScreenElement && !document.webkitFullscreenElement) {  // current working methods
                if (document.documentElement.requestFullscreen) {
                    document.documentElement.requestFullscreen();
                } else if (document.documentElement.mozRequestFullScreen) {
                    document.documentElement.mozRequestFullScreen();
                } else if (document.documentElement.webkitRequestFullscreen) {
                    document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
                }
            } else {
                if (document.cancelFullScreen) {
                    document.cancelFullScreen();
                } else if (document.mozCancelFullScreen) {
                    document.mozCancelFullScreen();
                } else if (document.webkitCancelFullScreen) {
                    document.webkitCancelFullScreen();
                }
            }
        });
    },

    MainApp.prototype.initNavbar = function () {

        $('.navbar-toggle').on('click', function (event) {
            $(this).toggleClass('open');
            $('#navigation').slideToggle(400);
        });

        $('.navigation-menu>li').slice(-1).addClass('last-elements');

        $('.navigation-menu li.has-submenu a[href="#"]').on('click', function (e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                $(this).parent('li').toggleClass('open').find('.submenu:first').toggleClass('open');
            }
        });
    },

    // === fo,llowing js will activate the menu in left side bar based on url ====
    MainApp.prototype.initMenuItem = function () {
        $(".navigation-menu a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];
            if (this.href == pageUrl) { 
                $(this).parent().addClass("active"); // add active to li of the current link
                $(this).parent().parent().parent().addClass("active"); // add active class to an anchor
                $(this).parent().parent().parent().parent().parent().addClass("active"); // add active class to an anchor
            }
        });
    },
    MainApp.prototype.initComponents = function () {
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover();
    },
    MainApp.prototype.initslimscrollleft = function () {

         //SLIM SCROLL
      $('.slimscroller').slimscroll({
        height: 'auto',
        size: "5px",
        color: '#dee4e8'
      });

        $('.slimscrollleft').slimScroll({
            height: 'auto',
            position: 'right',
            size: "7px",
            color: '#dee4e8',
            wheelStep: 5
        });
    },

    MainApp.prototype.init = function () {
        this.initFullScreen();
        this.initNavbar();
        this.initMenuItem();
        this.initComponents();
        this.initslimscrollleft();
    },

    //init
    $.MainApp = new MainApp, $.MainApp.Constructor = MainApp
}(window.jQuery),

//initializing
function ($) {
    "use strict";
    $.MainApp.init();
}(window.jQuery);

//Disable cut copy paste
$('body').bind('cut copy paste', function (e) {
    e.preventDefault();
});

//Disable mouse right click
$("body").on("contextmenu",function(e){
    return false;
});
document.onkeydown = function(e) {
    if (e.ctrlKey && 
        (e.keyCode === 67 || 
         e.keyCode === 86 || 
         e.keyCode === 85 || 
         e.keyCode === 117)) {
        alert('This is not allowed');
        return false;
    } else {
        return true;
    }
};

$(document).keydown(function (event) {
    if (event.keyCode == 123) {
        return false;
    }
    else if ((event.ctrlKey && event.shiftKey && event.keyCode == 73) || (event.ctrlKey && event.shiftKey && event.keyCode == 74)) {
        return false;
    }
});

var isCtrl = !1;
document.onkeyup = function(a) {
   17 == a.which && (isCtrl = !1)
}, document.onkeydown = function(a) {
   if (17 == a.which && (isCtrl = !0), 85 == a.which || 67 == a.which && 1 == isCtrl) return !1
};