"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.inject = exports.LazyServiceIdentifer = void 0;
const error_msgs_1 = require("../constants/error_msgs");
const METADATA_KEY = require("../constants/metadata_keys");
const metadata_1 = require("../planning/metadata");
const decorator_utils_1 = require("./decorator_utils");
class LazyServiceIdentifer {
    constructor(cb) {
        this._cb = cb;
    }
    unwrap() {
        return this._cb();
    }
}
exports.LazyServiceIdentifer = LazyServiceIdentifer;
function inject(serviceIdentifier) {
    return function (target, targetKey, index) {
        if (serviceIdentifier === undefined) {
            throw new Error(error_msgs_1.UNDEFINED_INJECT_ANNOTATION(target.name));
        }
        const metadata = new metadata_1.Metadata(METADATA_KEY.INJECT_TAG, serviceIdentifier);
        if (typeof index === "number") {
            decorator_utils_1.tagParameter(target, targetKey, index, metadata);
        }
        else {
            decorator_utils_1.tagProperty(target, targetKey, metadata);
        }
    };
}
exports.inject = inject;
//# sourceMappingURL=inject.js.map