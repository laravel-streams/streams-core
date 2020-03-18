import Vue from 'vue';
import {Application} from './src/Application';
import {ServiceProvider} from './src/ServiceProvider';

import {autoProvide, buildProviderModule, fluentProvide, provide} from 'inversify-binding-decorators';
import createDecorators from 'inversify-inject-decorators';
import {decorate, injectable, named, optional, postConstruct, tagged, unmanaged} from 'inversify';

Vue.config.silent = true;

const streams = {};

streams.app = new Application();

streams.ServiceProvider = ServiceProvider;

window.streams = streams;

window.Vue = Vue;

const {lazyInject: inject} = createDecorators(streams.app);

export {streams, inject};
export {provide, buildProviderModule, fluentProvide, autoProvide};
export {injectable, unmanaged, optional, decorate, named, tagged, postConstruct};


// @todo: THIS NEEDS TO MOVE

/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./keyboard');
require('./click');
