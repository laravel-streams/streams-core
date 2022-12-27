"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
Object.defineProperty(exports, "__esModule", { value: true });
exports.Container = void 0;
const binding_1 = require("../bindings/binding");
const ERROR_MSGS = require("../constants/error_msgs");
const literal_types_1 = require("../constants/literal_types");
const METADATA_KEY = require("../constants/metadata_keys");
const metadata_reader_1 = require("../planning/metadata_reader");
const planner_1 = require("../planning/planner");
const resolver_1 = require("../resolution/resolver");
const binding_to_syntax_1 = require("../syntax/binding_to_syntax");
const id_1 = require("../utils/id");
const serialization_1 = require("../utils/serialization");
const container_snapshot_1 = require("./container_snapshot");
const lookup_1 = require("./lookup");
class Container {
    constructor(containerOptions) {
        this._appliedMiddleware = [];
        const options = containerOptions || {};
        if (typeof options !== "object") {
            throw new Error(`${ERROR_MSGS.CONTAINER_OPTIONS_MUST_BE_AN_OBJECT}`);
        }
        if (options.defaultScope === undefined) {
            options.defaultScope = literal_types_1.BindingScopeEnum.Transient;
        }
        else if (options.defaultScope !== literal_types_1.BindingScopeEnum.Singleton &&
            options.defaultScope !== literal_types_1.BindingScopeEnum.Transient &&
            options.defaultScope !== literal_types_1.BindingScopeEnum.Request) {
            throw new Error(`${ERROR_MSGS.CONTAINER_OPTIONS_INVALID_DEFAULT_SCOPE}`);
        }
        if (options.autoBindInjectable === undefined) {
            options.autoBindInjectable = false;
        }
        else if (typeof options.autoBindInjectable !== "boolean") {
            throw new Error(`${ERROR_MSGS.CONTAINER_OPTIONS_INVALID_AUTO_BIND_INJECTABLE}`);
        }
        if (options.skipBaseClassChecks === undefined) {
            options.skipBaseClassChecks = false;
        }
        else if (typeof options.skipBaseClassChecks !== "boolean") {
            throw new Error(`${ERROR_MSGS.CONTAINER_OPTIONS_INVALID_SKIP_BASE_CHECK}`);
        }
        this.options = {
            autoBindInjectable: options.autoBindInjectable,
            defaultScope: options.defaultScope,
            skipBaseClassChecks: options.skipBaseClassChecks
        };
        this.id = id_1.id();
        this._bindingDictionary = new lookup_1.Lookup();
        this._snapshots = [];
        this._middleware = null;
        this.parent = null;
        this._metadataReader = new metadata_reader_1.MetadataReader();
    }
    static merge(container1, container2, ...container3) {
        const container = new Container();
        const targetContainers = [container1, container2, ...container3]
            .map((targetContainer) => planner_1.getBindingDictionary(targetContainer));
        const bindingDictionary = planner_1.getBindingDictionary(container);
        function copyDictionary(origin, destination) {
            origin.traverse((key, value) => {
                value.forEach((binding) => {
                    destination.add(binding.serviceIdentifier, binding.clone());
                });
            });
        }
        targetContainers.forEach((targetBindingDictionary) => {
            copyDictionary(targetBindingDictionary, bindingDictionary);
        });
        return container;
    }
    load(...modules) {
        const getHelpers = this._getContainerModuleHelpersFactory();
        for (const currentModule of modules) {
            const containerModuleHelpers = getHelpers(currentModule.id);
            currentModule.registry(containerModuleHelpers.bindFunction, containerModuleHelpers.unbindFunction, containerModuleHelpers.isboundFunction, containerModuleHelpers.rebindFunction);
        }
    }
    loadAsync(...modules) {
        return __awaiter(this, void 0, void 0, function* () {
            const getHelpers = this._getContainerModuleHelpersFactory();
            for (const currentModule of modules) {
                const containerModuleHelpers = getHelpers(currentModule.id);
                yield currentModule.registry(containerModuleHelpers.bindFunction, containerModuleHelpers.unbindFunction, containerModuleHelpers.isboundFunction, containerModuleHelpers.rebindFunction);
            }
        });
    }
    unload(...modules) {
        const conditionFactory = (expected) => (item) => item.moduleId === expected;
        modules.forEach((module) => {
            const condition = conditionFactory(module.id);
            this._bindingDictionary.removeByCondition(condition);
        });
    }
    bind(serviceIdentifier) {
        const scope = this.options.defaultScope || literal_types_1.BindingScopeEnum.Transient;
        const binding = new binding_1.Binding(serviceIdentifier, scope);
        this._bindingDictionary.add(serviceIdentifier, binding);
        return new binding_to_syntax_1.BindingToSyntax(binding);
    }
    rebind(serviceIdentifier) {
        this.unbind(serviceIdentifier);
        return this.bind(serviceIdentifier);
    }
    unbind(serviceIdentifier) {
        try {
            this._bindingDictionary.remove(serviceIdentifier);
        }
        catch (e) {
            throw new Error(`${ERROR_MSGS.CANNOT_UNBIND} ${serialization_1.getServiceIdentifierAsString(serviceIdentifier)}`);
        }
    }
    unbindAll() {
        this._bindingDictionary = new lookup_1.Lookup();
    }
    isBound(serviceIdentifier) {
        let bound = this._bindingDictionary.hasKey(serviceIdentifier);
        if (!bound && this.parent) {
            bound = this.parent.isBound(serviceIdentifier);
        }
        return bound;
    }
    isBoundNamed(serviceIdentifier, named) {
        return this.isBoundTagged(serviceIdentifier, METADATA_KEY.NAMED_TAG, named);
    }
    isBoundTagged(serviceIdentifier, key, value) {
        let bound = false;
        if (this._bindingDictionary.hasKey(serviceIdentifier)) {
            const bindings = this._bindingDictionary.get(serviceIdentifier);
            const request = planner_1.createMockRequest(this, serviceIdentifier, key, value);
            bound = bindings.some((b) => b.constraint(request));
        }
        if (!bound && this.parent) {
            bound = this.parent.isBoundTagged(serviceIdentifier, key, value);
        }
        return bound;
    }
    snapshot() {
        this._snapshots.push(container_snapshot_1.ContainerSnapshot.of(this._bindingDictionary.clone(), this._middleware));
    }
    restore() {
        const snapshot = this._snapshots.pop();
        if (snapshot === undefined) {
            throw new Error(ERROR_MSGS.NO_MORE_SNAPSHOTS_AVAILABLE);
        }
        this._bindingDictionary = snapshot.bindings;
        this._middleware = snapshot.middleware;
    }
    createChild(containerOptions) {
        const child = new Container(containerOptions || this.options);
        child.parent = this;
        return child;
    }
    applyMiddleware(...middlewares) {
        this._appliedMiddleware = this._appliedMiddleware.concat(middlewares);
        const initial = (this._middleware) ? this._middleware : this._planAndResolve();
        this._middleware = middlewares.reduce((prev, curr) => curr(prev), initial);
    }
    applyCustomMetadataReader(metadataReader) {
        this._metadataReader = metadataReader;
    }
    get(serviceIdentifier) {
        return this._get(false, false, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier);
    }
    getTagged(serviceIdentifier, key, value) {
        return this._get(false, false, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier, key, value);
    }
    getNamed(serviceIdentifier, named) {
        return this.getTagged(serviceIdentifier, METADATA_KEY.NAMED_TAG, named);
    }
    getAll(serviceIdentifier) {
        return this._get(true, true, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier);
    }
    getAllTagged(serviceIdentifier, key, value) {
        return this._get(false, true, literal_types_1.TargetTypeEnum.Variable, serviceIdentifier, key, value);
    }
    getAllNamed(serviceIdentifier, named) {
        return this.getAllTagged(serviceIdentifier, METADATA_KEY.NAMED_TAG, named);
    }
    resolve(constructorFunction) {
        const tempContainer = this.createChild();
        tempContainer.bind(constructorFunction).toSelf();
        this._appliedMiddleware.forEach((m) => {
            tempContainer.applyMiddleware(m);
        });
        return tempContainer.get(constructorFunction);
    }
    _getContainerModuleHelpersFactory() {
        const setModuleId = (bindingToSyntax, moduleId) => {
            bindingToSyntax._binding.moduleId = moduleId;
        };
        const getBindFunction = (moduleId) => (serviceIdentifier) => {
            const _bind = this.bind.bind(this);
            const bindingToSyntax = _bind(serviceIdentifier);
            setModuleId(bindingToSyntax, moduleId);
            return bindingToSyntax;
        };
        const getUnbindFunction = (moduleId) => (serviceIdentifier) => {
            const _unbind = this.unbind.bind(this);
            _unbind(serviceIdentifier);
        };
        const getIsboundFunction = (moduleId) => (serviceIdentifier) => {
            const _isBound = this.isBound.bind(this);
            return _isBound(serviceIdentifier);
        };
        const getRebindFunction = (moduleId) => (serviceIdentifier) => {
            const _rebind = this.rebind.bind(this);
            const bindingToSyntax = _rebind(serviceIdentifier);
            setModuleId(bindingToSyntax, moduleId);
            return bindingToSyntax;
        };
        return (mId) => ({
            bindFunction: getBindFunction(mId),
            isboundFunction: getIsboundFunction(mId),
            rebindFunction: getRebindFunction(mId),
            unbindFunction: getUnbindFunction(mId)
        });
    }
    _get(avoidConstraints, isMultiInject, targetType, serviceIdentifier, key, value) {
        let result = null;
        const defaultArgs = {
            avoidConstraints,
            contextInterceptor: (context) => context,
            isMultiInject,
            key,
            serviceIdentifier,
            targetType,
            value
        };
        if (this._middleware) {
            result = this._middleware(defaultArgs);
            if (result === undefined || result === null) {
                throw new Error(ERROR_MSGS.INVALID_MIDDLEWARE_RETURN);
            }
        }
        else {
            result = this._planAndResolve()(defaultArgs);
        }
        return result;
    }
    _planAndResolve() {
        return (args) => {
            let context = planner_1.plan(this._metadataReader, this, args.isMultiInject, args.targetType, args.serviceIdentifier, args.key, args.value, args.avoidConstraints);
            context = args.contextInterceptor(context);
            const result = resolver_1.resolve(context);
            return result;
        };
    }
}
exports.Container = Container;
//# sourceMappingURL=container.js.map