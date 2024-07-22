import { createWebHistory, createRouter } from 'vue-router'
import Login from '../pages/auth/Login.vue'



const routes = [
    {
        path: '/',
        name: 'login',
        component: Login
    },

    {
        path: '/:unauthorized(.*)*',
        name: '404',
        component: () => import ('../error/404.vue')
    }
    ,
    {
        path:'/admin-dashboard',
        name:'admin-dashboard',
        component: ()=>import('../pages/admin/AdminDashboard.vue'),
        // meta: {
        //     requireToken: true
        // }
    },
    {
        path:'/inventory-manager-dashboard',
        name:'inventory-manager-dashboard',
        component: ()=>import('../pages/inventory-manager/ManagerDashboard.vue')
    },
    {
        path:'/member-dashboard',
        name:'member-dashboard',
        component: ()=>import('../pages/member/MemberDashboard.vue')
    }
]


const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior (to, from, savedPosition) {
        return savedPosition || new Promise ((resolve => {
            setTimeout(() => resolve({top:0, behavior: "smooth"}),1)
        }))
        return {top:null,left:null, behavior: null}
    }
  })

//   router.beforeEach((to,from) => {
//     const adminToken = localStorage.getItem('administrationPermission')
//     if(to.meta.requireToken && !adminToken){
//         return {
//             name: '404'
//         }
//     }
//   })
  export default router;
