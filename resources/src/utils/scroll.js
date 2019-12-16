/**
 * @see https://raw.githubusercontent.com/quasarframework/quasar/dev/src/utils/scroll.js
 * @copyright Quasar Framework
 */
import {keyBy, map, mapValues, reverse, sortBy} from 'lodash';

export function getScrollWidth(el) {
    return (el === window ? document.body : el).scrollWidth;
}


export function getHorizontalScrollPosition(scrollTarget) {
    if ( scrollTarget === window ) {
        return window.pageXOffset || window.scrollX || document.body.scrollLeft || 0;
    }
    return scrollTarget.scrollLeft;
}

export function animHorizontalScrollTo(el, to, duration) {
    const pos = getHorizontalScrollPosition(el);

    if ( duration <= 0 ) {
        if ( pos !== to ) {
            setHorizontalScroll(el, to);
        }
        return;
    }

    requestAnimationFrame(() => {
        const newPos = pos + (to - pos) / Math.max(16, duration) * 16;
        setHorizontalScroll(el, newPos);
        if ( newPos !== to ) {
            animHorizontalScrollTo(el, to, duration - 16);
        }
    });
}

function setHorizontalScroll(scrollTarget, offset) {
    if ( scrollTarget === window ) {
        window.scrollTo(offset, 0);
        return;
    }
    scrollTarget.scrollLeft = offset;
}

export function setHorizontalScrollPosition(scrollTarget, offset, duration) {
    if ( duration ) {
        animHorizontalScrollTo(scrollTarget, offset, duration);
        return;
    }
    setHorizontalScroll(scrollTarget, offset);
}

let size;

export function getScrollbarWidth() {
    if ( size !== undefined ) {
        return size;
    }

    const
        inner = document.createElement('p'),
        outer = document.createElement('div');

    inner.style = {
        ...inner.style,
        width : '100%',
        height: '200px'
    };
    outer.style = {
        ...outer.style,
        position  : 'absolute',
        top       : '0px',
        left      : '0px',
        visibility: 'hidden',
        width     : '200px',
        height    : '150px',
        overflow  : 'hidden'
    };

    outer.appendChild(inner);

    document.body.appendChild(outer);

    let w1 = inner.offsetWidth;
    outer.style.overflow = 'scroll';
    let w2 = inner.offsetWidth;

    if ( w1 === w2 ) {
        w2 = outer.clientWidth;
    }

    outer.remove();
    size = w1 - w2;

    return size;
}



/**
 *
 * @param {Element|node} el
 * @param {string} selector
 * @return {Element|Window}
 */
export function getScrollTarget(el, selector) {
    return (el).closest(selector || '.c-scrollbar') || window;
}

export function getScrollHeight(el) {
    return (el === window ? document.body : el).scrollHeight;
}

export function getScrollPosition(scrollTarget) {
    if ( scrollTarget === window ) {
        return window.pageYOffset || window.scrollY || document.body.scrollTop || 0;
    }
    return scrollTarget.scrollTop;
}

export function animScrollTo(el, to, duration) {
    if ( duration <= 0 ) {
        return;
    }

    const pos = getScrollPosition(el);

    window.requestAnimationFrame(() => {
        setScroll(el, pos + (to - pos) / duration * 16);
        if ( el.scrollTop !== to ) {
            animScrollTo(el, to, duration - 16);
        }
    });
}

/**
 *
 * @param {Function|()=>number} getScrollPosition
 * @param {Function|(pos: number) => any} setScrollPosition
 * @param {number} offset
 * @param {number} duration
 */
export function animScrollToFn(getScrollPosition, setScrollPosition, offset, duration = 1000) {
    if ( duration <= 0 ) {
        return;
    }

    let pos = getScrollPosition();

    window.requestAnimationFrame(() => {
        setScrollPosition(pos + (offset - pos) / duration * 16);
        pos = getScrollPosition();
        if ( pos !== offset ) {
            animScrollToFn(getScrollPosition, setScrollPosition, offset, duration - 16);
        }
    });
}

function setScroll(scrollTarget, offset) {
    if ( scrollTarget === window ) {
        document.documentElement.scrollTop = offset;
        document.body.scrollTop = offset;
        return;
    }
    scrollTarget.scrollTop = offset;
}

