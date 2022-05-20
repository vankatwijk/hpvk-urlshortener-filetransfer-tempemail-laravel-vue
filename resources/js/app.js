/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

window.Vue = require('vue')

window.moment = require('moment')

import VueSweetalert2 from 'vue-sweetalert2'
import VueClipboard from 'vue-clipboard2'

window.Vue.use(VueSweetalert2)
window.Vue.use(VueClipboard)
    /**
     * The following block of code may be used to automatically register your
     * Vue components. It will recursively scan this directory for the Vue
     * components and automatically register them with their "basename".
     *
     * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
     */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.filter('truncate', function(text, stop, clamp) {
    return text.slice(0, stop) + (stop < text.length ? clamp || '...' : '')
})

Vue.filter('momentDay', function(text) {
    return moment(text).format('MMM D')
})

Vue.filter('momentDayYear', function(text) {
    return moment(text).format('MMMM Do YYYY')
})

Vue.component('navigation-bar', require('./components/layout/NavigationBar').default)
Vue.component('dash-bar', require('./components/layout/DashBar').default)
Vue.component('shorten-link-page', require('./components/landing/ShortenLinkPage').default)
Vue.component('links-list', require('./components/common/LinksList').default)
Vue.component('previous-links-list-item', require('./components/landing/PreviousLinksListItem').default)
Vue.component('links-list-item', require('./components/dashboard/LinksListItem').default)
Vue.component('link-chart', require('./components/dashboard/LinkChart').default)
Vue.component('dashboard', require('./components/dashboard/Dashboard').default)
Vue.component('shorten-link-form', require('./components/landing/ShortenLinkForm').default)
Vue.component('login-form', require('./components/auth/LoginForm').default)
Vue.component('register-form', require('./components/auth/RegisterForm').default)
Vue.component('notification', require('./components/common/Notification').default)

Vue.component('clip-loader', require('vue-spinner/src/ClipLoader').default);

const app = new Vue({
    el: '#app',
})