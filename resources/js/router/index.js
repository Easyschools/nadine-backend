// import Vue from "vue";
import Vue from 'vue/dist/vue.js';

import VueRouter from "vue-router";
import AuthMiddleware from "../router/middleware/auth";

const originalPush = VueRouter.prototype.push;

VueRouter.prototype.push = function push(location) {
    return originalPush.call(this, location).catch(err => err);
};

Vue.use(VueRouter);

import categoryList from "./../views/category/List.vue";
import categoryEdit from "./../views/category/Edit.vue";
import materialList from "./../views/material/List.vue";
import materialEdit from "./../views/material/Edit.vue";
import collectionList from "./../views/collection/List.vue";
import collectionEdit from "./../views/collection/Edit.vue";

import dimensionList from "./../views/dimension/List.vue";
import dimensionEdit from "./../views/dimension/Edit.vue";
import informationList from "./../views/information/List.vue";
import informationEdit from "./../views/information/Edit.vue";
import informationCreate from "./../views/information/Create.vue";
import colorList from "./../views/color/List.vue";
import colorEdit from "./../views/color/Edit.vue";
import Home from "./../views/Home.vue";
import Login from "./../views/Login.vue";
import sliderList from "./../views/slider/List.vue";
import sliderCreate from "./../views/slider/Create.vue";
import sliderEdit from "./../views/slider/Edit.vue";
import celebrityList from "./../views/celebrity/List.vue";
import celebrityCreate from "./../views/celebrity/Create.vue";
import celebrityEdit from "./../views/celebrity/Edit.vue";
import pressMediaList from "./../views/pressMedia/List.vue";
import pressMediaCreate from "./../views/pressMedia/Create.vue";
import pressMediaEdit from "./../views/pressMedia/Edit.vue";

import brandList from "./../views/brand/List.vue";
import brandCreate from "./../views/brand/Create.vue";
import brandEdit from "./../views/brand/Edit.vue";
import couponList from "./../views/coupon/List.vue";
import couponCreate from "./../views/coupon/Create.vue";
import couponEdit from "./../views/coupon/Edit.vue";
import tagList from "./../views/tag/List.vue";
import tagCreate from "./../views/tag/Create.vue";
import tagEdit from "./../views/tag/Edit.vue";
import statusList from "./../views/status/List.vue";
import statusCreate from "./../views/status/Create.vue";
import statusEdit from "./../views/status/Edit.vue";
import offerList from "./../views/offer/List.vue";
import offerCreate from "./../views/offer/Create.vue";
import offerEdit from "./../views/offer/Edit.vue";
import cityList from "./../views/city/List.vue";
import cityCreate from "./../views/city/Create.vue";
import cityEdit from "./../views/city/Edit.vue";
import productList from "../views/product/List.vue";
import productCreate from "../views/product/Create.vue";
import productEdit from "../views/product/Edit.vue";
import orderList from "../views/order/List.vue";
import orderCreate from "../views/order/Create.vue";
import orderEdit from "../views/order/Edit.vue";
import orderShow from "../views/order/Show.vue";
import definitionList from "./../views/definition/List.vue";
import definitionCreate from "./../views/definition/Create.vue";
import definitionEdit from "./../views/definition/Edit.vue";
import lessonList from "./../views/lesson/List.vue";
import lessonCreate from "./../views/lesson/Create.vue";
import lessonEdit from "./../views/lesson/Edit.vue";
import customerList from "./../views/customer/List.vue";
import customerCreate from "./../views/customer/Create.vue";
import customerEdit from "./../views/customer/Edit.vue";
import exerciseList from "./../views/exercise/List.vue";
import exerciseCreate from "./../views/exercise/Create.vue";
import exerciseEdit from "./../views/exercise/Edit.vue";
import Messages from "./../views/message/List.vue";
import Favourites from "./../views/favourite/List.vue";

