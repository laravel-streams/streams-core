"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.targetName = void 0;
const METADATA_KEY = require("../constants/metadata_keys");
const metadata_1 = require("../planning/metadata");
const decorator_utils_1 = require("./decorator_utils");
function targetName(name) {
    return function (target, targetKey, index) {
        const metadata = new metadata_1.Metadata(METADATA_KEY.NAME_TAG, name);
        decorator_utils_1.tagParameter(target, targetKey, index, metadata);
    };
}
exports.targetName = targetName;
//# sourceMappingURL=target_name.js.map