
export function styleToString(style) {
    var elm = new Option;
    Object.keys(style).forEach(function (a) {
        elm.style[ a ] = style[ a ];
    });
    return elm.getAttribute('style');
}
