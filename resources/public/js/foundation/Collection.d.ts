import { Collection as BaseCollection } from 'collect.js';
export declare class Collection<T> extends BaseCollection<T> {
    mergeDeep<T>(objectOrArray: object | T[]): Collection<T>;
}
export declare function collect<T>(collection?: T[] | Object): Collection<T>;
