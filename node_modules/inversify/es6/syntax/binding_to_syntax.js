"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.BindingToSyntax = void 0;
const ERROR_MSGS = require("../constants/error_msgs");
const literal_types_1 = require("../constants/literal_types");
const binding_in_when_on_syntax_1 = require("./binding_in_when_on_syntax");
const binding_when_on_syntax_1 = require("./binding_when_on_syntax");
class BindingToSyntax {
    constructor(binding) {
        this._binding = binding;
    }
    to(constructor) {
        this._binding.type = literal_types_1.BindingTypeEnum.Instance;
        this._binding.implementationType = constructor;
        return new binding_in_when_on_syntax_1.BindingInWhenOnSyntax(this._binding);
    }
    toSelf() {
        if (typeof this._binding.serviceIdentifier !== "function") {
            throw new Error(`${ERROR_MSGS.INVALID_TO_SELF_VALUE}`);
        }
        const self = this._binding.serviceIdentifier;
        return this.to(self);
    }
    toConstantValue(value) {
        this._binding.type = literal_types_1.BindingTypeEnum.ConstantValue;
        this._binding.cache = value;
        this._binding.dynamicValue = null;
        this._binding.implementationType = null;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
    }
    toDynamicValue(func) {
        this._binding.type = literal_types_1.BindingTypeEnum.DynamicValue;
        this._binding.cache = null;
        this._binding.dynamicValue = func;
        this._binding.implementationType = null;
        return new binding_in_when_on_syntax_1.BindingInWhenOnSyntax(this._binding);
    }
    toConstructor(constructor) {
        this._binding.type = literal_types_1.BindingTypeEnum.Constructor;
        this._binding.implementationType = constructor;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
    }
    toFactory(factory) {
        this._binding.type = literal_types_1.BindingTypeEnum.Factory;
        this._binding.factory = factory;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
    }
    toFunction(func) {
        if (typeof func !== "function") {
            throw new Error(ERROR_MSGS.INVALID_FUNCTION_BINDING);
        }
        const bindingWhenOnSyntax = this.toConstantValue(func);
        this._binding.type = literal_types_1.BindingTypeEnum.Function;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return bindingWhenOnSyntax;
    }
    toAutoFactory(serviceIdentifier) {
        this._binding.type = literal_types_1.BindingTypeEnum.Factory;
        this._binding.factory = (context) => {
            const autofactory = () => context.container.get(serviceIdentifier);
            return autofactory;
        };
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
    }
    toProvider(provider) {
        this._binding.type = literal_types_1.BindingTypeEnum.Provider;
        this._binding.provider = provider;
        this._binding.scope = literal_types_1.BindingScopeEnum.Singleton;
        return new binding_when_on_syntax_1.BindingWhenOnSyntax(this._binding);
    }
    toService(service) {
        this.toDynamicValue((context) => context.container.get(service));
    }
}
exports.BindingToSyntax = BindingToSyntax;
//# sourceMappingURL=binding_to_syntax.js.map