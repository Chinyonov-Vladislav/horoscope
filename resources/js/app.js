/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import 'sweetalert2/dist/sweetalert2.min.css';
require('./bootstrap');
import Vue from 'vue';
window.Vue = require('vue').default;
import Fragment from 'vue-fragment'
import VueSweetalert2 from 'vue-sweetalert2';
import VueDatePicker from '@mathieustan/vue-datepicker';
import '@mathieustan/vue-datepicker/dist/vue-datepicker.min.css';
Vue.use(VueSweetalert2);
Vue.use(Fragment.Plugin)
Vue.use(VueDatePicker);
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// layout-components
Vue.component('main-header',require('./components/layoutsComponent/header').default);
Vue.component('main-footer',require('./components/layoutsComponent/footer').default);
Vue.component('zodiac-sign-card',require('./components/layoutsComponent/ZodiacSignCard').default);
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// pages-component
Vue.component('authorization-page',require('./components/pages/AuthorizationPage').default);
Vue.component('registration-page',require('./components/pages/RegistrationPage').default);
Vue.component('main-page',require('./components/pages/MainPage').default);
Vue.component('profile-page',require('./components/pages/ProfilePage').default);
Vue.component('info-about-new-user-page',require('./components/pages/InfoAboutNewUserPage').default);
Vue.component('predictions-page',require('./components/pages/PredictionsPage').default);
Vue.component('action-prediction',require('./components/pages/ActionWithPredictionPage').default);
Vue.component('reset-password-page',require('./components/pages/ResetPasswordPage').default);
Vue.component('change-password-page',require('./components/pages/ChangePasswordPage').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
