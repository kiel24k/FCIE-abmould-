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
    },

    {
        path:'/admin-dashboard',
        name:'admin-dashboard',
        component: ()=>import('../pages/admin/AdminDashboard.vue'),
        meta: {
            requireToken: true
        }
    },
    {
        path:'/admin-user-list',
        name: 'admin-user-list',
        component: () => import ('../pages/admin/AdminUserList.vue')
    },
    {
        path:'/admin-update-user/:id',
        name: 'admin-update-user',
        component: () => import('../pages/admin/AdminUpdateUser.vue')
    },
    {
        path:'/create-user',
        name: 'create-user',
        component: () => import ('../pages/admin/AdminCreateUser.vue')
    },
    {
        path: '/amdin-new-item',
        name: 'admin-new-item',
        component: () => import ('../pages/admin/AdminNewItem.vue')

    },
    {
        path: '/admin-inventory-list',
        name: 'admin-inventory-list',
        component: () => import ('../pages/admin/AdminInventoryList.vue')

    },
    {
        path:'/admin-edit-item/:id',
        name:'admin-edit-item',
        component: () => import('../pages/admin/AdminEditItem.vue')

    },
    {
        path: '/admin-scheduling',
        name: 'admin-scheduling',
        component: () => import('../pages/admin/AdminScheduling.vue')
    },
    {
        path:'/inventory-manager-dashboard',
        name:'inventory-manager-dashboard',
        component: ()=>import('../pages/inventory-manager/ManagerDashboard.vue')
    },
    {
        path: '/inventory-manager-scheduling',
        name: 'inventory-manager-scheduling',
        component: () => import('../pages/inventory-manager/IM_Scheduling.vue')
    },
    {
        path:'/inventory-manager-item-list',
        name: 'inventory-manager-item-list',
        component: () => import('../pages/inventory-manager/IM_ItemList.vue')
    },
    {
        path:'/member-dashboard',
        name:'member-dashboard',
        component: ()=>import('../pages/member/MemberDashboard.vue')
    },
    {
        path:'/nav',
        name: 'nav',
        component: () => import('../pages/test/Nav.vue')
    },
    {
        path:'/test-login',
        name: 'test-login',
        component: () => import('../pages/test/Login.vue')
    },
    {
        path:'/test-post',
        name: 'test-post',
        component: () => import('../pages/test/Post.vue')
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
