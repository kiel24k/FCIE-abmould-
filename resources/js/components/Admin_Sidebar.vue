<template>
    <Logout v-if="logoutModal" @cancel="cancel" />
    <aside :class="{ hideSidebar: isHideSidebar }">
        <ul>
            <router-link :to="{ name: 'admin-dashboard' }">
                <li>
                    <img src="/public/icon/dashboard_icon.png" width="25px" alt="" />
                    <span>Dashboard</span>
                </li>
            </router-link>
            <hr>
            <h5 class="text-center">Barcode</h5>
            <router-link :to="{ name: 'admin-in-barcode' }">
                <li>
                    <img src="/public/icon/barcode_icon.png" width="25px" alt="" />
                    <span>In</span>
                </li>
            </router-link>
            <router-link :to="{ name: 'admin-out-barcode' }">
                <li>
                    <img src="/public/icon/barcode_icon.png" width="25px" alt="" />
                    <span>Out</span>
                </li>
            </router-link>
            <router-link :to="{ name: 'admin-view-barcode' }">
                <li>
                    <img src="/public/icon/barcode_icon.png" width="25px" alt="" />
                    <span>View</span>
                </li>
            </router-link>
            <hr>
            <router-link :to="{ name: 'admin-schedule-request' }">
                <li>
                    <i class="pi pi-calendar" />
                    <span>Schedule Request</span>
                </li>
            </router-link>
            <router-link :to="{ name: 'admin-inventory-list' }">
                <li>
                    <img src="/public/icon/list_icon.png" width="25px" alt="" />
                    <span>Item List</span>
                </li>
            </router-link>
            <router-link :to="{ name: 'admin-scheduling' }">
                <li>
                    <img src="/public/icon/schedulingIcon.svg" width="25px" alt="" />
                    <span>Scheduling</span>
                </li>
            </router-link>

            <a @click="stockManagement">
                <li>
                    <span>Stock Management</span>
                    <i class="pi pi-chevron-down"></i>
                </li>
            </a>

            <transition name="stock_animation">
                <div class="stock_class" v-if="isStockManagement">
                <router-link :to="{name: 'admin-track-low-stock'}">
                    <li>
                        <i class="pi pi-ellipsis-v"></i>
                        <span>Track Low Stock</span>
                    </li>
                </router-link>
                <router-link :to="{name: 'admin-set-stock'}">
                    <li>
                        <i class="pi pi-ellipsis-v"></i>
                        <span>Set Stock</span>
                    </li>
                </router-link>


            </div>
              
            </transition>

            <a @click="userActivityLogs">
                <li>
                    <span>User Activity Logs</span>
                    <i class="pi pi-chevron-down"></i>
                </li>
            </a>

            <transition name="user_activity_logs_animation">
           <div class="stock_class"  v-if="isUserActivityLogs">
            <router-link :to="{name: 'admin-stock-adjustment'}">
                <li>
                    <i class="pi pi-ellipsis-v"></i>
                    <span>Stock Adjustments</span>
                </li>
            </router-link>
               <router-link>
                <li>
                    <i class="pi pi-ellipsis-v"></i>
                    <span>Order Changes</span>
                </li>
               </router-link>
         

           </div>
            </transition>


            <router-link :to="{ name: 'admin-user-list' }">
                <li>
                    <img src="/public/icon/user_list_icon.png" width="25px" alt="" />
                    <span>User List</span>
                </li>
            </router-link>
        </ul>
    </aside>
</template>

<script setup>
import { ref } from "vue";
import Logout from '@/components/Logout_Modal.vue'
const logoutModal = ref(false)

const isHideSidebar = ref(false)
const isStockManagement = ref(false)
const isUserActivityLogs = ref(false)
const cancel = () => {
    logoutModal.value = false
}

function stockManagement() {
    if (isStockManagement.value === true) {
        isStockManagement.value = false
    } else {
        isStockManagement.value = true
    }
}

function userActivityLogs() {
    if (isUserActivityLogs.value === true) {
        isUserActivityLogs.value = false
    } else {
        isUserActivityLogs.value = true
    }
}


</script>
<style scoped>
aside {
    width: 13.5rem;
    position: fixed;
    max-height: 100%;
    overflow-y: scroll;
    overflow-x: hidden;
    background: rgb(255, 255, 255);
    transition: all linear 0.3s;
}

ul {
    list-style: none;
    display: grid;
    gap: px;
    padding: 0;
    padding-top: 10px;
}

a,.stock_class a {
    text-decoration: none;
    font-weight: 600;
    color: black;
    transition: all linear 0.2s;
}

a li,.stock_class a {
    display: flex;
    align-items: center;
    gap: 20px;
    height: 50px;
    padding: 10px;
    border-radius: 20px;
}

a:hover {
    background: rgb(231, 231, 231);
}
.stock_class a:hover{
    background: rgb(231, 231, 231);

}

.title {
    border: solid black;
    margin: 5px;
    border-width: 0px 0px 2px 0px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

span {
    color: rgb(129, 131, 133);
    font-weight: 500;
}

.stock_animation-enter-active,
.stock_animation-leave-active {
    transition: all 0.5s ease;
    overflow: hidden;
}

.stock_animation-enter-from,
.stock_animation-leave-to {
    opacity: 0;
    max-height: 0;
}

.stock_animation-enter-to,
.stock_animation-leave-from {
    opacity: 1;
    max-height: 100px;
}

.user_activity_logs_animation-enter-active,
.user_activity_logs_animation-leave-active {
    transition: all 0.5s ease;
    overflow: hidden;
}

.user_activity_logs_animation-enter-from,
.user_activity_logs_animation-leave-to {
    opacity: 0;
    max-height: 0;
}

.user_activity_logs_animation-enter-to,
.user_activity_logs_animation-leave-from {
    opacity: 1;
    max-height: 100px;
}
</style>
