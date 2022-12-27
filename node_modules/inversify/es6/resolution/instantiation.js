"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.resolveInstance = void 0;
const error_msgs_1 = require("../constants/error_msgs");
const literal_types_1 = require("../constants/literal_types");
const METADATA_KEY = require("../constants/metadata_keys");
function _injectProperties(instance, childRequests, resolveRequest) {
    const propertyInjectionsRequests = childRequests.filter((childRequest) => (childRequest.target !== null &&
        childRequest.target.type === literal_types_1.TargetTypeEnum.ClassProperty));
    const propertyInjections = propertyInjectionsRequests.map(resolveRequest);
    propertyInjectionsRequests.forEach((r, index) => {
        let propertyName = "";
        propertyName = r.target.name.value();
        const injection = propertyInjections[index];
        instance[propertyName] = injection;
    });
    return instance;
}
function _createInstance(Func, injections) {
    return new Func(...injections);
}
function _postConstruct(constr, result) {
    if (Reflect.hasMetadata(METADATA_KEY.POST_CONSTRUCT, constr)) {
        const data = Reflect.getMetadata(METADATA_KEY.POST_CONSTRUCT, constr);
        try {
            result[data.value]();
        }
        catch (e) {
            throw new Error(error_msgs_1.POST_CONSTRUCT_ERROR(constr.name, e.message));
        }
    }
}
function resolveInstance(constr, childRequests, resolveRequest) {
    let result = null;
    if (childRequests.length > 0) {
        const constructorInjectionsRequests = childRequests.filter((childRequest) => (childRequest.target !== null && childRequest.target.type === literal_types_1.TargetTypeEnum.ConstructorArgument));
        const constructorInjections = constructorInjectionsRequests.map(resolveRequest);
        result = _createInstance(constr, constructorInjections);
        result = _injectProperties(result, childRequests, resolveRequest);
    }
    else {
        result = new constr();
    }
    _postConstruct(constr, result);
    return result;
}
exports.resolveInstance = resolveInstance;
//# sourceMappingURL=instantiation.js.map