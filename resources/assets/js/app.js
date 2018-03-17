
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

const fontawesome = require('@fortawesome/fontawesome')

fontawesome.library.add(require('@fortawesome/fontawesome-free-regular/faCalendarAlt'))
fontawesome.library.add(require('@fortawesome/fontawesome-free-solid/faSpinner'))

window.Vue = require('vue');

Vue.use(require('vue-touch'));
Vue.use(require('bootstrap-vue'));
Vue.component('posts', require('./components/Posts.vue'));


