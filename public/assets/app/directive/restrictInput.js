functionalfoodsApp.directive('restrictInput', function() {
  return {
    restrict: 'A',
    require: 'ngModel',
    link: function(scope, element, attr, ctrl) {
      ctrl.$parsers.unshift(function(viewValue) {
        var options = scope.$eval(attr.restrictInput);
        if (!options.regex && options.type) {
          switch (options.type) {
            case 'digits-only': options.regex = '^[0-9]*$'; break;
            case 'letters-only': options.regex = "^[a-zñA-ZÑ ,.'-]*$"; break;
            case 'lowercase-letters-only': options.regex = '^[a-zñ ]*$'; break;
            case 'uppercase-letters-only': options.regex = '^[A-ZÑ ]*$'; break;
            case 'letters-and-digits-only': options.regex = '^[a-zñA-ZÑ0-9 ]*$'; break;
            case 'valid-name-chars-only': options.regex = "^[a-zA-Z ,.'-]*$"; break;
            case 'valid-address-chars-only': options.regex = "^[a-zñA-ZÑ0-9 ,.'-/#]*$"; break;
            case 'valid-phone-chars-only': options.regex = '^[0-9 +()/-]*$'; break;
            default: options.regex = '';
          }
        }
        var reg = new RegExp(options.regex);
        if (reg.test(viewValue)) { //if valid view value, return it
          return viewValue;
        } else { //if not valid view value, use the model value (or empty string if that's also invalid)
          var overrideValue = (reg.test(ctrl.$modelValue) ? ctrl.$modelValue : '');
          element.val(overrideValue);
          return overrideValue;
        }
      });
    }
  };
});
