import { createRouter, createWebHashHistory } from 'vue-router'
import store from '../store';

const routes = [
    // {
    //     path: '/',
    //     name: 'root',
    //     component: () => import('../views/Login'),
    //     meta: { requiresAuth: false }
    // },
    {
        path: '/',
        name: 'List',
        component: () => import('../views/List'),
        meta: { requiresAuth: true }
    },
    {
        path: '/questions',
        name: 'Questions',
        component: () => import('../views/Questions'),
        meta: { requiresAuth: true }
    },
    {
        path: '/slots',
        name: 'Slots',
        component: () => import('../views/Slots'),
        meta: { requiresAuth: true }
    },
   /* {
        path: "/:catchAll(.*)",
        component: NotFound,
    }*/
]

const router = createRouter({
    history: createWebHashHistory(process.env.BASE_URL),
    routes,
    scrollBehavior() {
        return { top: 0 }
    },
})

// router.beforeEach((to) => {
//
//     store.dispatch('Auth/getUser')
//     const type = localStorage.getItem("type");
//
//     console.log(to.meta.requiresAuth)
//     console.log(store.getters['Auth/loggedIn'])
//     console.log(to.meta.requiresAuth && !store.getters['Auth/loggedIn'])
//
//     if (to.meta.requiresAuth && !store.getters['Auth/loggedIn']) {
//         return {
//             name: 'root'
//         }
//     }
//
//     if (to.meta.type < type ) {
//         return {
//             name: 'root'
//         }
//     }
// })
export default router

