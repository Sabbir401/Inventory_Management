import { createWebHistory, createRouter } from "vue-router";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: () => import('./pages/home.vue'),
    },
    {
        path: '/login',
        name: 'Login',
        component: () => import('./pages/login.vue'),
        meta:{
            requiresAuth:false
        }
    },
    {
        path: '/register',
        name: 'Register',
        component: () => import('./pages/register.vue'),
        meta:{
            requiresAuth:false
        }
    },
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('./pages/dashboard.vue'),
        meta:{
            requiresAuth:true
        }
    },
    // {
    //     path: '/inventory',
    //     name: 'Inventory',
    //     component: () => import('./pages/createInventory.vue'),
    //     meta:{
    //         requiresAuth:true
    //     }
    // },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to,from) =>{
    if(to.meta.requiresAuth && !localStorage.getItem('token')){
        return { name:'Login' }
    }
    if(to.meta.requiresAuth == false && localStorage.getItem('token')){
        return { name:'Dashboard' }
    }
})

export default router;