export function setScrollPosition(scrollTarget, offset, duration) {
    if ( duration ) {
        animScrollTo(scrollTarget, offset, duration);
        return;
    }
    setScroll(scrollTarget, offset);
}


export function hasScrollbar(el) {
    if ( !el || el.nodeType !== Node.ELEMENT_NODE ) {
        return false;
    }

    return (
        el.classList.contains('scroll') ||
        ['auto', 'scroll'].includes(window.getComputedStyle(el)['overflow-y'])
    ) && el.scrollHeight > el.clientHeight;
}

const log = require('debug')('utils:scroll');


const sortByValues = (object, _reverse = false) => {
    object = map(object, (val, key) => ({name: key, count: val}));
    object = sortBy(object, 'count');
    if ( _reverse ) object = reverse(object);
    object = keyBy(object, 'name');
    object = mapValues(object, 'count');
    return object;
};



/**
 *
 * @param {string | number | HTMLElement} _scrollTo
 * @param {number} scrollOffset
 * @param {number} scrollDuration duration in ms
 * @return {*}
 */
export function scrollTo(_scrollTo, scrollOffset = 0, scrollDuration = 1000) {
    let scrollTo = _scrollTo;

    let def = defer();
    // polyfill
    if ( 'performance' in window == false ) {
        (window)['performance'] = {};
    }

    if ( 'now' in window.performance == false ) {
        Date.now = (Date.now || function () {  // thanks IE8
            return new Date().getTime();
        });


        let nowOffset = Date.now();

        if ( performance.timing && performance.timing.navigationStart ) {
            nowOffset = performance.timing.navigationStart;
        }

        window.performance.now = function now() {
            return Date.now() - nowOffset;
        };
    }
    //
    // Set a default for where we're scrolling to
    //

    if ( typeof scrollTo === 'string' ) {

        // Assuming this is a selector we can use to find an element
        let scrollToObj = $(scrollTo).get(0);

        if ( scrollToObj && typeof scrollToObj.getBoundingClientRect === 'function' ) {
            scrollTo = window.pageYOffset + scrollToObj.getBoundingClientRect().top;
        } else {
            throw 'error: No element found with the selector "' + scrollTo + '"';
        }
    } else if ( typeof scrollTo !== 'number' ) {

        // If it's nothing above and not an integer, we assume top of the window
        scrollTo = 0;
    } else {
        let scrollToObj = $(scrollTo).get(0);
        if ( scrollToObj && typeof scrollToObj.getBoundingClientRect === 'function' ) {
            scrollTo = window.pageYOffset + scrollToObj.getBoundingClientRect().top;
        } else {
            throw 'error: No element found with the selector "' + scrollTo + '"';
        }
    }

    scrollTo += scrollOffset;
    // Set this a bit higher

    const anchorHeightAdjust = 30;
    if ( scrollTo > anchorHeightAdjust ) {
        scrollTo = scrollTo - anchorHeightAdjust;
    }

    // Declarations

    const cosParameter = (window.pageYOffset - scrollTo) / 2;
    let scrollCount  = 0,
        oldTimestamp = window.performance.now();

    function step(newTimestamp) {

        let tsDiff = newTimestamp - oldTimestamp;

        // Performance.now() polyfill loads late so passed-in timestamp is a larger offset
        // on the first go-through than we want so I'm adjusting the difference down here.
        // Regardless, we would rather have a slightly slower animation than a big jump so a good
        // safeguard, even if we're not using the polyfill.

        if ( tsDiff > 100 ) {
            tsDiff = 30;
        }

        scrollCount += Math.PI / (scrollDuration / tsDiff);

        // As soon  cross over Pi, we're about where we need to be

        if ( scrollCount >= Math.PI ) {
            return def.resolve();
        }

        const moveStep = Math.round((scrollTo) + cosParameter + cosParameter * Math.cos(scrollCount));
        window.scrollTo(0, moveStep);
        oldTimestamp = newTimestamp;
        window.requestAnimationFrame(step);
    }

    window.requestAnimationFrame(step);
    return def.promise;
}


