"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Lookup = void 0;
const ERROR_MSGS = require("../constants/error_msgs");
class Lookup {
    constructor() {
        this._map = new Map();
    }
    getMap() {
        return this._map;
    }
    add(serviceIdentifier, value) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }
        if (value === null || value === undefined) {
            throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }
        const entry = this._map.get(serviceIdentifier);
        if (entry !== undefined) {
            entry.push(value);
            this._map.set(serviceIdentifier, entry);
        }
        else {
            this._map.set(serviceIdentifier, [value]);
        }
    }
    get(serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }
        const entry = this._map.get(serviceIdentifier);
        if (entry !== undefined) {
            return entry;
        }
        else {
            throw new Error(ERROR_MSGS.KEY_NOT_FOUND);
        }
    }
    remove(serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }
        if (!this._map.delete(serviceIdentifier)) {
            throw new Error(ERROR_MSGS.KEY_NOT_FOUND);
        }
    }
    removeByCondition(condition) {
        this._map.forEach((entries, key) => {
            const updatedEntries = entries.filter((entry) => !condition(entry));
            if (updatedEntries.length > 0) {
                this._map.set(key, updatedEntries);
            }
            else {
                this._map.delete(key);
            }
        });
    }
    hasKey(serviceIdentifier) {
        if (serviceIdentifier === null || serviceIdentifier === undefined) {
            throw new Error(ERROR_MSGS.NULL_ARGUMENT);
        }
        return this._map.has(serviceIdentifier);
    }
    clone() {
        const copy = new Lookup();
        this._map.forEach((value, key) => {
            value.forEach((b) => copy.add(key, b.clone()));
        });
        return copy;
    }
    traverse(func) {
        this._map.forEach((value, key) => {
            func(key, value);
        });
    }
}
exports.Lookup = Lookup;
//# sourceMappingURL=lookup.js.map