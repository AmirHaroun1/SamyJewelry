/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import {Ziggy} from "./ziggy";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import moment from 'moment';

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';


import vSelect from 'vue-select'
import 'vue-select/dist/vue-select.css';


require('./bootstrap');

window.Vue = require('vue');

Vue.component('v-select', vSelect)
Vue.component('VueCtkDateTimePicker', VueCtkDateTimePicker);
Vue.use(Ziggy);
Vue.use(VueSweetalert2);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.mixin({
    methods: {
        route: (name, params, absolute,Ziggy) => route(name, params, absolute, Ziggy),
    },
});

Vue.component('loading-spinner', require('./components/LoadingSpinner.vue').default);

Vue.component('dash-board', require('./components/DashBoard.vue').default);
Vue.component('main-employees', require('./components/MainِEmployees.vue').default);
Vue.component('employee-stats-card', require('./components/EmployeeStatsCard.vue').default);
Vue.component('employee-wizard', require('./components/EmployeeWizard.vue').default);
Vue.component('employee-edit-create', require('./components/EmployeeEditCreate.vue').default);
Vue.component('employee-gold-history', require('./components/EmployeeGoldWeightHistory.vue').default);
Vue.component('employee-sales', require('./components/EmployeeSales.vue').default);

Vue.component('main-invoices',require('./components/MainInvoices.vue').default);
Vue.component('invoices-create',require('./components/InvoicesCreate.vue').default);
Vue.component('invoices-edit',require('./components/InvoicesEdit.vue').default);

Vue.component('create-invoice-products-table',require('./components/CreateInvoiceProductsTable.vue').default);
Vue.component('edit-invoice-products-table',require('./components/EditInvoiceProductsTable.vue').default);
Vue.component('invoices-table',require('./components/InvoicesTable.vue').default);

Vue.component('print-invoice',require('./components/PrintInvoice.vue').default);


Vue.component('main-suppliers',require('./components/MainSuppliers.vue').default);
Vue.component('create-edit-supplier',require('./components/CreateEditSupplier.vue').default);
Vue.component('suppplier-card',require('./components/SupplierCard.vue').default);

Vue.component('edit-supplier',require('./components/EditSupplier.vue').default);

Vue.component('supplies-table',require('./components/SuppliesTable.vue').default);
Vue.component('create-edit-supply',require('./components/CreateEditSupply.vue').default);
Vue.component('payment-table',require('./components/PaymentTable.vue').default);
Vue.component('print-dashboard',require('./components/PrintDashBoard.vue').default);



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