// export class ScrollSpyHelper {
//     protected targets: ZeptoMap<TargetID>              = {};
//     protected items: ZeptoMap<ItemID>                  = {};
//     protected scrollListener: (event: UIEvent) => void = null;
//     protected targetItems: Targets2Items               = {};
//
//     constructor(protected itemTargets: Items2Targets, protected offset: number = 0, protected el: Element | Window = window) {
//         this.itemIds.forEach(itemID => {
//             itemID                       = strStripLeft(itemID, '#');
//             let targetID                 = itemTargets[ itemID ];
//             this.targetItems[ targetID ] = itemID;
//             this.items[ itemID ]         = $(strEnsureLeft(itemID, '#'));
//         });
//         this.targetIds.forEach(targetID => {
//             targetID                 = strStripLeft(targetID, '#');
//             this.targets[ targetID ] = $(strEnsureLeft(targetID, '#'));
//         });
//     }
//
//     get itemIds(): string[] { return Object.keys(this.itemTargets); }
//
//     get targetIds(): string[] { return this.itemIds.map(listItemId => this.itemTargets[ listItemId ]); }
//
//     getScrollPosition(): number {return getScrollPosition(this.el); }
//
//     getTargetPosition(targetID: TargetID): number { return this.getTarget(targetID).offset().top; }
//
//     getItem(itemID: ItemID): JQuery {return this.items[ strStripLeft(itemID, '#') ];}
//
//     getTarget(targetID: TargetID): JQuery {return this.targets[ strStripLeft(targetID, '#') ];}
//
//     item2targetID(itemID: ItemID): TargetID {return this.itemTargets[ strStripLeft(itemID, '#') ];}
//
//     target2itemID(targetID: TargetID): ItemID {return this.targetItems[ strStripLeft(targetID, '#') ];}
//
//     getItemTarget(itemID: ItemID): JQuery {return this.targets[ this.item2targetID(itemID) ]; }
//
//     getTargetItem(targetID: TargetID): JQuery { return this.items[ this.target2itemID(targetID) ]; }
//
//     getTargetPositions = debounce(()=> {
//         let positions = {};
//
//         ''.trimLeft()
//         this.targetIds.forEach(targetID => {
//             positions[ targetID ] = this.getTargetPosition(targetID);
//         });
//         return positions;
//     },100, { leading: true, trailing: true })
//
//     hasPassedTarget(targetID: TargetID, offset: number = 0) {
//         let position       = this.getScrollPosition();
//         let targetPosition = this.getTargetPosition(targetID);
//         return (position + offset) > targetPosition;
//     }
//
//     getSortedTargetPositions(direction: 'asc' | 'desc' = 'asc') { return sortByValues(this.getTargetPositions(), direction === 'desc'); }
//
//     getHighestPassedPositionTargetID(): TargetID | null {
//         let position        = this.getScrollPosition();
//         let sortedPositions = this.getSortedTargetPositions();
//         let highestTargetID = null;
//         for ( const targetID in sortedPositions ) {
//             const targetPosition = sortedPositions[ targetID ];
//             if ( (position + this.offset) > targetPosition ) {
//                 highestTargetID = targetID;
//                 continue;
//             }
//             break;
//         }
//         return highestTargetID;
//     }
//
//     start(startupDelay: number = 1000) {
//         if ( ! this.scrollListener ) {
//             let highestTargetID = null;
//             this.scrollListener = event => {
//                 let pos                    = this.getScrollPosition();
//                 let currentHighestTargetID = this.getHighestPassedPositionTargetID();
//                 if ( highestTargetID !== currentHighestTargetID ) {
//                     highestTargetID = currentHighestTargetID;
//                     this.onChangeCallback(highestTargetID, highestTargetID ? this.target2itemID(highestTargetID) : null);
//                 }
//             };
//         }
//
//         setTimeout(() => {
//             this.el.addEventListener('scroll', this.scrollListener);
//         }, startupDelay);
//     }
//
//     stop() {
//         if ( this.scrollListener ) {
//             this.el.removeEventListener('scroll', this.scrollListener);
//             this.scrollListener = null;
//         }
//     }
//
//     protected onChangeCallback: OnChangeCallback = () => null;
//
//     onChange(cb: OnChangeCallback) {
//         this.onChangeCallback = cb;
//     }
// }
