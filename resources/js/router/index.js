import Vue from 'vue';
import Router from 'vue-router';
import AuthMiddleware from '../router/middleware/auth';

Vue.use(Router);

import TypeList from './../views/type/List';
import TypeEdit from './../views/type/Edit';
import Home from './../views/Home';
import Login from './../views/Login';
import syntaxList from './../views/tag/List';
import syntaxCreate from './../views/tag/Create';
import syntaxEdit from './../views/tag/Edit';
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
        AuthMiddleware(to,from,next);
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
            path: "/admin/type",
            component: View,
            redirect: 'admin/type/list',
            meta: {requiresAuth: true},
            children: [
                {
                    path: 'list',
                    component: TypeList,
                },
                {
                    path: 'edit/:id',
                    component: TypeEdit,
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
                    component: syntaxList,
                },
                {
                    path: 'create',
                    component: syntaxCreate,
                },
                {
                    path: 'edit/:id',
                    component: syntaxEdit,
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
        }, ,
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
