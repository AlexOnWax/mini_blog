"use strict";
(self["webpackChunk"] = self["webpackChunk"] || []).push([["app"],{

/***/ "./assets/app.js":
/*!***********************!*\
  !*** ./assets/app.js ***!
  \***********************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! core-js/modules/es.object.to-string.js */ "./node_modules/core-js/modules/es.object.to-string.js");
/* harmony import */ var core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_object_to_string_js__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! core-js/modules/es.promise.js */ "./node_modules/core-js/modules/es.promise.js");
/* harmony import */ var core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(core_js_modules_es_promise_js__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _styles_app_scss__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./styles/app.scss */ "./assets/styles/app.scss");


//import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */

document.addEventListener('click', function (event) {
  if (event.target.matches('.like-button')) {
    event.preventDefault();
    console.log('test click');
    var url = event.target.href;
    fetch(url, {
      method: 'GET',
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    }).then(function (response) {
      return response.json();
    }).then(function (data) {
      if (data.liked) {
        event.target.classList.add('liked');
      } else {
        event.target.classList.remove('liked');
      }
      event.target.nextElementSibling.innerText = data.likesCount;
    })["catch"](function (error) {
      return console.error('Error:', error);
    });
  }
});

/***/ }),

/***/ "./assets/styles/app.scss":
/*!********************************!*\
  !*** ./assets/styles/app.scss ***!
  \********************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin


/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ __webpack_require__.O(0, ["vendors-node_modules_core-js_modules_es_object_to-string_js-node_modules_core-js_modules_es_p-2a1352"], () => (__webpack_exec__("./assets/app.js")));
/******/ var __webpack_exports__ = __webpack_require__.O();
/******/ }
]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJmaWxlIjoiYXBwLmpzIiwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7Ozs7Ozs7O0FBQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDMkI7QUFFM0JBLFFBQVEsQ0FBQ0MsZ0JBQWdCLENBQUMsT0FBTyxFQUFFLFVBQVNDLEtBQUssRUFBRTtFQUMvQyxJQUFJQSxLQUFLLENBQUNDLE1BQU0sQ0FBQ0MsT0FBTyxDQUFDLGNBQWMsQ0FBQyxFQUFFO0lBQ3RDRixLQUFLLENBQUNHLGNBQWMsQ0FBQyxDQUFDO0lBQ3RCQyxPQUFPLENBQUNDLEdBQUcsQ0FBQyxZQUFZLENBQUM7SUFDekIsSUFBTUMsR0FBRyxHQUFHTixLQUFLLENBQUNDLE1BQU0sQ0FBQ00sSUFBSTtJQUU3QkMsS0FBSyxDQUFDRixHQUFHLEVBQUU7TUFDUEcsTUFBTSxFQUFFLEtBQUs7TUFDYkMsT0FBTyxFQUFFO1FBQ0wsa0JBQWtCLEVBQUU7TUFDeEI7SUFDSixDQUFDLENBQUMsQ0FBQ0MsSUFBSSxDQUFDLFVBQUFDLFFBQVE7TUFBQSxPQUFJQSxRQUFRLENBQUNDLElBQUksQ0FBQyxDQUFDO0lBQUEsRUFBQyxDQUMvQkYsSUFBSSxDQUFDLFVBQUFHLElBQUksRUFBSTtNQUNWLElBQUlBLElBQUksQ0FBQ0MsS0FBSyxFQUFFO1FBQ1pmLEtBQUssQ0FBQ0MsTUFBTSxDQUFDZSxTQUFTLENBQUNDLEdBQUcsQ0FBQyxPQUFPLENBQUM7TUFDdkMsQ0FBQyxNQUFNO1FBQ0hqQixLQUFLLENBQUNDLE1BQU0sQ0FBQ2UsU0FBUyxDQUFDRSxNQUFNLENBQUMsT0FBTyxDQUFDO01BQzFDO01BQ0FsQixLQUFLLENBQUNDLE1BQU0sQ0FBQ2tCLGtCQUFrQixDQUFDQyxTQUFTLEdBQUdOLElBQUksQ0FBQ08sVUFBVTtJQUMvRCxDQUFDLENBQUMsU0FBTSxDQUFDLFVBQUFDLEtBQUs7TUFBQSxPQUFJbEIsT0FBTyxDQUFDa0IsS0FBSyxDQUFDLFFBQVEsRUFBRUEsS0FBSyxDQUFDO0lBQUEsRUFBQztFQUN6RDtBQUNKLENBQUMsQ0FBQzs7Ozs7Ozs7Ozs7QUM5QkYiLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9hc3NldHMvYXBwLmpzIiwid2VicGFjazovLy8uL2Fzc2V0cy9zdHlsZXMvYXBwLnNjc3MiXSwic291cmNlc0NvbnRlbnQiOlsiLy9pbXBvcnQgJy4vYm9vdHN0cmFwLmpzJztcbi8qXG4gKiBXZWxjb21lIHRvIHlvdXIgYXBwJ3MgbWFpbiBKYXZhU2NyaXB0IGZpbGUhXG4gKlxuICogVGhpcyBmaWxlIHdpbGwgYmUgaW5jbHVkZWQgb250byB0aGUgcGFnZSB2aWEgdGhlIGltcG9ydG1hcCgpIFR3aWcgZnVuY3Rpb24sXG4gKiB3aGljaCBzaG91bGQgYWxyZWFkeSBiZSBpbiB5b3VyIGJhc2UuaHRtbC50d2lnLlxuICovXG5pbXBvcnQgJy4vc3R5bGVzL2FwcC5zY3NzJztcblxuZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignY2xpY2snLCBmdW5jdGlvbihldmVudCkge1xuICAgIGlmIChldmVudC50YXJnZXQubWF0Y2hlcygnLmxpa2UtYnV0dG9uJykpIHtcbiAgICAgICAgZXZlbnQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgY29uc29sZS5sb2coJ3Rlc3QgY2xpY2snKTtcbiAgICAgICAgY29uc3QgdXJsID0gZXZlbnQudGFyZ2V0LmhyZWY7XG5cbiAgICAgICAgZmV0Y2godXJsLCB7XG4gICAgICAgICAgICBtZXRob2Q6ICdHRVQnLFxuICAgICAgICAgICAgaGVhZGVyczoge1xuICAgICAgICAgICAgICAgICdYLVJlcXVlc3RlZC1XaXRoJzogJ1hNTEh0dHBSZXF1ZXN0JyxcbiAgICAgICAgICAgIH1cbiAgICAgICAgfSkudGhlbihyZXNwb25zZSA9PiByZXNwb25zZS5qc29uKCkpXG4gICAgICAgICAgICAudGhlbihkYXRhID0+IHtcbiAgICAgICAgICAgICAgICBpZiAoZGF0YS5saWtlZCkge1xuICAgICAgICAgICAgICAgICAgICBldmVudC50YXJnZXQuY2xhc3NMaXN0LmFkZCgnbGlrZWQnKTtcbiAgICAgICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICAgICAgICBldmVudC50YXJnZXQuY2xhc3NMaXN0LnJlbW92ZSgnbGlrZWQnKTtcbiAgICAgICAgICAgICAgICB9XG4gICAgICAgICAgICAgICAgZXZlbnQudGFyZ2V0Lm5leHRFbGVtZW50U2libGluZy5pbm5lclRleHQgPSBkYXRhLmxpa2VzQ291bnQ7XG4gICAgICAgICAgICB9KS5jYXRjaChlcnJvciA9PiBjb25zb2xlLmVycm9yKCdFcnJvcjonLCBlcnJvcikpO1xuICAgIH1cbn0pOyIsIi8vIGV4dHJhY3RlZCBieSBtaW5pLWNzcy1leHRyYWN0LXBsdWdpblxuZXhwb3J0IHt9OyJdLCJuYW1lcyI6WyJkb2N1bWVudCIsImFkZEV2ZW50TGlzdGVuZXIiLCJldmVudCIsInRhcmdldCIsIm1hdGNoZXMiLCJwcmV2ZW50RGVmYXVsdCIsImNvbnNvbGUiLCJsb2ciLCJ1cmwiLCJocmVmIiwiZmV0Y2giLCJtZXRob2QiLCJoZWFkZXJzIiwidGhlbiIsInJlc3BvbnNlIiwianNvbiIsImRhdGEiLCJsaWtlZCIsImNsYXNzTGlzdCIsImFkZCIsInJlbW92ZSIsIm5leHRFbGVtZW50U2libGluZyIsImlubmVyVGV4dCIsImxpa2VzQ291bnQiLCJlcnJvciJdLCJzb3VyY2VSb290IjoiIn0=