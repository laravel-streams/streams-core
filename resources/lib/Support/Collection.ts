export class Collection<T> extends Array<T> implements Array<T> {
    constructor(arrayLength: number)
    constructor(...items: T[]) {
        super(...items);
        Object.setPrototypeOf(this, Array.prototype);
    }
}
