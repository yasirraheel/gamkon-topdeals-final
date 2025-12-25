// ==================================================
// * Project Name   : Gamkon - Subscription-Based On Demand Online Account Selling Marketplace
// * File           :  JS Base
// * Version        :  1.0
// * Last change    :  Aug 2025, Saturday
// * Author         :  tdevs (https://codecanyon.net/user/tdevs/portfolio)
// ==================================================

(function ($) {
  "use strict";

  var windowOn = $(window);

  // preloader
  $(window).on("load", function () {
    $("#preloader").fadeOut(500);
  });

  window.onload = function () {
    $("#preloader").fadeOut(500);
  };

  windowOn.on("load", function () {
    if (hasAnimation) {
      wowAnimation();
    }
  });

  // wow
  function wowAnimation() {
    if (typeof WOW !== "undefined") {
      var wow = new WOW({
        boxClass: "wow",
        animateClass: "animated",
        offset: 0,
        mobile: false,
        live: true,
      });
      wow.init();
    }
  }

  // back-to-top
  $(document).ready(function () {
    "use strict";

    var progressPath = document.querySelector(".progress-wrap path");

    if (!progressPath) {
      // console.warn(".progress-wrap path not found in DOM");
      return;
    }

    var pathLength = progressPath.getTotalLength();
    progressPath.style.transition = progressPath.style.WebkitTransition =
      "none";
    progressPath.style.strokeDasharray = pathLength + " " + pathLength;
    progressPath.style.strokeDashoffset = pathLength;
    progressPath.getBoundingClientRect();
    progressPath.style.transition = progressPath.style.WebkitTransition =
      "stroke-dashoffset 10ms linear";

    var updateProgress = function () {
      const scrollTop = window.scrollY || document.documentElement.scrollTop;
      const windowHeight = window.innerHeight;
      const bodyHeight = document.body.scrollHeight;

      const totalScrollableHeight = bodyHeight - windowHeight;
      const scrollPercentage = (scrollTop / totalScrollableHeight) * 100;
      const progress = pathLength - (scrollPercentage / 100) * pathLength;
      progressPath.style.strokeDashoffset = progress;
    };

    updateProgress();
    $(window).scroll(updateProgress);

    var offset = 50;
    var duration = 550;

    $(window).on("scroll resize", updateProgress);

    $(window).on("scroll", function () {
      if ($(this).scrollTop() > offset) {
        $(".progress-wrap").addClass("active-progress");
      } else {
        $(".progress-wrap").removeClass("active-progress");
      }
    });

    $(".progress-wrap").on("click", function (event) {
      event.preventDefault();
      $("html, body").animate({ scrollTop: 0 }, duration);
      return false;
    });
  });

  // Data Css js
  $("[data-background").each(function () {
    $(this).css(
      "background-image",
      "url( " + $(this).attr("data-background") + "  )"
    );
  });

  $("[data-width]").each(function () {
    $(this).css("width", $(this).attr("data-width"));
  });

  $("[data-bg-color]").each(function () {
    $(this).css("background-color", $(this).attr("data-bg-color"));
  });

  // video popup
  $(".popup-video").magnificPopup({
    type: "iframe",
    // other options
  });

  // image popup
  $(".popup-image").magnificPopup({
    type: "image",
    // other options
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1],
    },
  });

  // jarallax
  if ($(".jarallax").length) {
    $(".jarallax").jarallax({
      speed: 0.2,
    });
  }

  // offcanvas bar
  $(".td-offcanvas-toggle").on("click", function () {
    $(".td-offcanvas").addClass("td-offcanvas-open");
    $(".td-offcanvas-overlay").addClass("td-offcanvas-overlay-open");
  });
  $(".td-offcanvas-close-toggle,.td-offcanvas-overlay").on(
    "click",
    function () {
      $(".td-offcanvas").removeClass("td-offcanvas-open");
      $(".td-offcanvas-overlay").removeClass("td-offcanvas-overlay-open");
    }
  );

  // nice select activation
  $(document).ready(function () {
    $(".nice-select-active").niceSelect();
  });
  $(document).ready(function () {
    $(".nice-select-sort").niceSelect();
  });
  $(document).ready(function () {
    $(".nice-select-categories").niceSelect();
  });

  // Header search suggestion and dropdown functionality
  $(document).ready(function () {
    // Handle search input focus
    $('.search input[type="text"]').on("focus", function () {
      $(".search-suggestion-box").addClass("open");
      $(".search-dropdown-lists").removeClass("open");
      $(this).addClass("open");
      updateFullPageOverlayState();
    });

    // Handle dropdown button click
    $(".search-dropdown").on("click", function () {
      const dropdownOpen = $(".search-dropdown-lists").hasClass("open");
      $(".search-dropdown-lists").toggleClass("open", !dropdownOpen);
      $(".search-suggestion-box").removeClass("open");
      $('.search input[type="text"]').toggleClass("open", !dropdownOpen);
      updateFullPageOverlayState();
    });

    // Close all on click outside
    $(document).on("click", function (e) {
      if (!$(e.target).closest(".search").length) {
        $(".search-suggestion-box, .search-dropdown-lists").removeClass("open");
        $('.search input[type="text"]').removeClass("open");
        $(".search-dropdown").removeClass("open");
      }
      updateFullPageOverlayState();
    });

    // Close search-suggestion-box when clicking on suggestion-button
    $(".recently-search-buttons").on(
      "click",
      ".suggestion-button",
      function (e) {
        if (!$(e.target).closest(".close").length) {
          $(".search-suggestion-box").removeClass("open");
          $(".search input[type='text']").removeClass("open");
        }
        updateFullPageOverlayState();
      }
    );

    // Remove suggestion-button when the close button is clicked
    $(".recently-search-buttons").on("click", ".close", function (e) {
      e.stopPropagation();
      $(this).closest(".suggestion-button").remove();
    });

    // Close search-suggestion-box when clicking on top-search-button
    $(".top-search-buttons").on("click", ".top-search-button", function () {
      $(".search-suggestion-box").removeClass("open");
      $(".search input[type='text']").removeClass("open");
      updateFullPageOverlayState();
    });

    // Close search-dropdown-lists when clicking a category-btn
    $(".category-btn").on("click", function () {
      $(".search-dropdown-lists").removeClass("open");
      $(".search input[type='text']").removeClass("open");
      updateFullPageOverlayState();
    });

    // Close both search-suggestion-box and search-dropdown-lists on pressing Enter in input
    $('.search input[type="text"]').on("keypress", function (e) {
      if (e.which === 13) {
        $(".search-suggestion-box, .search-dropdown-lists").removeClass("open");
        $(this).removeClass("open");
        updateFullPageOverlayState();
      }
    });

    // Handle notification box toggle
    $(".notification-btn").on("click", function (event) {
      event.stopPropagation();
      $(".notification-box").toggleClass("open");
      $(".chat-box").removeClass("open");
      updateFullPageOverlayState();
    });

    // Close notification-box when clicking outside or on an <a> inside it
    $(document).on("click", function (e) {
      if (
        !$(e.target).closest(".notification-box").length ||
        $(e.target).is(".notification-box a")
      ) {
        $(".notification-box").removeClass("open");
        updateFullPageOverlayState();
      }
    });

    // Handle chat box toggle
    $(".chat-btn").on("click", function (event) {
      event.stopPropagation();
      $(".chat-box").toggleClass("open");
      $(".notification-box").removeClass("open");
      updateFullPageOverlayState();
    });

    // Close chat-box when clicking outside or on an <a> inside it
    $(document).on("click", function (e) {
      if (
        !$(e.target).closest(".chat-box").length ||
        $(e.target).is(".chat-box a")
      ) {
        $(".chat-box").removeClass("open");
        updateFullPageOverlayState();
      }
    });

    // Handle user content toggle
    $(".user").on("click", function (event) {
      event.stopPropagation();
      $(".user-content").toggleClass("open");
      updateFullPageOverlayState();
    });

    $(document).on("click", function (e) {
      if (!$(e.target).closest(".user, .user-content").length) {
        $(".user-content").removeClass("open");
        updateFullPageOverlayState();
      }
    });

    // Set data attributes for each category button
    $(".category-btn").each(function () {
      const categoryText = $(this).find("p").text();
      $(this).attr("data-category", categoryText);
    });

    // Handle click events on category buttons
    $(".category-btn").on("click", function (e) {
      e.preventDefault();
      const categoryValue = $(this).data("category");

      // Update search-dropdown data-value and text dynamically
      $(".search-dropdown").attr(
        "data-value",
        categoryValue
      ).html(`${categoryValue} <div class="arrow">
      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
        <path d="M5 7.5L10 12.5L15 7.5" stroke="#080808" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>
    </div>`);
    });

    // Utility: Update input state
    function updateInputState() {
      if (
        $(".search-suggestion-box").hasClass("open") ||
        $(".search-dropdown-lists").hasClass("open")
      ) {
        $('.search input[type="text"]').addClass("open");
      } else {
        $('.search input[type="text"]').removeClass("open");
      }
    }

    // Handle nice-select-active open state
    $(".nice-select-active").on("click", function () {
      updateFullPageOverlayState();
    });

    // Utility: Update full-page overlay state
    function updateFullPageOverlayState() {
      if (
        $(".search-suggestion-box").hasClass("open") ||
        $(".search-dropdown-lists").hasClass("open") ||
        $(".notification-box").hasClass("open") ||
        $(".chat-box").hasClass("open") ||
        $(".user-content").hasClass("open")
        // $('.nice-select-active').hasClass('open')
      ) {
        $(".full-page-overlay").addClass("open");
      } else {
        $(".full-page-overlay").removeClass("open");
      }
    }

    // Call `updateInputState` whenever boxes open or close
    $(
      '.search-dropdown, .search input[type="text"], .category-btn, .suggestion-button, .close, .top-search-button, .notification-btn, .chat-btn'
    ).on("click", function () {
      updateInputState();
      updateFullPageOverlayState();
    });
  });

  // chat truncate function
  function truncateText(selector, maxLength) {
    $(selector).each(function () {
      let text = $(this).text().trim(); // Get the text content
      if (text.length > maxLength) {
        let truncated = text.substring(0, maxLength) + "..."; // Truncate and add ellipsis
        $(this).text(truncated); // Set the truncated text
      }
    });
  }
  $(document).ready(function () {
    truncateText(".truncateText", 35);
  });

  //text truncate function when need screen size wise
  function truncateText2(selector, maxLength) {
    $(selector).each(function () {
      let text = $(this).text().trim();
      if (text.length > maxLength) {
        let truncated = text.substring(0, maxLength) + "...";
        $(this).text(truncated);
      }
    });
  }
  function getMaxLengthForScreen() {
    let screenWidth = $(window).width();
    if (screenWidth <= 576) {
      return 15;
    } else if (screenWidth <= 768) {
      return 30;
    } else if (screenWidth <= 1024) {
      return 35;
    } else {
      return 35;
    }
  }
  $(document).ready(function () {
    function applyTruncation() {
      let maxLength = getMaxLengthForScreen();
      truncateText2(".truncateText2", maxLength);
    }
    applyTruncation();
    $(window).resize(function () {
      applyTruncation();
    });
  });

  // chat truncate function
  function truncateText3(selector, maxLength) {
    $(selector).each(function () {
      let text = $(this).text().trim(); // Get the text content
      if (text.length > maxLength) {
        let truncated = text.substring(0, maxLength) + "..."; // Truncate and add ellipsis
        $(this).text(truncated); // Set the truncated text
      }
    });
  }
  $(document).ready(function () {
    truncateText3(".truncateText3", 120);
  });

  // game title function
  function truncateText4(selector, maxLength) {
    $(selector).each(function () {
      let text = $(this).text().trim(); // Get the text content
      if (text.length > maxLength) {
        let truncated = text.substring(0, maxLength) + "..."; // Truncate and add ellipsis
        $(this).text(truncated); // Set the truncated text
      }
    });
  }
  $(document).ready(function () {
    truncateText4(".truncateText4", 30);
  });

  // mobile search popup
  $(document).ready(function () {
    const $popup = $(".mobile-search-popup");
    const $button = $(".mobile-search-button");
    const $closeButton = $(".close");

    $button.on("click", function (e) {
      e.stopPropagation();
      $popup.toggleClass("open");
    });

    $closeButton.on("click", function () {
      $popup.removeClass("open");
    });

    $(document).on("click", function (e) {
      if (!$popup.is(e.target) && $popup.has(e.target).length === 0) {
        $popup.removeClass("open");
      }
    });
  });

  //mobile menu
  $(".td-offcanvas-toggle").on("click", function () {
    $(".td-offcanvas").addClass("td-offcanvas-open");
    $(".td-offcanvas-overlay").addClass("td-offcanvas-overlay-open");
  });
  $(".td-offcanvas-close-toggle,.td-offcanvas-overlay").on(
    "click",
    function () {
      $(".td-offcanvas").removeClass("td-offcanvas-open");
      $(".td-offcanvas-overlay").removeClass("td-offcanvas-overlay-open");
    }
  );

  //popular-seller activation
  var swiper = new Swiper(".myPopularSellerSwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    autoplay: {
      delay: 3000,
    },
    speed: 600,
    loop: false,
    navigation: {
      nextEl: ".swiper-next",
      prevEl: ".swiper-prev",
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      576: {
        slidesPerView: 2,
        spaceBetween: 10,
      },
      768: {
        slidesPerView: 3,
        spaceBetween: 15,
      },
      992: {
        slidesPerView: 4,
        spaceBetween: 20,
      },
      1200: {
        slidesPerView: 4,
        spaceBetween: 20,
      },
      1400: {
        slidesPerView: 4,
        spaceBetween: 30,
      },
      1920: {
        slidesPerView: 4,
        spaceBetween: 30,
      },
    },
  });

  // Initialize gallery slider
  if ($(".main-slider").length > 0) {
    $(".main-slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: false,
      fade: true,
      asNavFor: ".nav-slider",
    });

    $(".nav-slider").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      asNavFor: ".main-slider",
      dots: false,
      arrows: false,
      centerMode: false,
      focusOnSelect: true,
      variableWidth: true,
      infinite: true,
      gap: 10,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 4,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 4,
          },
        },
      ],
    });
  }

  // pricing calculation
  $(document).ready(function () {
    const unitPrice = parseFloat(
      $("#unit-price")
        .text()
        .replace(/[^0-9.]/g, "")
    );
    toggleUnitPrice(1);

    $("#increase-btn").click(function () {
      updateQuantity(1);
    });

    $("#decrease-btn").click(function () {
      updateQuantity(-1);
    });

    $("#quantity-input").on("input", function () {
      validateAndCalculate();
    });

    function updateQuantity(change) {
      let currentQuantity = parseInt($("#quantity-input").val().trim()) || 1;
      let newQuantity = currentQuantity + change;
      if (newQuantity > __quantity) {
        showNotification(
          "error",
          `Please enter a valid number less than ${__quantity}`
        );
        $("#quantity-input").val(__quantity).change();
        return;
      }
      if (newQuantity < 1) {
        showError("#invalid-error");
        $("#quantity-input").val("1");
        return;
      }

      hideError();
      $("#quantity-input").val(newQuantity);

      updateTotalPrice(newQuantity);
      toggleUnitPrice(newQuantity);
    }

    function validateAndCalculate() {
      const value = $("#quantity-input").val().trim();

      if (!/^\d+$/.test(value) || parseInt(value) < 1) {
        showError("#invalid-error");
      } else {
        hideError();
        updateTotalPrice(parseInt(value));
        toggleUnitPrice(parseInt(value));
      }
    }

    function updateTotalPrice(quantity) {
      const totalPrice = (quantity * unitPrice).toFixed(2);
      $("#total-price").text(totalPrice);
    }

    function toggleUnitPrice(quantity) {
      $(".unit-price").toggleClass("d-none", quantity === 1);
    }

    function showError(selector) {
      $(".text-danger").addClass("d-none");
      $(selector).removeClass("d-none");
    }

    function hideError() {
      $(".text-danger").addClass("d-none");
    }
  });

  // custom accordion for payment method
  $(document).ready(function () {
    $(".method-button").click(function () {
      $(".method-button").removeClass("open");
      $(".method-content").removeClass("open");
      $(".form-check-input").prop("checked", false);

      $(this).addClass("open");
      $(this).siblings(".method-content").addClass("open");
      $(this).find(".form-check-input").prop("checked", true);
    });

    $(".method-item:first-child .method-button").addClass("open");
    $(".method-item:first-child .method-content").addClass("open");
    $(".method-item:first-child .form-check-input").prop("checked", true);
  });

  // payment method checkbox interactions
  $(document).ready(function () {
    $('.payment-method-checkbox input[type="radio"]').on("change", function () {
      // Remove active state from all checkboxes in the same group
      var groupName = $(this).attr("name");
      $('input[name="' + groupName + '"]').each(function () {
        $(this).siblings(".check-box-image").removeClass("active");
      });

      // Add active state to the selected checkbox
      if ($(this).is(":checked")) {
        $(this).siblings(".check-box-image").addClass("active");
      }
    });

    // Handle label clicks
    $(".check-box-image").on("click", function () {
      var radio = $(this).siblings('input[type="radio"]');
      radio.prop("checked", true).trigger("change");
    });
  });

  // counter js
  $(document).ready(function () {
    let animated = false;

    function animateCounters() {
      $(".count").each(function () {
        var $this = $(this);
        var $number = $this.find(".count-number");
        var countTo = parseInt($this.attr("data-count"));
        var suffix = $this.find(".count-suffix").text() || "";

        $({ countNum: 0 }).animate(
          { countNum: countTo },
          {
            duration: 2000,
            easing: "swing",
            step: function () {
              let displayValue = Math.floor(this.countNum);
              if (countTo >= 1000) {
                displayValue = displayValue.toLocaleString();
              }
              $number.text(displayValue);
            },
            complete: function () {
              let finalValue = Math.floor(countTo);
              if (countTo >= 1000) {
                finalValue = finalValue.toLocaleString();
              }
              $number.text(finalValue);
            },
          }
        );
      });
    }

    const observer = new IntersectionObserver(
      function (entries) {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !animated) {
            animateCounters();
            animated = true;
            observer.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.1,
        rootMargin: "0px 0px -50px 0px",
      }
    );

    const target = document.querySelector(".all-stats-card");
    if (target) observer.observe(target);

    if (!("IntersectionObserver" in window)) {
      animateCounters();
    }
  });

  // Initialize toster
  document.querySelectorAll(".td-alert-box .close-btn").forEach((btn) => {
    btn.addEventListener("click", function () {
      const alertBox = this.closest(".td-alert-box");
      alertBox.classList.add("hidden");
      setTimeout(() => {
        alertBox.style.display = "none";
      }, 400);
    });
  });

  //auth text show hide
  $(document).ready(function () {
    $(".input-icon").on("click", function () {
      const inputField = $(this).siblings("input");
      const icon = $(this).find("i");

      if (inputField.attr("type") === "password") {
        inputField.attr("type", "text");
        icon.removeClass("fa-eye-slash").addClass("fa-eye");
      } else {
        inputField.attr("type", "password");
        icon.removeClass("fa-eye").addClass("fa-eye-slash");
      }
    });
  });

  // otp functionality
  const $inputs = $(".numeral-mask");
  $inputs.on("input", function () {
    const value = $(this).val();
    if (value.length === 1) {
      $(this).css("border-color", "#FF6229");
      const nextInput = $(this).next(".numeral-mask");
      if (nextInput.length) {
        nextInput.focus();
      }
    } else {
      $(this).val("");
    }
  });
  $inputs.on("paste", function (e) {
    const pasteData = e.originalEvent.clipboardData
      .getData("text")
      .replace(/\D/g, "");
    const currentIndex = $inputs.index(this);

    $inputs.each(function (index) {
      if (index >= currentIndex && pasteData[index - currentIndex]) {
        $(this)
          .val(pasteData[index - currentIndex])
          .css("border-color", "#FF6229");
      }
    });
    e.preventDefault();
  });
  $inputs.first().focus().css("border-color", "#FF6229");

  // copy input
  $(document).ready(function () {
    $(".copy-btn").on("click", function () {
      const $button = $(this);
      const $input = $button.siblings("input");

      $input[0].select();
      document.execCommand("copy");
      $button.text("Copied");

      setTimeout(function () {
        $button.text("Copy");
      }, 1000);
    });
  });

  // Format option function for Select2 with images
  function formatOption(option) {
    if (!option.id) {
      return option.text;
    }

    var $option = $(
      '<span><img src="' +
        $(option.element).data("image") +
        '" class="img-flag" style="width: 20px; height: 20px; margin-right: 8px;" /> ' +
        option.text +
        "</span>"
    );

    return $option;
  }

  // Initialize Select2 for each select
  $(document).ready(function () {
    setTimeout(function () {
      if (typeof $.fn.select2 === "undefined") {
        console.error("Select2 is not loaded!");
        return;
      }

      // Initialize simple select without images
      if ($("#simpleSelect1").length) {
        try {
          $("#simpleSelect1").select2({
            minimumResultsForSearch: Infinity,
            width: "100%",
            dropdownParent: $("#simpleSelect1").parent(),
          });
        } catch (error) {
          console.error("Error initializing simpleSelect1:", error);
        }
      }

      // Original initialization for image selects (unchanged)
      if ($("#imageSelect1").length) {
        try {
          $("#imageSelect1").select2({
            templateResult: formatOption,
            templateSelection: formatOption,
            minimumResultsForSearch: Infinity,
            width: "100%",
            dropdownParent: $("#imageSelect1").parent(),
          });
        } catch (error) {
          console.error("Error initializing imageSelect1:", error);
        }
      }

      if ($("#imageSelect2").length) {
        try {
          $("#imageSelect2").select2({
            templateResult: formatOption,
            templateSelection: formatOption,
            minimumResultsForSearch: Infinity,
            width: "100%",
            dropdownParent: $("#imageSelect2").parent(),
          });
        } catch (error) {
          console.error("Error initializing imageSelect2:", error);
        }
      }
    }, 100);
  });

  // This function is still needed for the image selects, but won't be used for the simple select
  function formatOption(option) {
    if (!option.id) return option.text;
    var $option = $(
      '<span><img src="' +
        $(option.element).data("image") +
        '" class="img-flag" /> ' +
        option.text +
        "</span>"
    );
    return $option;
  }

  //common modal for dashboard
  $(document).ready(function () {
    $(".common-modal-button:not(.edit)").click(function (e) {
      // e.stopPropagation();
      $(".common-modal-full").addClass("open");
    });
    $(".modal-action-btn .close").click(function () {
      $(this).parents(".common-modal-box").parent().removeClass("open");
    });

    $(document).on("click", ".open", function () {
      $(".common-modal-full, .custom-modal, .log-out-modal").removeClass(
        "open"
      );
    });

    $(".common-modal-box").click(function (e) {
      e.stopPropagation();
    });
  });

  // logout-modal
  $(document).ready(function () {
    $(".common-modal-button-logout").click(function (e) {
      e.stopPropagation();
      $(".log-out-modal").addClass("open");
    });

    $(document).click(function (e) {
      if (
        $(".log-out-modal").hasClass("open") &&
        !$(e.target).closest(".common-modal-box").length
      ) {
        $(".log-out-modal").removeClass("open");
      }
    });
    $(".common-modal-box").click(function (e) {
      e.stopPropagation();
    });
    $(".log-out-modal .close").click(function () {
      $(".log-out-modal").removeClass("open");
    });
  });

  // message truncate text
  $(document).ready(function () {
    $(".truncateMessageText").each(function () {
      const fullText = $(this).text().trim();
      const maxLength = 50;

      if (fullText.length > maxLength) {
        const truncated = fullText.substring(0, maxLength) + "...";
        $(this).text(truncated);
      }
    });
  });

  // mobile chat bar
  $(document).ready(function () {
    $(".open-recent-chat").on("click", function () {
      $(".recent-chat-mobile").addClass("open");
    });

    $(".recent-chat-mobile .close").on("click", function () {
      $(".recent-chat-mobile").removeClass("open");
    });

    $(document).on("click", function (e) {
      if (
        !$(e.target).closest(".recent-chat-mobile").length &&
        !$(e.target).closest(".open-recent-chat").length
      ) {
        $(".recent-chat-mobile").removeClass("open");
      }
    });
  });

  // custom file upload system
  $(document).ready(function () {
    $(".custom-file-input").each(function () {
      const container = $(this);
      const fileInput = container.find("input[type='file']");
      const uploadBtn = container.find(".upload-btn");
      const previewArea = container.find(".preview-area");
      const isMultiple = fileInput.attr("multiple") !== undefined;

      const hasInitialImage =
        previewArea.find(".previewImg").attr("src") &&
        previewArea.find(".previewImg").attr("src") !== "demo";

      if (
        hasInitialImage ||
        (isMultiple && previewArea.find(".image-container").length > 0)
      ) {
        previewArea.removeClass("hidden");
        uploadBtn.addClass("hidden");
      } else {
        previewArea.addClass("hidden");
        uploadBtn.removeClass("hidden");
      }

      function handleFileInputChange() {
        const files = this.files;
        if (files.length > 0) {
          previewArea.removeClass("hidden");
          uploadBtn.addClass("hidden");

          if (isMultiple) {
            previewArea.find(".image-container").remove();

            for (let i = 0; i < files.length; i++) {
              const file = files[i];
              const reader = new FileReader();
              reader.onload = function (e) {
                const imageContainer = $('<div class="image-container"></div>');
                const img = $("<img>").attr("src", e.target.result);
                const removeBtn = $('<span class="remove-btn">&times;</span>');

                removeBtn.on("click", function () {
                  imageContainer.remove();
                  if (previewArea.children(".image-container").length === 0) {
                    previewArea.addClass("hidden");
                    uploadBtn.removeClass("hidden");
                    fileInput.val("");
                  }
                });

                imageContainer.append(img).append(removeBtn);
                previewArea.append(imageContainer);
              };
              reader.readAsDataURL(file);
            }
          } else {
            const file = files[0];
            const reader = new FileReader();
            reader.onload = function (e) {
              const previewImg = previewArea.find(".previewImg");
              const fileNameDisplay = previewArea.find(".fileName");
              const removeBtn = previewArea.find(".remove-btn");

              previewImg.attr("src", e.target.result);
              fileNameDisplay.text(file.name);

              removeBtn.off("click").on("click", function () {
                fileInput.val("");
                previewImg.attr("src", "");
                fileNameDisplay.text("");
                previewArea.addClass("hidden");
                uploadBtn.removeClass("hidden");
              });
            };
            reader.readAsDataURL(file);
          }
        }
      }

      if (isMultiple) {
        previewArea.find(".remove-btn").on("click", function () {
          $(this).closest(".image-container").remove();
          if (previewArea.children(".image-container").length === 0) {
            previewArea.addClass("hidden");
            uploadBtn.removeClass("hidden");
            fileInput.val("");
          }
        });
      } else {
        previewArea.find(".remove-btn").on("click", function () {
          fileInput.val("");
          previewArea.find(".previewImg").attr("src", "");
          previewArea.find(".fileName").text("");
          previewArea.addClass("hidden");
          uploadBtn.removeClass("hidden");
        });
      }

      uploadBtn.on("click", function () {
        fileInput.click();
      });

      fileInput.on("change", handleFileInputChange);
    });
  });

  // flash sale slider
  var swiper = new Swiper(".myFlashSaleSwiper", {
    slidesPerView: 1,
    spaceBetween: 10,
    autoplay: {
      delay: 3000,
    },
    speed: 600,
    loop: true,
    navigation: {
      nextEl: ".flash-sale-swiper-next",
      prevEl: ".flash-sale-swiper-prev",
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      576: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 3,
      },
      992: {
        slidesPerView: 2,
      },
      1200: {
        slidesPerView: 3,
      },
      1400: {
        slidesPerView: 4,
      },
      1920: {
        slidesPerView: 4,
      },
    },
  });

  //progress bar dynamic
  $(document).ready(function () {
    $(".progress-bar-fill").each(function () {
      const percentage = $(this).data("percentage");
      $(this).css("width", `${percentage}%`);
    });
  });

  // testimonial swiper activation
  var swiper = new Swiper(".myTestimonialSwiper", {
    slidesPerView: 1,
    spaceBetween: 24,
    grabCursor: false,
    // autoplay: {
    //   delay: 3000,
    // },
    // speed: 600,
    // loop: true,
    navigation: {
      nextEl: ".testimonial-swiper-next",
      prevEl: ".testimonial-swiper-prev",
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      576: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 2,
      },
      1200: {
        slidesPerView: 3,
      },
      1400: {
        slidesPerView: 3,
      },
      1920: {
        slidesPerView: 3,
      },
    },
  });

  // apply coupon code
  $(document).ready(function () {
    $(".apply-coupon").on("click", function () {
      $(".coupon-input").slideToggle();
    });
  });

  // reply box show hide
  $(document).ready(function () {
    $(".reply-button").on("click", function (e) {
      e.preventDefault();
      $(this).closest(".reply-box").find(".reply-input").slideToggle(300);
    });
  });

  // tooltip activation
  var tooltipTriggerList = [].slice.call(
    document.querySelectorAll('[data-bs-toggle="tooltip"]')
  );
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl);
  });
})(jQuery);
