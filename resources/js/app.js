require('./bootstrap');

import Vue from 'vue';
import App from './vue/app';
import {router} from './routes.js'



const app = new Vue({
    el: '#app',
    router,
    components: { App }
});