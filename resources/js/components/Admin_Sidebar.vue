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
            <router-link :to="{ name: 'admin-scheduling' }">
                <li>
                    <img src="/public/icon/schedulingIcon.svg" width="25px" alt="" />
                    <span>Scheduling</span>
                </li>
            </router-link>
            <a @click="itemManagement" class="route_option_name">
                <li>
                    <span>Items</span>
                    <i class="pi pi-chevron-down"></i>
                </li>
            </a>
            <transition name="item_animation">
                <div class="stock_class" v-if="isItemManagement">
                    <router-link :to="{ name: 'admin-inventory-list' }">
                        <li>
                            <i class="pi pi-list"></i>
                            <span>Item List</span>
                        </li>
                    </router-link>
                    <router-link :to="{ name: 'admin-new-item' }">
                        <li>
                            <i class="pi pi-plus"></i>
                            <span>New Item</span>
                        </li>
                    </router-link>
                    <router-link :to="{ name: 'admin-category-list' }">
                        <li>
                            <i class="pi pi-list"></i>
                            <span>Category List</span>
                        </li>
                    </router-link>
                    <router-link :to="{ name: 'admin-new-category' }">
                        <li>
                            <i class="pi pi-plus"></i>
                            <span>New Category</span>
                        </li>
                    </router-link>
                </div>
            </transition>

            <a @click="stockManagement" class="route_option_name">
                <li>
                    <span>Stock Management</span>
                    <i class="pi pi-chevron-down"></i>
                </li>
            </a>

            <transition name="stock_animation">
                <div class="stock_class" v-if="isStockManagement">
                    <router-link :to="{ name: 'admin-track-low-stock' }">
                        <li>
                            <i class="pi pi-ellipsis-v"></i>
                            <span>Set Treshold</span>
                        </li>
                    </router-link>
                    <router-link :to="{ name: 'admin-set-stock' }">
                        <li>
                            <i class="pi pi-ellipsis-v"></i>
                            <span>Set Stock</span>
                        </li>
                    </router-link>


                </div>

            </transition>

            <a @click="userActivityLogs" class="route_option_name">
                <li>
                    <span>Activity Logs</span>
                    <i class="pi pi-chevron-down"></i>
                </li>
            </a>

            <transition name="user_activity_logs_animation">
                <div class="stock_class" v-if="isUserActivityLogs">
                    <router-link :to="{ name: 'admin-stock-adjustment' }">
                        <li>
                            <i class="pi pi-ellipsis-v"></i>
                            <span>Stock Adjustments</span>
                        </li>
                    </router-link>
                    <router-link :to="{name: 'admin-item-logs'}">
                        <li>
                            <i class="pi pi-ellipsis-v"></i>
                            <span>Item Changes</span>
                        </li>
                    </router-link>


                </div>
            </transition>
            <a @click="userManagement()" class="route_option_name">
                <li>
                    <span>User Management</span>
                    <i class="pi pi-chevron-down"></i>
                </li>
            </a>

            <transition name="user_management_animation">
                <div class="stock_class" v-if="isUserManagement">
                    <router-link :to="{ name: 'admin-user-list' }">
                        <li>
                            <i class="pi pi-users"></i>
                            <span>All Users</span>
                    </li>
                    </router-link>
                    <router-link :to="{name: 'create-user'}">
                        <li>
                            <i class="pi pi-plus"></i>
                            <span>Add New User</span>
                        </li>
                    </router-link>
                    <router-link :to="{name: 'admin-assign-role'}">
                        <li>
                            <i class="pi pi-pencil"></i>
                            <span>Assign Roles</span>
                        </li>
                    </router-link>
                </div>
            </transition>


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
const isItemManagement = ref(false)
const isUserManagement = ref(false)
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

function itemManagement() {
    if (isItemManagement.value === true) {
        isItemManagement.value = false
    } else {
        isItemManagement.value = true
    }
}

function userManagement() {
    if (isUserManagement.value === true) {
        isUserManagement.value = false
    } else {
        isUserManagement.value = true
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

a,
.stock_class a {
    text-decoration: none;
    font-weight: 600;
    color: black;
    transition: all linear 0.2s;

}


a li,
.stock_class a {
    display: flex;
    align-items: center;
    gap: 20px;
    height: 50px;
    padding: 10px;
  
}

.route_option_name li {
    display: flex;
    justify-content: space-between;
}

a:hover {
    background: rgb(231, 231, 231);
}

.stock_class a:hover {
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



.item_animation-enter-active,
.item_animation-leave-active {
    transition: all 0.5s ease;
    overflow: hidden;
}

.item_animation-enter-from,
.item_animation-leave-to {
    opacity: 0;
    max-height: 0;
}

.item_animation-enter-to,
.item_animation-leave-from {
    opacity: 1;
    max-height: 200px;
}



.user_management_animation-enter-active,
.user_management_animation-leave-active {
    transition: all 0.5s ease;
    overflow: hidden;
}

.user_management_animation-enter-from,
.user_management_animation-leave-to {
    opacity: 0;
    max-height: 0;
}

.user_management_animation-enter-to,
.user_management_animation-leave-from {
    opacity: 1;
    max-height: 200px;
}
</style>
