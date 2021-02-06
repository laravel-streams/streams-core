// noinspection ES6UnusedImports
import { cloneDeep, get, has, merge, set, unset } from 'lodash';
import { Application }                            from './Application';
import { IConfig }                                from './types';


export function toJS(v) {
    return JSON.parse(JSON.stringify(v));
}

export interface Config<T> {
    get<T>(path: string, defaultValue?: any): T;
}

export class Config<T> {
    public static app: Application;

    constructor(protected data: Partial<T> = {}) { }

    get = <T>(path: string, defaultValue?: any): T => get(this.data, path, defaultValue);
    set = (path: string, value: any) => set(this.data, path, value);
    has = (path: string) => has(this.data, path);
    unset = (path: string) => unset(this.data, path);
    merge = (value: any) => merge(this.data, value);
    mergeAt = (path: string, value: any) => this.set(path, merge({}, this.get(path, {}), value));
    pushTo = (path: string, ...items: any[]) => this.set(path, this.get<Array<any>>(path, []).concat(items));
    raw = (): T => this.data as T;
    getClone = <T>(path?: string, defaultValue: any = {}): T => (path ? cloneDeep(this.get(path, defaultValue)) : cloneDeep(this.raw())) as any;
    toJS = (path?: string) => path ? toJS(get(this.data, path)) : toJS(this.data);

    proxy = (path: string) => {
        const prefix = (p: PropertyKey) => path + '.' + p.toString();
        return new Proxy(this, {
            get(target: Config<T>, p: PropertyKey, receiver: any): any {
                if (target.has(prefix(p))) {
                    return target.get(prefix(p));
                }
                return target[p];
            },
            set(target: Config<T>, p: PropertyKey, value: any, receiver: any): boolean {
                target.set(prefix(p), value);
                return true;
            },
            has(target: Config<T>, p: PropertyKey): boolean {
                return target.has(prefix(p));
            },
        });
    };

    static proxied<T>(data): Config<T> {
        return new Proxy(new Config<T>(data), {
            get(target: Config<T>, p: PropertyKey, receiver: any): any {
                if (target.has(p.toString())) {
                    return target.get(p.toString());
                }
                return target[p];
            },
            set(target: Config<T>, p: PropertyKey, value: any, receiver: any): boolean {
                target.set(p.toString(), value);
                return true;
            },
            has(target: Config<T>, p: PropertyKey): boolean {
                return target.has(p.toString());
            },
        });

    }
}

var INJECTION = Symbol.for('INJECTION');

function _proxyGetter(proto, key, resolve, doCache) {
    function getter() {
        if (doCache && !Reflect.hasMetadata(INJECTION, this, key)) {
            Reflect.defineMetadata(INJECTION, resolve(), this, key);
        }
        if (Reflect.hasMetadata(INJECTION, this, key)) {
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
        enumerable: true,
        get: getter,
        set: setter,
    });
}

export function configProxy(path: string): PropertyDecorator {
    return (proto, key) => {
        var resolve = function () {
            let config = Config.app.get<Config<IConfig>>('config');
            return config.proxy(path);
        };
        _proxyGetter(proto, key, resolve, true);
    };
}


export function configValue(path: string): PropertyDecorator {
    return (proto, key) => {
        var resolve = function () {
            let config = Config.app.get<Config<IConfig>>('config');
            return config.get(path);
        };
        _proxyGetter(proto, key, resolve, false);
    };
}
