require('./bootstrap');

window.Vue = require('vue').default;

//Vue Router Section--------------
import VueRouter from 'vue-router'
Vue.use(VueRouter)
//Vue Router Section--------------

//Support Store (Vuex)----------
import {store} from "./store/store";

import BankAccount from "./components/BankAccount";

// Element UI Support
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI, { locale })

//Vue Global Component----------
Vue.component('master-view', require('./components/MasterView').default);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/',
            component: BankAccount,
            name: 'bankAccountList'
        },
    ]
})

const app = new Vue({
    el: '#app',
    router,
    store,
});