const View = () => import("./../components/View.vue");
const router = new VueRouter({
    mode: "history",
    routes: configRoutes()
});
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        AuthMiddleware(to, from, next);
    }
    next(); // make sure to always call next()!
});
function configRoutes() {
    return [
        {
            path: "/admin/login",
            component: Login
        },
        {
            path: "/admin/home",
            component: View,
            meta: { requiresAuth: true },
            children: [
                {
                    path: "/",
                    component: Home
                }
            ]
        },
        {
            path: "/admin/message",
            component: View,
            meta: { requiresAuth: true },
            children: [
                {
                    path: "/",
                    component: Messages
                }
            ]
        },
        {
            path: "/admin/favourite",
            component: View,
            meta: { requiresAuth: true },
            children: [
                {
                    path: "/",
                    component: Favourites
                }
            ]
        },
        {
            path: "/admin/city",
            component: View,
            redirect: "admin/city/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: cityList
                },
                {
                    path: "edit/:id",
                    component: cityEdit
                }
            ]
        },
        {
            path: "/admin/category",
            component: View,
            redirect: "admin/category/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: categoryList
                },
                {
                    path: "edit/:id",
                    component: categoryEdit
                }
            ]
        },
        {
            path: "/admin/material",
            component: View,
            redirect: "admin/material/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: materialList
                },
                {
                    path: "edit/:id",
                    component: materialEdit
                }
            ]
        },
        {
            path: "/admin/collection",
            component: View,
            redirect: "admin/collection/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: collectionList
                },
                {
                    path: "edit/:id",
                    component: collectionEdit
                }
            ]
        },
        {
            path: "/admin/color",
            component: View,
            redirect: "admin/color/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: colorList
                },
                {
                    path: "edit/:id",
                    component: colorEdit
                }
            ]
        },
        {
            path: "/admin/dimension",
            component: View,
            redirect: "admin/dimension/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: dimensionList
                },
                {
                    path: "edit/:id",
                    component: dimensionEdit
                }
            ]
        },
        {
            path: "/admin/tag",
            component: View,
            redirect: "admin/tag/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: tagList
                },
                {
                    path: "create",
                    component: tagCreate
                },
                {
                    path: "edit/:id",
                    component: tagEdit
                }
            ]
        },
        {
            path: "/admin/status",
            component: View,
            redirect: "admin/status/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: statusList
                },
                {
                    path: "create",
                    component: statusCreate
                },
                {
                    path: "edit/:id",
                    component: statusEdit
                }
            ]
        },
        {
            path: "/admin/offer",
            component: View,
            redirect: "admin/offer/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: offerList
                },
                {
                    path: "create",
                    component: offerCreate
                },
                {
                    path: "edit/:id",
                    component: offerEdit
                }
            ]
        },
        {
            path: "/admin/slider",
            component: View,
            redirect: "admin/slider/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: sliderList
                },
                {
                    path: "create",
                    component: sliderCreate
                },
                {
                    path: "edit/:id",
                    component: sliderEdit
                }
            ]
        },
        {
            path: "/admin/celebrity",
            component: View,
            redirect: "admin/celebrity/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: celebrityList
                },
                {
                    path: "create",
                    component: celebrityCreate
                },
                {
                    path: "edit/:id",
                    component: celebrityEdit
                }
            ]
        },
        {
            path: "/admin/pressMedia",
            component: View,
            redirect: "admin/pressMedia/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: pressMediaList
                },
                {
                    path: "create",
                    component: pressMediaCreate
                },
                {
                    path: "edit/:id",
                    component: pressMediaEdit
                }
            ]
        },
        {
            path: "/admin/brand",
            component: View,
            redirect: "admin/brand/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: brandList
                },
                {
                    path: "create",
                    component: brandCreate
                },
                {
                    path: "edit/:id",
                    component: brandEdit
                }
            ]
        },
        {
            path: "/admin/coupon",
            component: View,
            redirect: "admin/coupon/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: couponList
                },
                {
                    path: "create",
                    component: couponCreate
                },
                {
                    path: "edit/:id",
                    component: couponEdit
                }
            ]
        },
        {
            path: "/admin/city",
            component: View,
            redirect: "admin/city/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: cityList
                },
                {
                    path: "create",
                    component: cityCreate
                },
                {
                    path: "edit/:id",
                    component: cityEdit
                }
            ]
        },
        {
            path: "/admin/product",
            component: View,
            redirect: "/admin/product/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: productList
                },
                {
                    path: "create",
                    component: productCreate
                },
                {
                    path: "edit/:slug/:page",
                    component: productEdit
                }
            ]
        },
        {
            path: "/admin/order",
            component: View,
            redirect: "/admin/order/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: orderList
                },
                {
                    path: "create",
                    component: orderCreate
                },
                {
                    path: "edit/:id",
                    component: orderEdit
                },
                {
                    path: "show/:id",
                    component: orderShow
                }
            ]
        },
        {
            path: "/admin/definition",
            component: View,
            redirect: "admin/definition/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: definitionList
                },
                {
                    path: "create",
                    component: definitionCreate
                },
                {
                    path: "edit/:id",
                    component: definitionEdit
                }
            ]
        },
        {
            path: "/admin/lesson",
            component: View,
            redirect: "admin/lesson/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: lessonList
                },
                {
                    path: "create",
                    component: lessonCreate
                },
                {
                    path: "edit/:id",
                    component: lessonEdit
                }
            ]
        },
        {
            path: "/admin/customer",
            component: View,
            redirect: "admin/customer/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: customerList
                },
                {
                    path: "create",
                    component: customerCreate
                },
                {
                    path: "edit/:id",
                    component: customerEdit
                }
            ]
        },
        {
            path: "/admin/information",
            component: View,
            redirect: "admin/information/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: informationList
                },
                {
                    path: "create",
                    component: informationCreate
                },
                {
                    path: "edit/:id",
                    component: informationEdit
                }
            ]
        },
        {
            path: "/admin/exercise",
            component: View,
            redirect: "admin/exercise/list",
            meta: { requiresAuth: true },
            children: [
                {
                    path: "list",
                    component: exerciseList
                },
                {
                    path: "create",
                    component: exerciseCreate
                },
                {
                    path: "edit/:id",
                    component: exerciseEdit
                }
            ]
        }
    ];
}

export default router;
