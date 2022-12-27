"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Metadata = void 0;
const METADATA_KEY = require("../constants/metadata_keys");
class Metadata {
    constructor(key, value) {
        this.key = key;
        this.value = value;
    }
    toString() {
        if (this.key === METADATA_KEY.NAMED_TAG) {
            return `named: ${this.value.toString()} `;
        }
        else {
            return `tagged: { key:${this.key.toString()}, value: ${this.value} }`;
        }
    }
}
exports.Metadata = Metadata;
//# sourceMappingURL=metadata.js.map