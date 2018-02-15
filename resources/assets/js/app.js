
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

//window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));

//const app = new Vue({
//    el: '#app'
//});


// вначале
// 1. npm install
// 2. npm install --save-dev vue-axios vue-loader vue-router vue-template-compiler
//import toastr from 'toastr';
window.toastr = require('toastr');
import Vue from 'vue';

//import VModal from 'vue-js-modal'
//Vue.use(VModal)

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import App from './components/App.vue';
import homePanel from './components/homePanel.vue';
import settings from './components/settings.vue';
import addProject from './components/addProject.vue';
const routes = [
    {
      name: 'homePanel',
      path: '/panel',
      component: homePanel
  },
   {
      name: 'settings',
      path: '/panel/settings',
      component: settings,
  }
];

const router = new VueRouter({ mode: 'abstract', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');