import { createWebHistory, createRouter } from "vue-router";
import Login from "../pages/auth/Login.vue";

const routes = [
    {
        path: "/",
        name: "login",
        component: Login,
    },

    {
        path: "/:unauthorized(.*)*",
        name: "404",
        component: () => import("../error/404.vue"),
    },
    {
        path: "/admin-dashboard",
        name: "admin-dashboard",
        component: () => import("../pages/admin/AdminDashboard.vue"),
        meta: {
            requireToken: true,
        },
    },
    {
        path: "/admin-user-list",
        name: "admin-user-list",
        component: () => import("../pages/admin/AdminUserList.vue"),
    },
    {
        path: "/admin-update-user/:id",
        name: "admin-update-user",
        component: () => import("../pages/admin/AdminUpdateUser.vue"),
    },
    {
        path: "/create-user",
        name: "create-user",
        component: () => import("../pages/admin/AdminCreateUser.vue"),
    },
    {
        path: "/admin-assign-role",
        name: "admin-assign-role",
        component: () => import("../pages/admin/Admin_Assign_Role.vue"),
    },
    {
        path: "/admin-new-item",
        name: "admin-new-item",
        component: () => import("../pages/admin/AdminNewItem.vue"),
    },

    {
        path: "/admin-inventory-list",
        name: "admin-inventory-list",
        component: () => import("../pages/admin/AdminInventoryList.vue"),
    },
    {
        path: "/admin-edit-item/:id",
        name: "admin-edit-item",
        component: () => import("../pages/admin/AdminEditItem.vue"),
    },
    {
        path: "/admin-scheduling",
        name: "admin-scheduling",
        component: () => import("../pages/admin/AdminScheduling.vue"),
    },
    {
        path: "/admin-in-barcode",
        name: "admin-in-barcode",
        component: () => import("../pages/admin/Admin_In_Barcode.vue"),
    },
    {
        path: "/admin-out-barcode",
        name: "admin-out-barcode",
        component: () => import("../pages/admin/Admin_Out_Barcode.vue"),
    },
    {
        path: "/admin-view-barcode",
        name: "admin-view-barcode",
        component: () => import("../pages/admin/Admin_View_Barcode.vue"),
    },
    {
        path: "/admin-profile",
        name: "admin-profile",
        component: () => import("../pages/admin/Admin_Profile.vue"),
    },
    {
        path: "/admin-schedule-request",
        name: "admin-schedule-request",
        component: () => import("../pages/admin/Admin_Request_Schedule.vue"),
    },
    {
        path: "/admin-track-low-stock",
        name: "admin-track-low-stock",
        component: () => import("../pages/admin/Admin_Track_Low_Stock.vue"),
    },
    {
        path: "/admin-set-stock",
        name: "admin-set-stock",
        component: () => import("../pages/admin/Admin_Set_Stock.vue"),
    },
    {
        path: "/admin-stock-adjustment",
        name: "admin-stock-adjustment",
        component: () => import("../pages/admin/Admin_Stock_Logs.vue"),
    },
    {
        path: "/admin-category-list",
        name: "admin-category-list",
        component: () => import("../pages/admin/Admin_Category_List.vue"),
    },
    {
        path: "/admin-new-category",
        name: "admin-new-category",
        component: () => import("../pages/admin/Admin_New_Category.vue"),
    },
    {
        path: "/admin-item-Logs",
        name: "admin-item-logs",
        component: () => import("../pages/admin/Admin_Item_Logs.vue"),
    },
   

    {
        path: "/inventory-manager-dashboard",
        name: "inventory-manager-dashboard",
        component: () =>
            import("../pages/inventory-manager/ManagerDashboard.vue"),
    },
    {
        path: "/inventory-manager-scheduling",
        name: "inventory-manager-scheduling",
        component: () => import("../pages/inventory-manager/IM_Scheduling.vue"),
    },
    {
        path: "/inventory-manager-item-list",
        name: "inventory-manager-item-list",
        component: () => import("../pages/inventory-manager/IM_ItemList.vue"),
    },
    {
        path: "/inventory-manager-in-barcode",
        name: "inventory-manager-in-barcode",
        component: () => import("../pages/inventory-manager/IM_In_Barcode.vue"),
    },
    {
        path: "/inventory-manager-Out-barcode",
        name: "inventory-manager-out-barcode",
        component: () =>
            import("../pages/inventory-manager/IM_Out_Barcode.vue"),
    },
    {
        path: "/inventory-manager-view-barcode",
        name: "inventory-manager-view-barcode",
        component: () =>
            import("../pages/inventory-manager/IM_View_Barcode.vue"),
    },
    {
        path: "/inventory-manager-schedule-request",
        name: "inventory-manager-schedule-request",
        component: () =>
            import("../pages/inventory-manager/IM_Request_Schedule.vue"),
    },
    {
        path: "/member-dashboard",
        name: "member-dashboard",
        component: () => import("../pages/member/MemberDashboard.vue"),
    },
    {
        path: "/nav",
        name: "nav",
        component: () => import("../pages/test/Nav.vue"),
    },
    {
        path: "/test-login",
        name: "test-login",
        component: () => import("../pages/test/Login.vue"),
    },
    {
        path: "/test-post",
        name: "test-post",
        component: () => import("../pages/test/Post.vue"),
    },
    {
        path: "/test-barcode",
        name: "test-barcode",
        component: () => import("../pages/admin/Barcode.vue"),
    },
    {
        path: "/member-item-list",
        name: "member-item-list",
        component: () => import("../pages/member/Member_ItemList.vue"),
    },
    {
        path: "/member-scheduling",
        name: "member-scheduling",
        component: () => import("../pages/member/Member_Scheduling.vue"),
    },
    {
        path: "/member-view-barcode",
        name: "member-view-barcode",
        component: () => import("../pages/member/Member_View_Barcode.vue"),
    },
    {
        path: "/TL-home",
        name: "TL-home",
        component: () => import("../pages/TL/TL_Home.vue"),
    },
    {
        path: "/TL-scan-item-view",
        name: "TL-scan-item-view",
        component: () => import("../pages/TL/TL_Scan_Item_View.vue"),
    },
    {
        path: "/TL-schedule-request",
        name: "TL-schedule-request",
        component: () => import("../pages/TL/TL_Request_Schedule.vue"),
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        return (
            savedPosition ||
            new Promise((resolve) => {
                setTimeout(() => resolve({ top: 0, behavior: "smooth" }), 1);
            })
        );
        return { top: null, left: null, behavior: null };
    },
});

//   router.beforeEach((to,from) => {
//     const adminToken = localStorage.getItem('administrationPermission')
//     if(to.meta.requireToken && !adminToken){
//         return {
//             name: '404'
//         }
//     }
//   })
export default router;
