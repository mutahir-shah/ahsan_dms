var mobile = $("#mobile");

// initialise plugin
mobile.intlTelInput({
  allowExtensions: true,
  formatOnDisplay: false,
  autoFormat: true,
  autoHideDialCode: true,
  autoPlaceholder: true,
  defaultCountry: "auto",
  ipinfoToken: "yolo",
  nationalMode: false,
  numberType: "MOBILE",
  // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
  // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
  preventInvalidNumbers: true,
  separateDialCode: false,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get(
      "https://ipinfo.io?token=ee8a1ac0f823c9",
      function () {},
      "jsonp"
    ).always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
});

var reset = function () {
  mobile.removeClass("error");
  // errorMsg.addClass("hide");
  // validMsg.addClass("hide");
};


var mobile = $("#driver_disposal_phone");

// initialise plugin
mobile.intlTelInput({
  allowExtensions: true,
  formatOnDisplay: false,
  autoFormat: true,
  autoHideDialCode: true,
  autoPlaceholder: true,
  defaultCountry: "auto",
  ipinfoToken: "yolo",
  nationalMode: false,
  numberType: "MOBILE",
  // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
  // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
  preventInvalidNumbers: true,
  separateDialCode: false,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get(
      "https://ipinfo.io?token=ee8a1ac0f823c9",
      function () {},
      "jsonp"
    ).always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
});



var reset = function () {
  mobile.removeClass("error");
  // errorMsg.addClass("hide");
  // validMsg.addClass("hide");
};

// on blur: validate
mobile.blur(function () {
  reset();
  if ($.trim(mobile.val())) {
    if (mobile.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
    } else {
      mobile.addClass("error");
      errorMsg.removeClass("hide");
    }
  }
});

// on keyup / change flag: reset
mobile.on("keyup change", reset);

var mobile = $("#dmobile");

// initialise plugin
mobile.intlTelInput({
  allowExtensions: true,
  formatOnDisplay: true,
  autoFormat: true,
  autoHideDialCode: true,
  autoPlaceholder: true,
  defaultCountry: "auto",
  ipinfoToken: "yolo",
  nationalMode: false,
  numberType: "MOBILE",
  // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
  // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
  preventInvalidNumbers: true,
  separateDialCode: false,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get(
      "https://ipinfo.io?token=ee8a1ac0f823c9",
      function () {},
      "jsonp"
    ).always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
});

var reset = function () {
  mobile.removeClass("error");
  // errorMsg.addClass("hide");
  // validMsg.addClass("hide");
};

// on blur: validate
mobile.blur(function () {
  reset();
  if ($.trim(mobile.val())) {
    if (mobile.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
    } else {
      mobile.addClass("error");
      errorMsg.removeClass("hide");
    }
  }
});

// on keyup / change flag: reset
mobile.on("keyup change", reset);

var contact_number = $("#contact_number");

// initialise plugin
contact_number.intlTelInput({
  allowExtensions: true,
  formatOnDisplay: true,
  autoFormat: true,
  autoHideDialCode: true,
  autoPlaceholder: true,
  defaultCountry: "auto",
  ipinfoToken: "yolo",
  nationalMode: false,
  numberType: "MOBILE",
  // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
  // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
  preventInvalidNumbers: true,
  separateDialCode: false,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get(
      "https://ipinfo.io?token=ee8a1ac0f823c9",
      function () {},
      "jsonp"
    ).always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
});

var sos_number = $("#sos_number");

// initialise plugin
sos_number.intlTelInput({
  allowExtensions: true,
  formatOnDisplay: true,
  autoFormat: true,
  autoHideDialCode: true,
  autoPlaceholder: true,
  defaultCountry: "auto",
  ipinfoToken: "yolo",
  nationalMode: false,
  numberType: "MOBILE",
  // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
  // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
  preventInvalidNumbers: true,
  separateDialCode: false,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get(
      "https://ipinfo.io?token=ee8a1ac0f823c9",
      function () {},
      "jsonp"
    ).always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
});


var contact_number = $("#contact_number");

// initialise plugin
contact_number.intlTelInput({
  allowExtensions: true,
  formatOnDisplay: true,
  autoFormat: true,
  autoHideDialCode: true,
  autoPlaceholder: true,
  defaultCountry: "auto",
  ipinfoToken: "yolo",
  nationalMode: false,
  numberType: "MOBILE",
  // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
  // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
  preventInvalidNumbers: true,
  separateDialCode: false,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get(
      "https://ipinfo.io?token=ee8a1ac0f823c9",
      function () {},
      "jsonp"
    ).always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
});

var sos_number = $("#sos_number");

// initialise plugin
sos_number.intlTelInput({
  allowExtensions: true,
  formatOnDisplay: true,
  autoFormat: true,
  autoHideDialCode: true,
  autoPlaceholder: true,
  defaultCountry: "auto",
  ipinfoToken: "yolo",
  nationalMode: false,
  numberType: "MOBILE",
  // onlyCountries: ['bn', 'us', 'gb', 'ch', 'ca', 'do','pk'],
  // preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma', 'pk'],
  preventInvalidNumbers: true,
  separateDialCode: false,
  initialCountry: "auto",
  geoIpLookup: function (callback) {
    $.get(
      "https://ipinfo.io?token=ee8a1ac0f823c9",
      function () {},
      "jsonp"
    ).always(function (resp) {
      var countryCode = resp && resp.country ? resp.country : "";
      callback(countryCode);
    });
  },
  utilsScript:
    "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js",
});