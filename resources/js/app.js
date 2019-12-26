/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import 'vue-select/dist/vue-select.css';

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

Vue.component('v-select', VueSelect.VueSelect);
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
            "name" : $('#old_client_name').val()
        },
        old_seller_values: {
            "id": $('#old_seller_id').val(),
            "name" : $('#old_seller_name').val()
        },
        old_product_values: {
            "id": $('#old_product_id').val(),
            "name" : $('#old_product_name').val()
        },
    },
    methods: {
        searchClient(search, loading) {
            loading(true);
            this.searchC(loading, search, this);
        },
        searchC: _.debounce((loading, search, vm) => {
            fetch(
                `/clientes/buscar?name=${escape(search)}`
            ).then(res => {
                res.json().then(json => (vm.options = json));
                loading(false);
            });
        }, 350),

        searchSeller(search, loading) {
            loading(true);
            this.searchS(loading, search, this);
        },
        searchS: _.debounce((loading, search, vm) => {
            fetch(
                `/vendedores/buscar?name=${escape(search)}`
            ).then(res => {
                res.json().then(json => (vm.options = json));
                loading(false);
            });
        }, 350),

        searchProduct(search, loading) {
            loading(true);
            this.searchP(loading, search, this);
        },
        searchP: _.debounce((loading, search, vm) => {
            fetch(
                `/productos/buscar?name=${escape(search)}`
            ).then(res => {
                res.json().then(json => (vm.options = json));
                loading(false);
            });
        }, 350)
    }
});
