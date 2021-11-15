require("../bootstrap");
import Vue from "vue";
import VueRouter from "vue-router";
import axios from "axios";
window.Vue = require("vue");
window.axios = axios;
Vue.use(VueRouter);
import store from "./store";
var $ = require('jquery');
window.$ = window.jQuery = require('jquery');
//sweet alert
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import swal from "sweetalert2";
window.swal = swal;
const options = {
    confirmButtonColor: "#41b882",
    cancelButtonColor: "#ff7674"
};

import Viewer from "v-viewer";
import "viewerjs/dist/viewer.css";
Vue.use(Viewer);
/**end of image */

Vue.use(VueSweetalert2, options);
Vue.use(VueSweetalert2);

import Toasted from "vue-toasted";
Vue.use(Toasted, {
    duration: 9000,
    position: "top-right",
    action: {
        text: "Okay",
        onClick: (e, toastObject) => {
            toastObject.goAway(0);
        }
    }
});

import VueQuillEditor from 'vue-quill-editor'

import 'quill/dist/quill.core.css' // import styles
import 'quill/dist/quill.snow.css' // for snow theme
import 'quill/dist/quill.bubble.css' // for bubble theme

Vue.use(VueQuillEditor, /* { default global options } */);
/**image viewer */

// import Viewer from "v-viewer";
// import "viewerjs/dist/viewer.css";
// Vue.use(Viewer);
/**end of image */

axios.interceptors.request.use(
    config => {
        const token = localStorage.getItem('bakeryadmintoken');
        const auth = token ? `Bearer ${token}` : '';
        config.headers.common['Authorization'] = auth;
        return config;
    },
    error => Promise.reject(error),
);

// import VueQuillEditor from 'vue-quill-editor'

// import 'quill/dist/quill.core.css' // import styles
// import 'quill/dist/quill.snow.css' // for snow theme
// import 'quill/dist/quill.bubble.css' // for bubble theme

// Vue.use(VueQuillEditor, /* { default global options } */)

import Login from "./pages/Login.vue";
import Dashboard from "./pages/Dashboard";
import ForgotPass from "./pages/ForgotPass.vue";
import Overview from "./pages/Overview.vue";
import Notfound from "./pages/Notfound.vue";
import Sidebar from "./pages/Sidebar.vue";
import Admin from "./pages/Admin.vue";
import Roles from "./pages/Roles.vue";


import Members from "./pages/Members.vue";

import Product from "./pages/Product.vue";
import Products from "./pages/Products.vue";

import Allgallery from "./pages/Allgallery.vue";
import newgallery from "./pages/newgallery.vue";
import neworders from "./pages/neworders.vue";
import oldorders from "./pages/oldorders.vue";
import Customers from "./pages/Customers.vue";
import Category from "./pages/Category.vue";

Vue.component('sidebar', Sidebar);

Vue.prototype.$churchusername = localStorage.getItem('bakeryadminusername');

import Embed from 'v-video-embed'
// global register
Vue.use(Embed);

const router = new VueRouter({

    mode: "history",
    routes: [
        {
            path: "/admin-login",
            name: "login",
            component: Login
        },
        {
            path: "/admin-forgot-password",
            name: "ForgotPass",
            component: ForgotPass
        },
        {
            path: "/admin-dashboard",
            name: "dashboard",
            component: Dashboard,
            meta: { requiresAuth: true },
            children: [

                {
                    path: "",
                    name: "Overview",
                    component: Overview
                },

                {
                    path: "administrators",
                    name: "Admin",
                    component: Admin
                },
                {
                    path: "all-products",
                    name: "products",
                    component: Products
                },
                {
                    path: "new-product",
                    name: "product",
                    component: Product
                },
                {
                    path: "new-orders",
                    name: "orders",
                    component: neworders
                },
                {
                    path: "old-orders",
                    name: "oldorders",
                    component: oldorders
                },


                {
                    path: "product/:id",
                    name: "ViewProduct",
                    component: Product
                },

                {
                    path: "users",
                    name: "members",
                    component: Members
                },
                {
                    path: "categories",
                    name: "category",
                    component: Category
                },
                {
                    path: "customers",
                    name: "customers",
                    component: Customers
                },

                {
                    path: 'not-permitted',
                    name: 'Notfound',
                    component: Notfound
                },


                {
                    path: "all-gallery",
                    name: "allGallery",
                    component: Allgallery
                },
                {
                    path: "new-gallery",
                    name: "newGallery",
                    component: newgallery
                },

            ]
        }
    ]
});


router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next();
            return;
        }
        next("/admin-login");
    } else {
        next();
    }
});


import App from "./pages/App";
const app = new Vue({
    el: "#app",
    router,
    store,
    render: h => h(App),

});

