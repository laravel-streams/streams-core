"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.MetadataReader = void 0;
const METADATA_KEY = require("../constants/metadata_keys");
class MetadataReader {
    getConstructorMetadata(constructorFunc) {
        const compilerGeneratedMetadata = Reflect.getMetadata(METADATA_KEY.PARAM_TYPES, constructorFunc);
        const userGeneratedMetadata = Reflect.getMetadata(METADATA_KEY.TAGGED, constructorFunc);
        return {
            compilerGeneratedMetadata,
            userGeneratedMetadata: userGeneratedMetadata || {}
        };
    }
    getPropertiesMetadata(constructorFunc) {
        const userGeneratedMetadata = Reflect.getMetadata(METADATA_KEY.TAGGED_PROP, constructorFunc) || [];
        return userGeneratedMetadata;
    }
}
exports.MetadataReader = MetadataReader;
//# sourceMappingURL=metadata_reader.js.map