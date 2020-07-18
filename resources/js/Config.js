import { cloneDeep, get, has, merge, set, unset } from 'lodash';
import { toJS } from './utils/toJS';

export class Config {
    /** @var {Application} app */
    static app;

    constructor(data = {}) {
        this.data = data;
    }

    get = (path, defaultValue) => get(this.data, path, defaultValue);
    set = (path, value) => set(this.data, path, value);
    has = (path) => has(this.data, path);
    unset = (path) => unset(this.data, path);
    merge = (value) => merge(this.data, value);
    mergeAt = (path, value) => this.set(path, merge({}, this.get(path, {}), value));
    pushTo = (path, ...items) => this.set(path, this.get(path, []).concat(items));
    raw = () => this.data;
    getClone = (path, defaultValue = {}) => (path ? cloneDeep(this.get(path, defaultValue)) : cloneDeep(this.raw()));
    toJS = (path) => path ? toJS(get(this.data, path)) : toJS(this.data);

    proxy = (path) => {
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
