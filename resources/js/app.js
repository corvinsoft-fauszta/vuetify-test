require('./bootstrap');

import vuetify from "./plugins/vuetify";

window.Vue = require('vue').default;

const token = document.getElementById("token");

if (window.Laravel) {
    console.log(window.Laravel.api_token);
    axios.defaults.headers["Authorization"] = `Bearer ${window.Laravel.api_token}`;
}

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const app = new Vue({
    vuetify,
    el: '#app',
});
