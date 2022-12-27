"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.Target = void 0;
const METADATA_KEY = require("../constants/metadata_keys");
const id_1 = require("../utils/id");
const metadata_1 = require("./metadata");
const queryable_string_1 = require("./queryable_string");
class Target {
    constructor(type, name, serviceIdentifier, namedOrTagged) {
        this.id = id_1.id();
        this.type = type;
        this.serviceIdentifier = serviceIdentifier;
        this.name = new queryable_string_1.QueryableString(name || "");
        this.metadata = new Array();
        let metadataItem = null;
        if (typeof namedOrTagged === "string") {
            metadataItem = new metadata_1.Metadata(METADATA_KEY.NAMED_TAG, namedOrTagged);
        }
        else if (namedOrTagged instanceof metadata_1.Metadata) {
            metadataItem = namedOrTagged;
        }
        if (metadataItem !== null) {
            this.metadata.push(metadataItem);
        }
    }
    hasTag(key) {
        for (const m of this.metadata) {
            if (m.key === key) {
                return true;
            }
        }
        return false;
    }
    isArray() {
        return this.hasTag(METADATA_KEY.MULTI_INJECT_TAG);
    }
    matchesArray(name) {
        return this.matchesTag(METADATA_KEY.MULTI_INJECT_TAG)(name);
    }
    isNamed() {
        return this.hasTag(METADATA_KEY.NAMED_TAG);
    }
    isTagged() {
        return this.metadata.some((metadata) => METADATA_KEY.NON_CUSTOM_TAG_KEYS.every((key) => metadata.key !== key));
    }
    isOptional() {
        return this.matchesTag(METADATA_KEY.OPTIONAL_TAG)(true);
    }
    getNamedTag() {
        if (this.isNamed()) {
            return this.metadata.filter((m) => m.key === METADATA_KEY.NAMED_TAG)[0];
        }
        return null;
    }
    getCustomTags() {
        if (this.isTagged()) {
            return this.metadata.filter((metadata) => METADATA_KEY.NON_CUSTOM_TAG_KEYS.every((key) => metadata.key !== key));
        }
        else {
            return null;
        }
    }
    matchesNamedTag(name) {
        return this.matchesTag(METADATA_KEY.NAMED_TAG)(name);
    }
    matchesTag(key) {
        return (value) => {
            for (const m of this.metadata) {
                if (m.key === key && m.value === value) {
                    return true;
                }
            }
            return false;
        };
    }
}
exports.Target = Target;
//# sourceMappingURL=target.js.map