(function ($) {
  "use strict";

  var nav_offset_top = $("header").height() + 100;

  /*------- Navbar Fixed js -------*/
  function navbarFixed() {
    if ($("header").length) {
      $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= nav_offset_top) {
          $("header").addClass("navbar_fixed");
        } else {
          $("header").removeClass("navbar_fixed");
        }
      });
    }
  }
  navbarFixed();

  /*------- background_slider js -------*/
  if ($(".background_slider").length) {
    $(".background_slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      arrows: false,
      speed: 2000,
      autoplay: true,
      autoplaySpeed: 2000,
      fade: true,
    });
  }

  /*------- booking_slider,testimonial_slider js -------*/

  if ($(".booking_slider,.testimonial_slider").length) {
    $(".booking_slider,.testimonial_slider").slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: false,
      prevArrow: "<i class='arrow_carrot-left left'></i>",
      nextArrow: "<i class='arrow_carrot-right right'></i>",
      autoplay: true,
      autoplaySpeed: 4000,
    });
  }

  /*------- latest_news_slider js -------*/
  if ($(".latest_news_slider").length) {
    $(".latest_news_slider").slick({
      slidesToShow: 2,
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 4000,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
            infinite: true,
          },
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });
  }

  // $('#calendar-demo').dcalendar();

  /*------- team_slider js -------*/
  if ($("#team_slider").length) {
    $("#team_slider").slick({
      slidesToShow: 4,
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 4000,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 4,
            slidesToScroll: 1,
            infinite: true,
          },
        },
        {
          breakpoint: 992,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 650,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });
  }

  /*------- featured_info Slider js -------*/

  if ($(".featured_info").length) {
    $(".featured_info").slick({
      slidesToShow: 3,
      slidesToScroll: 1,
      dots: true,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 2000,
      responsive: [
        {
          breakpoint: 1024,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 1,
            infinite: true,
          },
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 1,
          },
        },
        {
          breakpoint: 480,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });
  }

  /*------- datetimepicker js -------*/
  $(".date-input-css").datepicker();

  /*------- search form js -------*/
  $(".search_dropdown a").on("click", function () {
    if ($(this).parent().hasClass("open")) {
      $(this).parent().removeClass("open");
    } else {
      $(this).parent().addClass("open");
    }
    return false;
  });

  /*--------- WOW js-----------*/
  function wowAnimation() {
    new WOW({
      offset: 100,
      mobile: true,
    }).init();
  }

  wowAnimation();

  /*==============================
	video-pop
	==============================*/

  /* Magnificpopup js */
  function magnificPopup() {
    if ($("body").length) {
      //Video Popup
      $(".video-pop").magnificPopup({
        disableOn: 700,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false,
      });
    }
  }
  magnificPopup();

  /*----------------------------------------------------*/
  /*  Google map js
    /*----------------------------------------------------*/

  if ($("#mapBox").length) {
    var $lat = $("#mapBox").data("lat");
    var $lon = $("#mapBox").data("lon");
    var $zoom = $("#mapBox").data("zoom");
    var $marker = $("#mapBox").data("marker");
    var $info = $("#mapBox").data("info");
    var $markerLat = $("#mapBox").data("mlat");
    var $markerLon = $("#mapBox").data("mlon");
    var map = new GMaps({
      el: "#mapBox",
      lat: $lat,
      lng: $lon,
      scrollwheel: false,
      scaleControl: true,
      streetViewControl: false,
      panControl: true,
      disableDoubleClickZoom: true,
      mapTypeControl: false,
      zoom: $zoom,
      styles: [
        {
          featureType: "administrative.country",
          elementType: "geometry",
          stylers: [
            {
              visibility: "simplified",
            },
            {
              hue: "#ff0000",
            },
          ],
        },
      ],
    });

    map.addMarker({
      lat: $markerLat,
      lng: $markerLon,
      icon: $marker,
      infoWindow: {
        content: $info,
      },
    });
  }

  /*==============================
    video-pop
    ==============================*/
  $("[data-pickme]").each(function () {
    var $this = $(this);
    $(".form-result", $this).css("display", "none");
    $("#locationError").css("display", "none");

    $this.submit(function () {
      $('button[type="submit"]', $this).addClass("clicked");

      // Create a object and assign all fields name and value.
      var values = {};

      // All input
      $("[name]", $this).each(function () {
        var $this = $(this),
          $name = $this.attr("name"),
          $type = $this.attr("type"),
          $value = $this.val();

        // Check if not radio or checkbox
        if (!["checkbox", "radio"].includes($type)) {
          values[$name] = $value;
        }
      });

      // Only radio and checkbox input
      $("[name]:checked", $this).each(function () {
        var $this = $(this),
          $name = $this.attr("name"),
          $value = $this.val();
        values[$name] = $value;
      });

      var sdestination = document.getElementById("addressField1").value;
      var edestination = document.getElementById("addressField2").value;
      if(sdestination && edestination) {
        if (sdestination == edestination) {
          $("#locationError").addClass("alert-danger mt-2").fadeIn(200).show();
          document.getElementById("locationError").innerHTML =
            "Start and End Location should be different!";
          return false;
        }
      }
      
      // Make Request
      $.ajax({
        url: $this.attr("action"),
        type: "POST",
        data: values,
        success: function success(data) {
          if (data.error == true) {
            $(".form-result", $this)
              .addClass("alert-warning")
              .removeClass("alert-success alert-danger")
              .fadeIn(200)
              .show()
              .fadeOut(60000);
          } else {
            $(".form-result", $this)
              .addClass("alert-success")
              .removeClass("alert-warning alert-danger")
              .fadeIn(200)
              .show()
              .fadeOut(60000);
          }
          $(".form-result > .content", $this).html(data.message);
          $('button[type="submit"]', $this).removeClass("clicked");
          $(".form-result > .content", $this).html(data.message);
          $('button[type="submit"]', $this).removeClass("clicked");
          $this.trigger("reset");
        },

        error: function error() {
          $(".form-result", $this)
            .addClass("alert-danger")
            .removeClass("alert-warning alert-success")
            .fadeIn(200)
            .show()
            .fadeOut(60000);
          $(".form-result > .content", $this).html("Sorry, an error occurred.");
          $('button[type="submit"]', $this).removeClass("clicked");
        },
      });
      return false;
    });
  });

  // preloader js
  $(window).on("load", function () {
    // makes sure the whole site is loaded
    $(".loading").fadeOut(); // will first fade out the loading animation
    $(".sampleContainer").delay(150).fadeOut("slow"); // will fade out the white DIV that covers the website.
    $("body").delay(150).css({ overflow: "visible" });
  });
})(jQuery);
