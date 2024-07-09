(function () {
  var vendors = ["webkit", "moz"];
  for (var i = 0; i < vendors.length && !window.requestAnimationFrame; i++) {
    var vp = vendors[i];
    window.requestAnimationFrame = window[vp + "RequestAnimationFrame"];
    window.cancelAnimationFrame =
      window[vp + "CancelAnimationFrame"] ||
      window[vp + "CancelRequestAnimationFrame"];
  }
  if (
    /iP(ad|hone|od).*OS 6/.test(window.navigator.userAgent) ||
    !window.requestAnimationFrame ||
    !window.cancelAnimationFrame
  ) {
    var lastTime = 0;
    window.requestAnimationFrame = function (callback) {
      var now = Date.now();
      var nextTime = Math.max(lastTime + 16, now);
      return setTimeout(function () {
        callback((lastTime = nextTime));
      }, nextTime - now);
    };
    window.cancelAnimationFrame = clearTimeout;
  }
})();

(function (window) {
  "use strict";

  function classReg(className) {
    return new RegExp("(^|\\s+)" + className + "(\\s+|$)");
  }

  var has, add, remove;

  if ("classList" in document.documentElement) {
    has = function (elem, c) {
      return elem.classList.contains(c);
    };
    add = function (elem, c) {
      elem.classList.add(c);
    };
    remove = function (elem, c) {
      elem.classList.remove(c);
    };
  } else {
    has = function (elem, c) {
      return classReg(c).test(elem.className);
    };
    add = function (elem, c) {
      if (!hasClass(elem, c)) {
        elem.className = elem.className + " " + c;
      }
    };
    remove = function (elem, c) {
      elem.className = elem.className.replace(classReg(c), " ");
    };
  }

  function toggle(elem, c) {
    var fn = has(elem, c) ? remove : add;
    fn(elem, c);
  }

  var classie = {
    has: has,
    add: add,
    remove: remove,
    toggle: toggle,
  };

  if (typeof define === "function" && define.amd) {
    define(classie);
  } else if (typeof exports === "object") {
    module.exports = classie;
  } else {
    window.classie = classie;
  }
})(window);

var banner = (function () {
  // Find all select elements
  var header = document.querySelector(".banner-wrapper");

  if (header) {
    var init = function () {
      // Assignment
      var image = header.querySelector(".banner-image"),
        bannerImage = make("span", "banner-image"),
        lastPosition = -1,
        transform = prefix(["transform", "msTransform", "WebkitTransform"]);
      // Set background src to original
      bannerImage.style.backgroundImage = "url( " + image.src + " )";
      // And insert faux image after original image
      insertAfter(image, bannerImage);
      // Hide reference image
      image.style.display = "none";
      // Set header background to reference image
      header.style.backgroundImage = image.src;
      // Scroll handler function
      function scrollHandler() {
        // Calculate real & parallax scroll position
        var realPosition = window.pageYOffset,
          bannerPosition = Math.round(realPosition * 0.5);
        // Where the magic happens
        bannerImage.style[transform] = "translateY( " + bannerPosition + "px )";
      }
      // Prefixer function
      function prefix(properties) {
        for (var i = 0; i < properties.length; i++) {
          if (properties[i] in document.documentElement.style) {
            return properties[i];
          }
        }
      }

      function make(elemType, newClass) {
        var newElem = document.createElement(elemType);
        classie.add(newElem, newClass);
        return newElem;
      }

      function insertAfter(refElem, newElem) {
        refElem.parentNode.insertBefore(newElem, refElem.nextSibling);
      }
      // Instantiation
      function loop() {
        if (lastPosition == window.pageYOffset) {
          window.requestAnimationFrame(loop);
          return false;
        } else {
          lastPosition = window.pageYOffset;
          scrollHandler();
        }
        window.requestAnimationFrame(loop);
      }
      // Call the loop for the first time
      loop();
    };
    init();
  }
})();
