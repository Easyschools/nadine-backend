import "./bootstrap";
import Vue from 'vue/dist/vue.js';
import router from "./router";
import swal from "sweetalert";
import container from "./containers/TheContainer.vue";
import alertsMixin from "./mixins/alertsMixin";
import { PaginationPlugin, FormTagsPlugin } from "bootstrap-vue";
import store from "./store";
import axios from "axios"; // Import axios

console.log(router);

import "./store/subscriber";
// import {VueEditor} from "vue2-editor";

// Install BootstrapVue
Vue.use(PaginationPlugin);
Vue.use(FormTagsPlugin);
// Vue.use(VueEditor);

axios.defaults.baseURL = "/api";
axios.interceptors.response.use(
    function(response) {

        return response;
    },
    function(error) {
        console.log(error.response.status);

        if (error.response.status == 401) {
            console.log("arrival");
            store.dispatch("logout");
            router.push("/admin/login");
        }
        return Promise.reject(error);
    }
);


// axios.defaults.baseURL = "https://admin.unitart.net";
store.dispatch("auth/attempt", localStorage.getItem("token"));

Vue.mixin(alertsMixin);
Vue.component("the-container", container);

const app = new Vue({
    store,
    router,
    swal
  }).$mount('#app')

// const app = new Vue({
//     el: "#app",
//     store,
//     router,
//     swal
// });
