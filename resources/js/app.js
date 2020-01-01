/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import {routes} from './routes';
import StoreData from './store';
import MainApp from './views/MainApp.vue'
import Vue from 'vue';
import axios from 'axios';
import {initialize} from './helpers/general';
Vue.use(VueRouter);
Vue.use(Vuex);

export default window.Event = new Vue();


const store = new Vuex.Store(StoreData);

const router = new VueRouter({
    
    mode: 'history',
    routes
    

});

initialize(store,router);

axios.interceptors.response.use(null, (error) => {
    if (error.response.status == 401 ) {
        store.commit('logout');
        router.push('/login');
    }

    return Promise.reject(error);
});
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */





const app = new Vue({
    el: '#app',
    router,
    store,
    components: {
        MainApp
    }
});
