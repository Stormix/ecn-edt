/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import '../metronic/tools/webpack/vendors/global';
import '../metronic/tools/webpack/scripts';
require('./bootstrap');

window.Vue = require('vue');


window.Vue.component('progress-component', require('./components/Progress.vue').default);
window.Vue.component('calendar-info', require('./components/CalendarInfo.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
