"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.typeConstraint = exports.namedConstraint = exports.taggedConstraint = exports.traverseAncerstors = void 0;
const METADATA_KEY = require("../constants/metadata_keys");
const metadata_1 = require("../planning/metadata");
const traverseAncerstors = (request, constraint) => {
    const parent = request.parentRequest;
    if (parent !== null) {
        return constraint(parent) ? true : traverseAncerstors(parent, constraint);
    }
    else {
        return false;
    }
};
exports.traverseAncerstors = traverseAncerstors;
const taggedConstraint = (key) => (value) => {
    const constraint = (request) => request !== null && request.target !== null && request.target.matchesTag(key)(value);
    constraint.metaData = new metadata_1.Metadata(key, value);
    return constraint;
};
exports.taggedConstraint = taggedConstraint;
const namedConstraint = taggedConstraint(METADATA_KEY.NAMED_TAG);
exports.namedConstraint = namedConstraint;
const typeConstraint = (type) => (request) => {
    let binding = null;
    if (request !== null) {
        binding = request.bindings[0];
        if (typeof type === "string") {
            const serviceIdentifier = binding.serviceIdentifier;
            return serviceIdentifier === type;
        }
        else {
            const constructor = request.bindings[0].implementationType;
            return type === constructor;
        }
    }
    return false;
};
exports.typeConstraint = typeConstraint;
//# sourceMappingURL=constraint_helpers.js.map