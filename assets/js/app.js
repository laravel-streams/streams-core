import Vue from 'vue';

window.app = new Vue({
    el: '#app'
});

app.mousetrap = require('mousetrap');
app.swal = require('sweetalert');
app.noty = require('noty');
app.tingle = require('tingle.js');

// window.matchMedia('(prefers-color-scheme: dark)').addEventListener("change", (e) => {
//     if (e.matches) console.log('your in dark mode);
// });
