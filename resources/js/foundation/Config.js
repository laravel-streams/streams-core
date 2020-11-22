// noinspection ES6UnusedImports
import {cloneDeep, get, has, merge, set, unset} from 'lodash';

export function toJS(v) {
    return JSON.parse(JSON.stringify(v));
}

export class Config {
    constructor(data = {}) {
        this.data = data;
        this.get = (path, defaultValue) => get(this.data, path, defaultValue);
        this.set = (path, value) => set(this.data, path, value);
        this.has = (path) => has(this.data, path);
        this.unset = (path) => unset(this.data, path);
        this.merge = (value) => merge(this.data, value);
        this.mergeAt = (path, value) => this.set(path, merge({}, this.get(path, {}), value));
        this.pushTo = (path, ...items) => this.set(path, this.get(path, []).concat(items));
        this.raw = () => this.data;
        this.getClone = (path, defaultValue = {}) => (path ? cloneDeep(this.get(path, defaultValue)) : cloneDeep(this.raw()));
        this.toJS = (path) => path ? toJS(get(this.data, path)) : toJS(this.data);
        this.proxy = (path) => {
            const prefix = (p) => path + '.' + p.toString();
            return new Proxy(this, {
                get(target, p, receiver) {
                    if ( target.has(prefix(p)) ) {
                        return target.get(prefix(p));
                    }
                    return target[p];
                },
                set(target, p, value, receiver) {
                    target.set(prefix(p), value);
                    return true;
                },
                has(target, p) {
                    return target.has(prefix(p));
                }
            });
        };
    }

    static proxied(data) {
        return new Proxy(new Config(data), {
            get(target, p, receiver) {
                if ( target.has(p.toString()) ) {
                    return target.get(p.toString());
                }
                return target[p];
            },
            set(target, p, value, receiver) {
                target.set(p.toString(), value);
                return true;
            },
            has(target, p) {
                return target.has(p.toString());
            }
        });
    }
}

var INJECTION = Symbol.for('INJECTION');

function _proxyGetter(proto, key, resolve, doCache) {
    function getter() {
        if ( doCache && !Reflect.hasMetadata(INJECTION, this, key) ) {
            Reflect.defineMetadata(INJECTION, resolve(), this, key);
        }
        if ( Reflect.hasMetadata(INJECTION, this, key) ) {
            return Reflect.getMetadata(INJECTION, this, key);
        } else {
            return resolve();
        }
    }

    function setter(newVal) {
        Reflect.defineMetadata(INJECTION, newVal, this, key);
    }

    Object.defineProperty(proto, key, {
        configurable: true,
        enumerable  : true,
        get         : getter,
        set         : setter
    });
}

export function configProxy(path) {
    return (proto, key) => {
        var resolve = function () {
            let config = Config.app.get('config');
            return config.proxy(path);
        };
        _proxyGetter(proto, key, resolve, true);
    };
}

export function configValue(path) {
    return (proto, key) => {
        var resolve = function () {
            let config = Config.app.get('config');
            return config.get(path);
        };
        _proxyGetter(proto, key, resolve, false);
    };
}

//# sourceMappingURL=Config.js.map
