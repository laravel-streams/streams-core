import {kebabCase} from 'lodash';
import {app} from './app';
import {prefixAndRegisterComponents} from './utils/prefixAndRegisterComponents';


const log = require('debug')('utils:registerComponents');

export class VuePlugin {
    static installed=false
    /**
     * @param {VueConstructor} Vue
     * @param {any} options
     */
    static install(Vue, options={}){}
    static get app(){return app    }
    static prefixAndRegisterComponents = prefixAndRegisterComponents
}
