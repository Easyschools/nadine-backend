import Vue from 'vue';
import Router from 'vue-router';
import AuthMiddleware from '../router/middleware/auth';

Vue.use(Router);

import CategoryList from './../views/category/List';
import CategoryEdit from './../views/category/Edit';
import MaterialList from './../views/material/List';
import MaterialEdit from './../views/material/Edit';
import CollectionList from './../views/collection/List';
import CollectionEdit from './../views/collection/Edit';
import DimensionList from './../views/dimension/List';
import DimensionEdit from './../views/dimension/Edit';
import ColorList from './../views/color/List';
import ColorEdit from './../views/color/Edit';
import Home from './../views/Home';
import Login from './../views/Login';
import tagList from './../views/tag/List';
import tagCreate from './../views/tag/Create';
import tagEdit from './../views/tag/Edit';
import productList from '../views/product/List';
import productCreate from '../views/product/Create';
import productEdit from '../views/product/Edit';
import definitionList from './../views/definition/List';
import definitionCreate from './../views/definition/Create';
import definitionEdit from './../views/definition/Edit';
import prepositionList from './../views/preposition/List';
import prepositionCreate from './../views/preposition/Create';
import prepositionEdit from './../views/preposition/Edit';
import lessonList from './../views/lesson/List';
import lessonCreate from './../views/lesson/Create';
import lessonEdit from './../views/lesson/Edit';
import userList from './../views/user/List';
import userCreate from './../views/user/Create';
import userEdit from './../views/user/Edit';
import exerciseList from './../views/exercise/List';
import exerciseCreate from './../views/exercise/Create';
import exerciseEdit from './../views/exercise/Edit';
import Messages from './../views/message/List';

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
            path: "/admin/category",
            component: View,
            redirect: 'admin/category/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: CategoryList,
                },
                {
                    path: 'edit/:id',
                    component: CategoryEdit,
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
                    component: MaterialList,
                },
                {
                    path: 'edit/:id',
                    component: MaterialEdit,
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
                    component: CollectionList,
                },
                {
                    path: 'edit/:id',
                    component: CollectionEdit,
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
                    component: ColorList,
                },
                {
                    path: 'edit/:id',
                    component: ColorEdit,
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
                    component: DimensionList,
                },
                {
                    path: 'edit/:id',
                    component: DimensionEdit,
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
                    path: 'edit/:id',
                    component: productEdit,
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
            path: "/admin/preposition",
            component: View,
            redirect: 'admin/preposition/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: prepositionList,
                },
                {
                    path: 'create',
                    component: prepositionCreate,
                },
                {
                    path: 'edit/:id',
                    component: prepositionEdit,
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
            path: "/admin/user",
            component: View,
            redirect: 'admin/user/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: userList,
                },
                {
                    path: 'create',
                    component: userCreate,
                },
                {
                    path: 'edit/:id',
                    component: userEdit,
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
