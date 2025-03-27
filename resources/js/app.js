import './bootstrap';
import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';


import App from './App.vue';
import Create from './components/Create.vue';
import Index from './components/Index.vue';
import Edit from './components/Edit.vue';
import Show from './components/Show.vue';

// Define your routes
const routes = [
    {
        name: 'Index',
        path: '/',
        component: Index
    },
    {
        name: 'Edit',
        path: '/edit/:id',
        component: Edit
    },
    {
        name: 'Create',
        path: '/create',
        component: Create
    },
    {
        name: 'Show',
        path: '/show/:id',
        component: Show
    },
];

// Create the router instance
const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Create and mount the root instance
createApp(App)
    .use(router)
    .mount('#app');