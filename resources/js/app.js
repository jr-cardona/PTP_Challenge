require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue';
import 'vue-select/dist/vue-select.css';
import VueSelect from 'vue-select/dist/vue-select.js';
import Notifications from "./components/Notifications";

Vue.component('v-select', VueSelect);
Vue.component('notifications', Notifications);

const app = new Vue({
    el: "#app",
    data: {
        options: [],
        old_client_values: {
            "id": $('#old_client_id').val(),
            "fullname" : $('#old_client_fullname').val(),
        },
        old_user_values: {
            "id": $('#old_created_by').val(),
            "fullname" : $('#old_user_fullname').val(),
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
        searchUser(search, loading) {
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
