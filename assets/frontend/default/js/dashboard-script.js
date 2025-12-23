// Menu Nav
$(document).ready(function () {
  const applyCloseIcon = () => {
    const widthwindow = $(window).width();
    if (widthwindow <= 1199) {
      $(".app-page-header").addClass("close_icon");
      $(".app-sidebar-wrapper").addClass("close_icon");
      $(".app-sidebar").removeClass("nav-folded side-nav-hover");
      $(".app-page-header").removeClass("close_icon");
      $(".app-sidebar-wrapper").removeClass("close_icon");
    }
  };

  applyCloseIcon();

  $(window).on("resize", applyCloseIcon);

  $(".toggle-sidebar").on("click", function () {
    const widthwindow = $(window).width();
    if (widthwindow > 1199) {
      $(".app-sidebar").toggleClass("nav-folded");
    } else {
      $(".app-sidebar").removeClass("nav-folded side-nav-hover");
    }
    $(".app-page-header").toggleClass("close_icon");
    $(".app-sidebar-wrapper").toggleClass("close_icon");
    $(this).toggleClass("active");
  });

  $(document).on("mouseenter", ".app-sidebar", function () {
    const widthwindow = $(window).width();
    if (widthwindow > 1199 && $(this).hasClass("nav-folded")) {
      $(this).addClass("side-nav-hover");
    }
  });

  $(document).on("mouseleave", ".app-sidebar", function () {
    const widthwindow = $(window).width();
    if (widthwindow > 1199 && $(this).hasClass("nav-folded")) {
      $(this).removeClass("side-nav-hover");
    }
  });
});

// Initialize sidebar
$("#sidebar__active").on("click", function () {
  if (window.innerWidth > 0 && window.innerWidth <= 1199) {
    $(".app-sidebar").toggleClass("close_sidebar");
  } else {
    $(".app-sidebar").toggleClass("collapsed");
  }
  $(".app__offcanvas-overlay").toggleClass("overlay-open");
});

$(".app__offcanvas-overlay").on("click", function () {
  $(".app-sidebar").removeClass("collapsed");
  $(".app-sidebar").removeClass("close_sidebar");
  $(".app__offcanvas-overlay").removeClass("overlay-open");
});

$(document).ready(function () {
  $(".has-dropdown").on("click", function (e) {
    e.preventDefault();
    $(".main-menu .slide").removeClass("active");

    const $dropdown = $(this);
    const $submenu = $dropdown.next(".has-submenu-slide-content");
    const $parentSlide = $dropdown.closest(".has-submenu-slide");

    $(".has-submenu-slide-content")
      .not($submenu)
      .slideUp(300, function () {
        $(this).removeClass("open");
        $(this).prev(".has-dropdown").removeClass("open");
        $(this).closest(".has-submenu-slide").removeClass("open");
      });

    $dropdown.toggleClass("open");
    $parentSlide.toggleClass("open");
    $submenu.stop(true, true).slideToggle(300, function () {
      $(this).toggleClass("open", $(this).is(":visible"));
    });
  });
});

// top nav dashboard
$(document).ready(function () {
  $(".user-header-link.has-dropdown").on("click", function (e) {
    e.preventDefault();

    const $this = $(this);
    const $submenu = $this.next(".sub-menu");
    $(".sub-menu").not($submenu).stop(true, true).slideUp(200);

    $submenu.stop(true, true).slideToggle(200);
  });
  $(document).on("click", function (e) {
    if (!$(e.target).closest(".user-header li").length) {
      $(".sub-menu").stop(true, true).slideUp(200);
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const scrollContainer = document.querySelector(".all-user-navbar ul");
  const leftBtn = document.querySelector(".left-scrollbar-button");
  const rightBtn = document.querySelector(".right-scrollbar-button");
  const scrollAmount = 150;
  if (scrollContainer && window.innerWidth <= 991) {
    scrollContainer.addEventListener("scroll", function () {
      $(".sub-menu").stop(true, true).slideUp(200);
    });
  }
});
