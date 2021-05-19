require('./bootstrap');

window.Vue = require('vue').default;

import {Form} from 'vform';
window.Form  = Form;

import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
  } from 'vform/src/components/bootstrap4'
  // 'vform/src/components/bootstrap4'
  // 'vform/src/components/tailwind'
  
  Vue.component(Button.name, Button)
  Vue.component(HasError.name, HasError)
  Vue.component(AlertError.name, AlertError)
  Vue.component(AlertErrors.name, AlertErrors)
  Vue.component(AlertSuccess.name, AlertSuccess)




let Fire =new Vue();
window.Fire = Fire;
//Import Alert
import Swal from 'sweetalert2'
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});
window.Toast = Toast;
// import / registrasi vuerouter
import Vue from 'vue';
import VueRouter from 'vue-router'
Vue.use(VueRouter)

// variable untuk vue router
    let routes =[
        { path: '/data-grade', component:require('./components/HRD/DataGrade.vue').default },
        { path: '/data-jabatan', component:require('./components/HRD/DataJabatan.vue').default }
    ]


Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const router = new VueRouter({
    mode: 'history',
    routes
})

const app = new Vue({
    el: '#app',
    router
});
