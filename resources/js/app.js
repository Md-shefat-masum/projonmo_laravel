/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

// import vuex
const { default: store } = require('./store/index');
window.vue_store = store;

import { mapGetters, mapActions, mapMutations } from 'vuex';
window.mapGetters = mapGetters;
window.mapMutations = mapMutations;
window.mapActions = mapActions;


// pagination
Vue.component('pagination', require('laravel-vue-pagination'));
