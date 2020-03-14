import {Application} from './src/Application';
import Vue from 'vue';

const streams = new Application();

console.log('Application Instantiated:');
console.log(streams);

/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./keyboard');
require('./click');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

import Navigation from './components/Navigation.vue';
import Sections from './components/Sections.vue';
import Buttons from './components/Buttons.vue';
import Table from './components/Table.vue';

import Form from './components/Form.vue';
import FormField from './components/FormField.vue';

Vue.component('navigation', Navigation);
Vue.component('sections', Sections);
Vue.component('buttons', Buttons);

Vue.component('cp-table', Table);

Vue.component('cp-form', Form);
Vue.component('form-field', FormField);

const app = new Vue({
    el: '#app'
});
