
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

Vue.use(require('vue-touch'));
Vue.use(require('bootstrap-vue'));
Vue.component('posts', require('./components/Posts.vue'));

const app = new Vue({
    el: '#app',
    mounted() {
        document.querySelector('#main-loader').remove()
        document.querySelector('body').classList.remove("h-100")
        document.querySelector('html').classList.remove("h-100")
        this.$el.classList.remove('d-none')
    }
})


