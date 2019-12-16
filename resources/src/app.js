import {Application} from './Application';
// noinspection ES6UnusedImports
import {autoProvide, buildProviderModule, fluentProvide, provide} from 'inversify-binding-decorators';
import createDecorators from 'inversify-inject-decorators';
import {decorate, injectable, named, optional, postConstruct, tagged, unmanaged} from 'inversify';


const app = new Application();
const {lazyInject: inject} = createDecorators(app);

export {app, inject};
export {provide, buildProviderModule, fluentProvide, autoProvide};
export {injectable, unmanaged, optional, decorate, named, tagged, postConstruct};