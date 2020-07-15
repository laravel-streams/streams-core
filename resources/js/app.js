import Vue from 'vue';



Vue.config.silent = false;
Vue.config.devtools = true;
Vue.config.productionTip = false


window.Vue = Vue;

// require('./bootstrap/components.js');
import Messages from "./components/Messages";
Vue.component('messages', Messages);

import Top from "./components/layout/Top";
Vue.component('layout-top', Top);

// Our bus for future use.
export const bus = new Vue();

const app = new Vue({
  el: '#app',
  created() {
    console.log(
      '%c >>> App created',
      'background-color:red;color:white;font-size:11px;padding:5px 10px;')
  }
});
