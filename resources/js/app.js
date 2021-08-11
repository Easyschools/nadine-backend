require("./bootstrap");
window.Vue = require("vue");
import router from "./router";
import swal from "sweetalert";
import alertsMixin from "./mixins/alertsMixin";
import { PaginationPlugin, FormTagsPlugin } from "bootstrap-vue";
import store from "./store";

require("./store/subscriber");
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
axios.defaults.baseURL = "https://admin.unitart.net";
store.dispatch("auth/attempt", localStorage.getItem("token"));

Vue.mixin(alertsMixin);
Vue.component("the-container", require("./containers/TheContainer").default);

const app = new Vue({
    el: "#app",
    store,
    router,
    swal
});
