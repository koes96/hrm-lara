require('./bootstrap');

window.Vue = require('vue').default;

import {Form} from 'vform';
window.Form = Form;

import 'vuejs-datatable/dist/themes/bootstrap-4.esm';
import { VuejsDatatableFactory } from 'vuejs-datatable';
Vue.use( VuejsDatatableFactory );

import Vue from 'vue';
import VueRouter from 'vue-router'
Vue.use(VueRouter);

    //variabel tambah link 
    let routes = [
        {path: '/data-jabatan', component:require('./components/HRD/DataJabatan.vue').default},
        {path: '/data-grade', component:require('./components/HRD/DataGrade.vue').default}
    ]
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('datatable-component', require('./components/DataTableComponent.vue').default);


const router = new VueRouter({
    mode : 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router
});
