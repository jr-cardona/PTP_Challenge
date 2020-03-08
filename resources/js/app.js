/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import 'vue-select/dist/vue-select.css';
import VueSelect from 'vue-select/dist/vue-select.js';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
Vue.component('v-select', VueSelect);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
    data: {
        options: [],
        old_client_values: {
            "id": $('#old_client_id').val(),
            "fullname" : $('#old_client_fullname').val(),
        },
        old_owner_values: {
            "id": $('#old_owner_id').val(),
            "fullname" : $('#old_owner_fullname').val(),
        },
        old_product_values: {
            "id": $('#old_product_id').val(),
            "name" : $('#old_product_name').val(),
            "price" : $('#old_product_price').val(),
        },
    },
    methods: {
        searchClient(search, loading) {
            loading(true);
            fetch(
                `/clientes/buscar?name=${escape(search)}`
            ).then(res => {
                res.json().then(json => (this.options = json));
                loading(false);
            });
        },
        searchOwner(search, loading) {
            loading(true);
            fetch(
                `/usuarios/buscar?name=${escape(search)}`
            ).then(res => {
                res.json().then(json => (this.options = json));
                loading(false);
            });
        },
        searchProduct(search, loading) {
            loading(true);
            fetch(
                `/productos/buscar?name=${escape(search)}`
            ).then(res => {
                res.json().then(json => (this.options = json));
                loading(false);
            });
        },
    }
});
