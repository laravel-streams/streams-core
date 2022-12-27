"use strict";
Object.defineProperty(exports, "__esModule", { value: true });
exports.multiBindToService = void 0;
const multiBindToService = (container) => (service) => (...types) => types.forEach((t) => container.bind(t).toService(service));
exports.multiBindToService = multiBindToService;
//# sourceMappingURL=binding_utils.js.map