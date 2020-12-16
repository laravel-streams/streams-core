const isKey = (value: any): value is string => typeof value === 'string';
import { Collection as BaseCollection } from 'collect.js';

export class Collection<T> extends BaseCollection<T> {

    mergeDeep<T>(objectOrArray: object | T[]): Collection<T> {

        return this as any;
    }
}

export function collect<T>(collection?: T[] | Object): Collection<T> {
    return new Collection<T>(collection);
}
