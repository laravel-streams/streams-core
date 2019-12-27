/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/cp/click.js":
/*!**********************************!*\
  !*** ./resources/js/cp/click.js ***!
  \**********************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _nonIterableRest(); }\n\nfunction _nonIterableRest() { throw new TypeError(\"Invalid attempt to destructure non-iterable instance\"); }\n\nfunction _iterableToArrayLimit(arr, i) { if (!(Symbol.iterator in Object(arr) || Object.prototype.toString.call(arr) === \"[object Arguments]\")) { return; } var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i[\"return\"] != null) _i[\"return\"](); } finally { if (_d) throw _e; } } return _arr; }\n\nfunction _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }\n\n(function (window, document) {\n  /**\n   * Make sure it's a click command.\n   */\n  var match = document.location.hash.match(/^#click:(.*)$/);\n\n  if (!(match && match.length > 1)) {\n    return;\n  }\n  /**\n   * Grab the selector and make sure we have a target.\n   */\n\n\n  var _match = _slicedToArray(match, 2),\n      selector = _match[1];\n\n  selector = decodeURIComponent(selector);\n\n  if (!selector) {\n    return;\n  }\n\n  var target = document.querySelector(selector);\n  /**\n   * If we do have a target go ahead and click it.\n   */\n\n  if (target) {\n    target.click();\n  }\n})(window, document);//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvY3AvY2xpY2suanM/ZTY3MyJdLCJuYW1lcyI6WyJ3aW5kb3ciLCJkb2N1bWVudCIsIm1hdGNoIiwibG9jYXRpb24iLCJoYXNoIiwibGVuZ3RoIiwic2VsZWN0b3IiLCJkZWNvZGVVUklDb21wb25lbnQiLCJ0YXJnZXQiLCJxdWVyeVNlbGVjdG9yIiwiY2xpY2siXSwibWFwcGluZ3MiOiI7Ozs7Ozs7O0FBQUEsQ0FBQyxVQUFVQSxNQUFWLEVBQWtCQyxRQUFsQixFQUE0QjtBQUV6Qjs7O0FBR0EsTUFBTUMsS0FBSyxHQUFHRCxRQUFRLENBQUNFLFFBQVQsQ0FBa0JDLElBQWxCLENBQXVCRixLQUF2QixDQUE2QixlQUE3QixDQUFkOztBQUVBLE1BQUksRUFBRUEsS0FBSyxJQUFJQSxLQUFLLENBQUNHLE1BQU4sR0FBZSxDQUExQixDQUFKLEVBQWtDO0FBQzlCO0FBQ0g7QUFFRDs7Ozs7QUFYeUIsOEJBY05ILEtBZE07QUFBQSxNQWNsQkksUUFka0I7O0FBZ0J6QkEsVUFBUSxHQUFHQyxrQkFBa0IsQ0FBQ0QsUUFBRCxDQUE3Qjs7QUFFQSxNQUFJLENBQUNBLFFBQUwsRUFBZTtBQUNYO0FBQ0g7O0FBRUQsTUFBTUUsTUFBTSxHQUFHUCxRQUFRLENBQUNRLGFBQVQsQ0FBdUJILFFBQXZCLENBQWY7QUFFQTs7OztBQUdBLE1BQUlFLE1BQUosRUFBWTtBQUNSQSxVQUFNLENBQUNFLEtBQVA7QUFDSDtBQUVKLENBL0JELEVBK0JHVixNQS9CSCxFQStCV0MsUUEvQlgiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvY3AvY2xpY2suanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyIoZnVuY3Rpb24gKHdpbmRvdywgZG9jdW1lbnQpIHtcblxuICAgIC8qKlxuICAgICAqIE1ha2Ugc3VyZSBpdCdzIGEgY2xpY2sgY29tbWFuZC5cbiAgICAgKi9cbiAgICBjb25zdCBtYXRjaCA9IGRvY3VtZW50LmxvY2F0aW9uLmhhc2gubWF0Y2goL14jY2xpY2s6KC4qKSQvKTtcblxuICAgIGlmICghKG1hdGNoICYmIG1hdGNoLmxlbmd0aCA+IDEpKSB7XG4gICAgICAgIHJldHVybjtcbiAgICB9XG5cbiAgICAvKipcbiAgICAgKiBHcmFiIHRoZSBzZWxlY3RvciBhbmQgbWFrZSBzdXJlIHdlIGhhdmUgYSB0YXJnZXQuXG4gICAgICovXG4gICAgbGV0IFssIHNlbGVjdG9yXSA9IG1hdGNoO1xuXG4gICAgc2VsZWN0b3IgPSBkZWNvZGVVUklDb21wb25lbnQoc2VsZWN0b3IpO1xuXG4gICAgaWYgKCFzZWxlY3Rvcikge1xuICAgICAgICByZXR1cm47XG4gICAgfVxuXG4gICAgY29uc3QgdGFyZ2V0ID0gZG9jdW1lbnQucXVlcnlTZWxlY3RvcihzZWxlY3Rvcik7XG5cbiAgICAvKipcbiAgICAgKiBJZiB3ZSBkbyBoYXZlIGEgdGFyZ2V0IGdvIGFoZWFkIGFuZCBjbGljayBpdC5cbiAgICAgKi9cbiAgICBpZiAodGFyZ2V0KSB7XG4gICAgICAgIHRhcmdldC5jbGljaygpO1xuICAgIH1cblxufSkod2luZG93LCBkb2N1bWVudCk7XG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/cp/click.js\n");

/***/ }),

/***/ 0:
/*!******************************************************************!*\
  !*** multi ./resources/js/cp/click.js ./resources/js/src/app.js ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! /Users/ryanthompson/Sites/streams.local/vendor/anomaly/streams-platform/resources/js/cp/click.js */"./resources/js/cp/click.js");
!(function webpackMissingModule() { var e = new Error("Cannot find module '/Users/ryanthompson/Sites/streams.local/vendor/anomaly/streams-platform/resources/js/src/app.js'"); e.code = 'MODULE_NOT_FOUND'; throw e; }());


/***/ })

/******/ });