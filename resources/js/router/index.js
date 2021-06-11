import Vue from 'vue';
import Router from 'vue-router';
import AuthMiddleware from '../router/middleware/auth';


const originalPush = Router.prototype.push

Router.prototype.push = function push(location) {

    return originalPush.call(this, location).catch(err => err)

};

Vue.use(Router);


import categoryList from './../views/category/List';
import categoryEdit from './../views/category/Edit';
import materialList from './../views/material/List';
import materialEdit from './../views/material/Edit';
import collectionList from './../views/collection/List';
import collectionEdit from './../views/collection/Edit';

import dimensionList from './../views/dimension/List';
import dimensionEdit from './../views/dimension/Edit';
import informationList from './../views/information/List';
import informationEdit from './../views/information/Edit';
import informationCreate from './../views/information/Create';
import colorList from './../views/color/List';
import colorEdit from './../views/color/Edit';
import Home from './../views/Home';
import Login from './../views/Login';
import sliderList from './../views/slider/List';
import sliderCreate from './../views/slider/Create';
import sliderEdit from './../views/slider/Edit';
import brandList from './../views/brand/List';
import brandCreate from './../views/brand/Create';
import brandEdit from './../views/brand/Edit';
import couponList from './../views/coupon/List';
import couponCreate from './../views/coupon/Create';
import couponEdit from './../views/coupon/Edit';
import tagList from './../views/tag/List';
import tagCreate from './../views/tag/Create';
import tagEdit from './../views/tag/Edit';
import statusList from './../views/status/List';
import statusCreate from './../views/status/Create';
import statusEdit from './../views/status/Edit';
import offerList from './../views/offer/List';
import offerCreate from './../views/offer/Create';
import offerEdit from './../views/offer/Edit';
import cityList from './../views/city/List';
import cityCreate from './../views/city/Create';
import cityEdit from './../views/city/Edit';
import productList from '../views/product/List';
import productCreate from '../views/product/Create';
import productEdit from '../views/product/Edit';
import orderList from '../views/order/List';
import orderCreate from '../views/order/Create';
import orderEdit from '../views/order/Edit';
import definitionList from './../views/definition/List';
import definitionCreate from './../views/definition/Create';
import definitionEdit from './../views/definition/Edit';
import lessonList from './../views/lesson/List';
import lessonCreate from './../views/lesson/Create';
import lessonEdit from './../views/lesson/Edit';
import customerList from './../views/customer/List';
import customerCreate from './../views/customer/Create';
import customerEdit from './../views/customer/Edit';
import exerciseList from './../views/exercise/List';
import exerciseCreate from './../views/exercise/Create';
import exerciseEdit from './../views/exercise/Edit';
import Messages from './../views/message/List';
import Favourites from './../views/favourite/List';

const View = () => import('./../components/View');

const router = new Router({
    mode: 'history',
    routes: configRoutes()
});
router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        AuthMiddleware(to, from, next);
    }
    next() // make sure to always call next()!
});

