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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/login.js":
/*!*******************************!*\
  !*** ./resources/js/login.js ***!
  \*******************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
 // Class Definition

var KTLoginV1 = function () {
  var login = $('#kt_login');

  var showErrorMsg = function showErrorMsg(form, type, msg) {
    var alert = $('<div class="alert alert-bold alert-solid-' + type + ' alert-dismissible" role="alert">\
			<div class="alert-text">' + msg + '</div>\
			<div class="alert-close">\
                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
            </div>\
		</div>');
    form.find('.alert').remove();
    alert.prependTo(form);
    KTUtil.animateClass(alert[0], 'fadeIn animated');
  }; // Private Functions


  var handleSignInFormSubmit = function handleSignInFormSubmit() {} // $('#kt_login_signin_submit').click(function (e) {
  // 	e.preventDefault();
  // 	var btn = $(this);
  // 	var form = $('#kt_login_form');
  // 	form.validate({
  // 		rules: {
  // 			username: {
  // 				required: true
  // 			},
  // 			password: {
  // 				required: true
  // 			}
  // 		}
  // 	});
  // 	if (!form.valid()) {
  // 		return;
  // 	}
  // 	KTApp.progress(btn[0]);
  // 	setTimeout(function () {
  // 		KTApp.unprogress(btn[0]);
  // 	}, 2000);
  // 	// ajax form submit:  http://jquery.malsup.com/form/
  // 	form.ajaxSubmit({
  // 		url: '',
  // 		success: function (response, status, xhr, $form) {
  // 			// similate 2s delay
  // 			setTimeout(function () {
  // 				KTApp.unprogress(btn[0]);
  // 				showErrorMsg(form, 'danger', 'Incorrect username or password. Please try again.');
  // 			}, 2000);
  // 		}
  // 	});
  // });
  // Public Functions
  ;

  return {
    // public functions
    init: function init() {
      handleSignInFormSubmit();
    }
  };
}(); // Class Initialization


jQuery(document).ready(function () {
  KTLoginV1.init();
});

/***/ }),

/***/ 1:
/*!*************************************!*\
  !*** multi ./resources/js/login.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! Z:\PHP\www\ecn-edt\resources\js\login.js */"./resources/js/login.js");


/***/ })

/******/ });