import { injectable } from 'inversify';

@injectable()
export class Repository<Type = any> {

    constructor(protected items: Type = {} as any) {
        this.items = items;
    }

    /**
     * Get a config value.
     * 
     * @param key 
     * @param defaultValue
     * @returns mixed
     */
    public get<Type>(key: string, defaultValue?: any): Type {

        let value = getSetDescendantProp(this.items, key);

        if (value === undefined) {
            value = defaultValue;
        }
        return value;
    }

    /**
     * Set a config value.
     * 
     * @param key 
     * @param value 
     * @returns this
     */
    public set(key: string | Type, value?: any) {
        
        if (typeof key === 'object') {
            this.items = key;
        } else {
            getSetDescendantProp(this.items, key, value);
        }

        return this;
    }

    /**
     * Check if a value exists.
     * 
     * @param key 
     * @returns 
     */
    public has(key: string) {
        return getSetDescendantProp(this.items, key) !== undefined;
    }

    // public static asProxy<Type>(items?: Type): Repository<Type> & Type {
    //     return makeProxy<Type>(new Repository<Type>(items));
    // }
}

// const enum ProxyFlags {
//     IS_PROXY = '__s_isProxy',
//     UNPROXY = '__s_unproxy'
// }


// function makeProxy<Type>(repository: Repository<Type>): Repository<Type> & Type {
//     return new Proxy(repository, {
//         get(target: Repository, p: string | symbol, receiver: any): any {
//             if (Reflect.has(target, p)) return Reflect.get(target, p, receiver);
//             if (p === ProxyFlags.IS_PROXY) return true;
//             if (p === ProxyFlags.UNPROXY) return () => target;
//             let key = p.toString();
//             if (target.has(key)) return target.get(key);
//         },
//         set(target: Repository, p: string | symbol, value: any, receiver: any): boolean {
//             if ([ProxyFlags.IS_PROXY, ProxyFlags.UNPROXY].includes(p.toString() as any)) {
//                 throw Error('Cannot set property: ' + p.toString());
//             }
//             if (Reflect.has(target, p)) {
//                 return Reflect.set(target, p, value, receiver);
//             }
//             target.set(p.toString(), value);
//             return true;
//         },
//         has(target: Repository, p: string | symbol): boolean {
//             if (Reflect.has(target, p)) {
//                 return true;
//             }
//             return target.has(p.toString());
//         },
//     }) as any;
// }


function getSetDescendantProp(items, key, value?) {
    
    var keys = key ? key.split('.') : [];

    while (keys.length && items) {
        
        var compare = keys.shift();
        var match = new RegExp('(.+)\\[([0-9]*)\\]').exec(compare);

        // handle arrays
        if ((match !== null) && (match.length == 3)) {
            
            var arrayData = {
                arrName: match[1],
                arrIndex: match[2],
            };

            if (items[arrayData.arrName] !== undefined) {
                if (typeof value !== 'undefined' && keys.length === 0) {
                    items[arrayData.arrName][arrayData.arrIndex] = value;
                }
                items = items[arrayData.arrName][arrayData.arrIndex];
            } else {
                items = undefined;
            }

            continue;
        }

        // handle regular things
        if (typeof value !== 'undefined') {
            if (items[compare] === undefined) {
                items[compare] = {};
            }

            if (keys.length === 0) {
                items[compare] = value;
            }
        }

        items = items[compare];
    }

    return items;
}
