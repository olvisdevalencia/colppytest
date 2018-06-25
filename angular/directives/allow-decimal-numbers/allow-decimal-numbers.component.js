function allowDecimalNumbersClass () {
  return {
         restrict: "A", // Only usable as an attribute of another HTML element
         require: "?ngModel",
         scope: {
             decimals: "@",
             decimalPoint: "@"
         },
         link: function (scope, element, attr, ngModel) {
             var decimalCount = parseInt(scope.decimals) || 2;
             var decimalPoint = scope.decimalPoint || ".";

             // Run when the model is first rendered and when the model is changed from code
             ngModel.$render = function() {
                 if (ngModel.$modelValue != null && ngModel.$modelValue >= 0) {
                     if (typeof decimalCount === "number") {
                         element.val(ngModel.$modelValue.toFixed(decimalCount).toString().replace(".", ","));
                     } else {
                         element.val(ngModel.$modelValue.toString().replace(".", ","));
                     }
                 }
             }

             // Run when the view value changes - after each keypress
             // The returned value is then written to the model
             ngModel.$parsers.unshift(function(newValue) {
                 if (typeof decimalCount === "number") {
                     var floatValue = parseFloat(newValue.replace(",", "."));
                     if (decimalCount === 0) {
                         return parseInt(floatValue);
                     }
                     return parseFloat(floatValue.toFixed(decimalCount));
                 }

                 return parseFloat(newValue.replace(",", "."));
             });

             // Formats the displayed value when the input field loses focus
             element.on("change", function(e) {
                 var floatValue = parseFloat(element.val().replace(",", "."));
                 if (!isNaN(floatValue) && typeof decimalCount === "number") {
                     if (decimalCount === 0) {
                         element.val(parseInt(floatValue));
                     } else {
                         var strValue = floatValue.toFixed(decimalCount);
                         element.val(strValue.replace(".", decimalPoint));
                     }
                 }
             });

             // Only let numbers and not letters
             element.on("keydown", function(e) {

               // Allow: backspace, delete, tab, escape, enter and dot .
               if ($.inArray(e.keyCode, [46, 8, 9, 27, 13,110,190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                   (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                    // Allow: home, end, left, right, down, up
                   (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                   }
               // Ensure that it is a number and stop the keypress
               if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                   e.preventDefault();
               }

             });
         }
     }
}

export const AllowDecimalNumbersClassComponent = allowDecimalNumbersClass
