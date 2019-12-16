import { camelCase, isNumber } from 'lodash';
import { isObject }            from './kindOf';

export function warn(message, ...params) {
    console.warn('[codex][core] ' + message, ...params);
}

export function uniqueId() {
    return Math.floor((1 + Math.random()) * 0x10000)
        .toString(16)
        .substring(1);
}

export function getRandomId(length=15) {
    let text       = '';
    const possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    for ( let i = 0; i < length; i ++ ) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }
    return text;
}

export function load(vNodeContext, cb) {
    if ( document.readyState === 'complete' ) {
        vNodeContext.$nextTick(() => cb());
    } else {
        document.addEventListener('DOMContentLoaded', () => cb());
    }
}

export function copy(obj){
    return JSON.parse(JSON.stringify(obj));
}

/**
 * Get the current viewport
 * @returns {{width: *, height: *}}
 */
export function getViewPort() {
    let e = window,
        a = 'inner';
    if ( ! ('innerWidth' in window) ) {
        a = 'client';
        e = document.documentElement || document.body;
    }

    return {
        width : e[ a + 'Width' ],
        height: e[ a + 'Height' ],
    };
}

/**
 * Checks if the device currently used is a touch device
 * @returns {boolean}
 */
export function isTouchDevice() {
    try {
        document.createEvent('TouchEvent');
        return true;
    } catch ( e ) {
        return false;
    }
}

/**
 *
 * @param {HTMLElement} element
 */
export function getElementHeight(element) {

    // Support: IE <=11 only
    // Running getBoundingClientRect on a
    // disconnected node in IE throws an error
    if ( ! element[ 'getClientRects' ]().length ) {
        return element.offsetHeight;
    }

    let rect = element.getBoundingClientRect();

    // Make sure element is not hidden (display: none)
    if ( rect.width || rect.height ) {
        return rect.bottom - rect.top;
    }

    // Return zeros for disconnected and hidden elements (gh-2310)
    return 0;
}


export function listen(target, eventType, callback){
    if ( target.addEventListener ) {
        target.addEventListener(eventType, callback, false);
        return {
            remove() {
                target.removeEventListener(eventType, callback, false);
            },
        };
    }
    if ( target[ 'attachEvent' ] ) {
        target[ 'attachEvent' ](`on${eventType}`, callback);
        return {
            remove() {
                target[ 'detachEvent' ](`on${eventType}`, callback);
            },
        };
    }
}

export function getScroll(w, top) {
    let ret      = w[ `page${top ? 'Y' : 'X'}Offset` ];
    const method = `scroll${top ? 'Top' : 'Left'}`;
    if ( typeof ret !== 'number' ) {
        const d = w.document;
        ret     = d.documentElement[ method ];
        if ( typeof ret !== 'number' ) {
            ret = d.body[ method ];
        }
    }
    return ret;
}

export function getOffset(element) {
    let elm  = element;
    let top  = elm.offsetTop;
    let left = elm.offsetLeft;
    while ( elm.offsetParent !== null ) {
        elm = elm.offsetParent;
        top += elm.offsetTop;
        left += elm.offsetLeft;
    }
    return {
        top,
        left,
    };
}

// check if browser support css3 transitions
export function cssTransitions() {
    if ( typeof (document) === 'undefined' )
        return false;
    const style = document.documentElement.style;
    return (
        style[ 'webkitTransition' ] !== undefined ||
        style[ 'MozTransition' ] !== undefined ||
        style[ 'OTransition' ] !== undefined ||
        style[ 'MsTransition' ] !== undefined ||
        style.transition !== undefined
    );
}

export function escapeHash(hash) {
    return hash.replace(/(:|\.|\[|\]|,|=)/g, '\\$1');
}

export function parseBool(val) {
    return val === true || val === 1 || val === 'true' || val === '1';
}



/**
 * Check if two values are loosely equal - that is,
 * if they are plain objects, do they have the same shape?
 */
export function looseEqual(a, b) {
    // eslint-disable-next-line eqeqeq
    return a == b || (
        isObject(a) && isObject(b) ? JSON.stringify(a) === JSON.stringify(b) : false
    );
}

/**
 * Check if a val exists in arr using looseEqual comparison
 */
export function looseIndexOf(arr, val) {
    for ( let i = 0; i < arr.length; i ++ ) {
        if ( looseEqual(arr[ i ], val) ) {
            return i;
        }
    }

    return - 1;
}

export function strEnsureLeft(str, left) {
    if ( false === str.startsWith(left) ) {
        return left + str;
    }
    return str;
}

export function strEnsureRight(str, right) {
    if ( false === str.endsWith(right) ) {
        return str + right;
    }
    return str;
}

export function strStripLeft(str, left) {
    if ( str.startsWith(left) ) {
        return str.substr(left.length);
    }
    return str;
}

export function strStripRight(str, right) {
    if ( str.endsWith(right) ) {
        return str.substr(0, str.length - right.length);
    }
    return str;
}

export function ucfirst(string) {
    return string[ 0 ].toUpperCase() + string.slice(1);
}

export function lcfirst(string) {
    return string[ 0 ].toLowerCase() + string.slice(1);
}


export function trace(name, ...args) {
    console.groupCollapsed(name);
    console.trace(...args);
    console.groupEnd();
}

export function keysToCamelCase(obj) {
    Object.keys(obj).forEach(key => {
        if ( key !== camelCase(key) ) {
            obj[ camelCase(key) ] = obj[ key ];
            delete obj[ key ];
        }
    });
    return obj;
}
