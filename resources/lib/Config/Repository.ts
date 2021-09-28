import { injectable } from 'inversify';

@injectable()
export class Repository<T = any> {
    constructor(protected items: T = {} as any) {}

    public get<T>(path: string, defaultValue?: any): T {
        let value = getSetDescendantProp(this.items, path);
        if ( value === undefined ) {
            value = defaultValue;
        }
        return value;
    }

    public set(path: string | T, value?: any) {
        if ( typeof path === 'object' ) {
            this.items = path;
        } else {
            getSetDescendantProp(this.items, path, value);
        }
        return this;
    }

    public has(path: string) {
        return getSetDescendantProp(this.items, path) !== undefined;
    }

    public static asProxy<T>(items?: T): Repository<T> & T {
        return makeProxy<T>(new Repository<T>(items));
    }
}

const enum ProxyFlags {
    IS_PROXY = '__s_isProxy',
    UNPROXY  = '__s_unproxy'
}

function makeProxy<T>(repository: Repository<T>): Repository<T> & T {
    return new Proxy(repository, {
        get(target: Repository, p: string | symbol, receiver: any): any {
            if ( Reflect.has(target, p) ) return target[ p ];
            if ( p === ProxyFlags.IS_PROXY ) return true;
            if ( p === ProxyFlags.UNPROXY ) return () => target;
            let path = p.toString();
            if ( target.has(path) ) return target.get(path);
        },
        set(target: Repository, p: string | symbol, value: any, receiver: any): boolean {
            if ( [ ProxyFlags.IS_PROXY, ProxyFlags.UNPROXY ].includes(p.toString() as any) ) {
                throw Error('Cannot set property: ' + p.toString());
            }
            if ( Reflect.has(target, p) ) {
                return Reflect.set(target, p, value, receiver);
            }
            target.set(p.toString(), value);
            return true;
        },
        has(target: Repository, p: string | symbol): boolean {
            if ( Reflect.has(target, p) ) {
                return true;
            }
            return target.has(p.toString());
        },
    }) as any;
}


function getSetDescendantProp(obj, desc, value?) {
    var arr = desc ? desc.split('.') : [];

    while ( arr.length && obj ) {
        var comp  = arr.shift();
        var match = new RegExp('(.+)\\[([0-9]*)\\]').exec(comp);

        // handle arrays
        if ( (match !== null) && (match.length == 3) ) {
            var arrayData = {
                arrName : match[ 1 ],
                arrIndex: match[ 2 ],
            };
            if ( obj[ arrayData.arrName ] !== undefined ) {
                if ( typeof value !== 'undefined' && arr.length === 0 ) {
                    obj[ arrayData.arrName ][ arrayData.arrIndex ] = value;
                }
                obj = obj[ arrayData.arrName ][ arrayData.arrIndex ];
            } else {
                obj = undefined;
            }

            continue;
        }

        // handle regular things
        if ( typeof value !== 'undefined' ) {
            if ( obj[ comp ] === undefined ) {
                obj[ comp ] = {};
            }

            if ( arr.length === 0 ) {
                obj[ comp ] = value;
            }
        }

        obj = obj[ comp ];
    }

    return obj;
}