function configRoutes() {
    return [
        {
            path: "/admin/login",
            component: Login,
        },
        {
            path: "/admin/home",
            component: View,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '/',
                    component: Home,
                }
            ]
        },
        {
            path: "/admin/message",
            component: View,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '/',
                    component: Messages,
                }
            ]
        },
        {
            path: "/admin/favourite",
            component: View,
            meta: {requiresAuth: true},
            children: [
                {
                    path: '/',
                    component: Favourites,
                }
            ]
        },
        {
            path: "/admin/city",
            component: View,
            redirect: 'admin/city/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: cityList,
                },
                {
                    path: 'edit/:id',
                    component: cityEdit,
                }
            ]
        },
        {
            path: "/admin/category",
            component: View,
            redirect: 'admin/category/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: categoryList,
                },
                {
                    path: 'edit/:id',
                    component: categoryEdit,
                }
            ]
        },
        {
            path: "/admin/material",
            component: View,
            redirect: 'admin/material/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: materialList,
                },
                {
                    path: 'edit/:id',
                    component: materialEdit,
                }
            ]
        },
        {
            path: "/admin/collection",
            component: View,
            redirect: 'admin/collection/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: collectionList,
                },
                {
                    path: 'edit/:id',
                    component: collectionEdit,
                }
            ]
        },
        {
            path: "/admin/color",
            component: View,
            redirect: 'admin/color/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: colorList,
                },
                {
                    path: 'edit/:id',
                    component: colorEdit,
                }
            ]
        },
        {
            path: "/admin/dimension",
            component: View,
            redirect: 'admin/dimension/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: dimensionList,
                },
                {
                    path: 'edit/:id',
                    component: dimensionEdit,
                }
            ]
        },
        {
            path: "/admin/tag",
            component: View,
            redirect: 'admin/tag/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: tagList,
                },
                {
                    path: 'create',
                    component: tagCreate,
                },
                {
                    path: 'edit/:id',
                    component: tagEdit,
                }
            ]
        },
        {
            path: "/admin/status",
            component: View,
            redirect: 'admin/status/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: statusList,
                },
                {
                    path: 'create',
                    component: statusCreate,
                },
                {
                    path: 'edit/:id',
                    component: statusEdit,
                }
            ]
        },
        {
            path: "/admin/offer",
            component: View,
            redirect: 'admin/offer/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: offerList,
                },
                {
                    path: 'create',
                    component: offerCreate,
                },
                {
                    path: 'edit/:id',
                    component: offerEdit,
                }
            ]
        },
        {
            path: "/admin/slider",
            component: View,
            redirect: 'admin/slider/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: sliderList,
                },
                {
                    path: 'create',
                    component: sliderCreate,
                },
                {
                    path: 'edit/:id',
                    component: sliderEdit,
                }
            ]
        },
        {
            path: "/admin/brand",
            component: View,
            redirect: 'admin/brand/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: brandList,
                },
                {
                    path: 'create',
                    component: brandCreate,
                },
                {
                    path: 'edit/:id',
                    component: brandEdit,
                }
            ]
        },
        {
            path: "/admin/coupon",
            component: View,
            redirect: 'admin/coupon/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: couponList,
                },
                {
                    path: 'create',
                    component: couponCreate,
                },
                {
                    path: 'edit/:id',
                    component: couponEdit,
                }
            ]
        },
        {
            path: "/admin/city",
            component: View,
            redirect: 'admin/city/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: cityList,
                },
                {
                    path: 'create',
                    component: cityCreate,
                },
                {
                    path: 'edit/:id',
                    component: cityEdit,
                }
            ]
        },
        {
            path: "/admin/product",
            component: View,
            redirect: "/admin/product/list",
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: productList,
                },
                {
                    path: 'create',
                    component: productCreate,
                },
                {
                    path: 'edit/:slug/:page',
                    component: productEdit,
                }
            ]
        },
        {
            path: "/admin/order",
            component: View,
            redirect: "/admin/order/list",
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: orderList,
                },
                {
                    path: 'create',
                    component: orderCreate,
                },
                {
                    path: 'edit/:id',
                    component: orderEdit,
                }
            ]
        },
        {
            path: "/admin/definition",
            component: View,
            redirect: 'admin/definition/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: definitionList,
                },
                {
                    path: 'create',
                    component: definitionCreate,
                },
                {
                    path: 'edit/:id',
                    component: definitionEdit,
                }
            ]
        },
        {
            path: "/admin/lesson",
            component: View,
            redirect: 'admin/lesson/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: lessonList,
                },
                {
                    path: 'create',
                    component: lessonCreate,
                },
                {
                    path: 'edit/:id',
                    component: lessonEdit,
                }
            ]
        },
        {
            path: "/admin/customer",
            component: View,
            redirect: 'admin/customer/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: customerList,
                },
                {
                    path: 'create',
                    component: customerCreate,
                },
                {
                    path: 'edit/:id',
                    component: customerEdit,
                }
            ]
        },
        {
            path: "/admin/information",
            component: View,
            redirect: 'admin/information/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: informationList,
                },
                {
                    path: 'create',
                    component: informationCreate,
                },
                {
                    path: 'edit/:id',
                    component: informationEdit,
                }
            ]
        },
        {
            path: "/admin/exercise",
            component: View,
            redirect: 'admin/exercise/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: exerciseList,
                },
                {
                    path: 'create',
                    component: exerciseCreate,
                },
                {
                    path: 'edit/:id',
                    component: exerciseEdit,
                }
            ]
        }
    ];
}

export default router;
