
let kindsOf = {};
'Number String Boolean Function RegExp Array Date Error'.split(' ').forEach(function (k) {
    kindsOf['[object ' + k + ']'] = k.toLowerCase();
});

export function kindOf(value) {
    // Null or undefined.
    if ( value == null ) {
        return String(value);
    }
    // Everything else.
    return kindsOf[kindsOf.toString.call(value)] || 'object';
}


export const isNumber = (value) => kindOf(value) === 'number';
export const isString = (value) => kindOf(value) === 'string';
export const isBoolean = (value) => kindOf(value) === 'boolean';
export const isFunction = (value) => kindOf(value) === 'function';
export const isRegExp = (value) => kindOf(value) === 'regexp';
export const isArray = (value) => kindOf(value) === 'array';
export const isDate = (value) => kindOf(value) === 'date';
export const isError = (value) => kindOf(value) === 'error';
export const isObject = (value) => kindOf(value) === 'object';