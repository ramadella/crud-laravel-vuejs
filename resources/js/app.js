// app.js
import './bootstrap.js'
import { createApp } from 'vue';
import { createRouter, createWebHashHistory } from 'vue-router'

import App from '../views/App.vue';
import Create from '../components/crud/Create.vue';
import Index from '../components/crud/Index.vue';
import Edit from '../components/crud/Edit.vue';
import Login from '../components/auth/Login.vue';
import Register from '../components/auth/Register.vue';

const routes = [
    {
        name: 'Login',
        path: '/login',
        component: Login,
        meta: { guest: true }
    },
    {
        name: 'Register',
        path: '/register',
        component: Register,
        meta: { guset: true }
    },
    {
        name: 'Index',
        path: '/',
        component: Index,
        meta: { requiresAuth: true }
    },
    {
        name: 'Create',
        path: '/create',
        component: Create,
        meta: { requiresAuth: true }
    },
    {
        name: 'Edit',
        path: '/edit/:id',
        component: Edit,
        meta: { requiresAuth: true }
    }
];
const router = createRouter({
    history: createWebHashHistory(),
    routes,
});

router.beforeEach((to, from, next) => {
    const loggedIn = localStorage.getItem('token');
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!loggedIn) {
            next({ name: 'Login' });
        }
        else {
            next();
        }
    }
    else if (to.matched.some(record => record.meta.guest)) {
        if (loggedIn) {
            next({ name: 'Index' })
        }
        else {
            next();
        }
    }
    else {
        next();
    }
});

createApp(App).use(router).mount('#app');