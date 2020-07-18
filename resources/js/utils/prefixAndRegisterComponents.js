import {kebabCase} from 'lodash';
import {app} from '../app';


const log = require('debug')('utils:registerComponents');

/**
 *
 * @param {VueConstructor} _Vue
 * @param _components
 * @return {*}
 */
export function prefixAndRegisterComponents(_Vue, _components) {
    let components = app.events.emit('components:register', {..._components});
    Object.keys(components).forEach(key => {
        let componentName = key;
        if ( app.config.prefix ) {
            componentName = `${app.config.prefix}-${kebabCase(key)}`;
        }
        log('prefixAndRegisterComponents componentName', componentName, {key: components[key]});
        _Vue.component(componentName, components[key]);
    });
    return components;
}
