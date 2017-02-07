/* global Pyro */

+ (function (Pyro, document) {

  var
    togglersSelector = '[data-toggle="lang"]',
    groupWrapperSelector = '.btn-group',
    dropdownTogglerSelector = '.dropdown-toggle',
    dropdownMenuSelector = '.dropdown-menu',
    localeAttribute = 'lang',
    formWrapperSelector = 'form',
    localeSelector = '.form-group',

    getLocaleByCode = function (locale) {
      return localeSelector + '[' + localeAttribute + '="' + locale + '"]';
    };

  document.addEventListener('DOMContentLoaded', function () {
    var togglers = document.querySelectorAll(togglersSelector);

    togglers.forEach(function (toggler) {
      toggler.addEventListener('click', function (e) {
        e.preventDefault();

        var
          locale = e.target.getAttribute(localeAttribute),
          form = Pyro.closest(e.target, formWrapperSelector),
          groupes = form.querySelectorAll(groupWrapperSelector),
          toggles = Pyro.find(groupes, dropdownTogglerSelector),
          dropdowns = Pyro.find(groupes, dropdownMenuSelector);

        toggles.forEach(function (el) {
          el.innerText = e.target.innerText;
        });

        dropdowns.forEach(function (el) {
          el.querySelector('a').classList.remove('active');
        });

        e.target.classList.add('active');

        form.querySelectorAll(localeSelector + '[' + localeAttribute + ']')
        .forEach(function (el) {
          el.classList.add('hidden');
        });

        form.querySelectorAll(getLocaleByCode(locale))
        .forEach(function (el) {
          el.classList.remove('hidden');
        });

      });
    });
  });

})(Pyro, document);
