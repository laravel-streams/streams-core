"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.resolve = void 0;
const ERROR_MSGS = require("../constants/error_msgs");
const literal_types_1 = require("../constants/literal_types");
const exceptions_1 = require("../utils/exceptions");
const serialization_1 = require("../utils/serialization");
const instantiation_1 = require("./instantiation");
const invokeFactory = (factoryType, serviceIdentifier, fn) => {
    try {
        return fn();
    }
    catch (error) {
        if (exceptions_1.isStackOverflowExeption(error)) {
            throw new Error(ERROR_MSGS.CIRCULAR_DEPENDENCY_IN_FACTORY(factoryType, serviceIdentifier.toString()));
        }
        else {
            throw error;
        }
    }
};
const _resolveRequest = (requestScope) => (request) => {
    request.parentContext.setCurrentRequest(request);
    const bindings = request.bindings;
    const childRequests = request.childRequests;
    const targetIsAnArray = request.target && request.target.isArray();
    const targetParentIsNotAnArray = !request.parentRequest ||
        !request.parentRequest.target ||
        !request.target ||
        !request.parentRequest.target.matchesArray(request.target.serviceIdentifier);
    if (targetIsAnArray && targetParentIsNotAnArray) {
        return childRequests.map((childRequest) => {
            const _f = _resolveRequest(requestScope);
            return _f(childRequest);
        });
    }
    else {
        let result = null;
        if (request.target.isOptional() && bindings.length === 0) {
            return undefined;
        }
        const binding = bindings[0];
        const isSingleton = binding.scope === literal_types_1.BindingScopeEnum.Singleton;
        const isRequestSingleton = binding.scope === literal_types_1.BindingScopeEnum.Request;
        if (isSingleton && binding.activated) {
            return binding.cache;
        }
        if (isRequestSingleton &&
            requestScope !== null &&
            requestScope.has(binding.id)) {
            return requestScope.get(binding.id);
        }
        if (binding.type === literal_types_1.BindingTypeEnum.ConstantValue) {
            result = binding.cache;
            binding.activated = true;
        }
        else if (binding.type === literal_types_1.BindingTypeEnum.Function) {
            result = binding.cache;
            binding.activated = true;
        }
        else if (binding.type === literal_types_1.BindingTypeEnum.Constructor) {
            result = binding.implementationType;
        }
        else if (binding.type === literal_types_1.BindingTypeEnum.DynamicValue && binding.dynamicValue !== null) {
            result = invokeFactory("toDynamicValue", binding.serviceIdentifier, () => binding.dynamicValue(request.parentContext));
        }
        else if (binding.type === literal_types_1.BindingTypeEnum.Factory && binding.factory !== null) {
            result = invokeFactory("toFactory", binding.serviceIdentifier, () => binding.factory(request.parentContext));
        }
        else if (binding.type === literal_types_1.BindingTypeEnum.Provider && binding.provider !== null) {
            result = invokeFactory("toProvider", binding.serviceIdentifier, () => binding.provider(request.parentContext));
        }
        else if (binding.type === literal_types_1.BindingTypeEnum.Instance && binding.implementationType !== null) {
            result = instantiation_1.resolveInstance(binding.implementationType, childRequests, _resolveRequest(requestScope));
        }
        else {
            const serviceIdentifier = serialization_1.getServiceIdentifierAsString(request.serviceIdentifier);
            throw new Error(`${ERROR_MSGS.INVALID_BINDING_TYPE} ${serviceIdentifier}`);
        }
        if (typeof binding.onActivation === "function") {
            result = binding.onActivation(request.parentContext, result);
        }
        if (isSingleton) {
            binding.cache = result;
            binding.activated = true;
        }
        if (isRequestSingleton &&
            requestScope !== null &&
            !requestScope.has(binding.id)) {
            requestScope.set(binding.id, result);
        }
        return result;
    }
};
function resolve(context) {
    const _f = _resolveRequest(context.plan.rootRequest.requestScope);
    return _f(context.plan.rootRequest);
}
exports.resolve = resolve;
//# sourceMappingURL=resolver.js.map