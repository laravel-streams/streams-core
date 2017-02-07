var Pyro = {
  closest: function (el, selector) {
    var matchesSelector = el.matches || el.webkitMatchesSelector ||
      el.mozMatchesSelector || el.msMatchesSelector;

    while (el) {
      if (matchesSelector.call(el, selector)) {
        break;
      }
      el = el.parentElement;
    }
    return el;
  },
  find: function (list, selector) {
    var out = [];

    list.forEach(function (item) {
      out.push(item.querySelector(selector));
    });

    return out;
  }
};
