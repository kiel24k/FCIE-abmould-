<script setup>
import { ref } from "vue";
import Logout from '@/components/Logout_Modal.vue'
const logoutModal = ref(false)

const emit = defineEmits(["showSidebar", 'hideSidebar']);
const props = defineProps(['isSidebar'])
const isStockManagement = ref(false)
const isUserActivityLogs = ref(false)
const isItemManagement = ref(false)
const isUserManagement = ref(false)


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


const menu = () => {
   emit('hideSidebar')
}

const showSidebar = () => {
 emit('showSidebar')
}

</script>

<template>
    <aside :class="{shortSidebar: isSidebar}">
        <ul>
            <div class="title text-center" v-if="isSidebar">
                <img src="/public/background/abMouldLogo.png" width="130px" height="45px" alt="">
                <img
                    src="/public/icon/menu.png"
                    width="30px"
                    height="30px"
                    alt=""
                    class="menu"
                    @click="menu()"
                />
            </div>
            <router-link :to="{ name: 'admin-dashboard' }">
                <li @click="showSidebar()">
                    <i class="pi pi-warehouse"></i>
                    <span>Dashboard</span>
                </li>
            </router-link>
            <hr>
     
            <h5 class="text-center" v-if="isSidebar">Barcode</h5>
            <router-link v-else>
                <li @click="showSidebar">
                    <i class="pi pi-angle-double-right"></i>
                </li>
            </router-link>
            <router-link :to="{ name: 'admin-in-barcode' }">
                <li> 
                    <i class="pi pi-barcode"></i>
                    <span>In</span>
                </li>
            </router-link>
            <router-link :to="{ name: 'admin-out-barcode' }">
                <li>
                    <i class="pi pi-barcode"></i>
                    <span>Out</span>
                </li>
            </router-link>
            <router-link :to="{ name: 'admin-view-barcode' }">
                <li>
                  <i class="pi pi-barcode"></i>
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
                    <i class="pi pi-clock"></i>
                    <span>Scheduling</span>
                </li>
            </router-link>
            <a @click="itemManagement" class="route_option_name">
                <li>
                    <i class="pi pi-ellipsis-h"></i>
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
                    <i class="pi pi-ellipsis-h"></i>
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
                    <i class="pi pi-ellipsis-h"></i>
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
                    <i class="pi pi-ellipsis-h"></i>
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


<style scoped>
aside {
    width: 3.5rem;
    position: fixed;
    height: 100%;
    overflow: scroll;
    overflow-x: hidden;
    z-index: 9999;
    background: rgb(204, 202, 202);
    box-shadow: 0px 0px 15px 0px gray;
    top:0;
    transition: all linear 0.9s;
}
.shortSidebar{
    width: 15rem;
    background: rgb(255, 255, 255);
    
}
aside::-webkit-scrollbar {
    width: 5px;
}

aside::-webkit-scrollbar-track {
    border-radius: 8px;
    background-color: #cfe8f7;
    border: 1px solid #ffffff;
}

aside::-webkit-scrollbar-thumb {
    border-radius: 8px;
    background-color: #888a8b;
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
    background: rgb(192, 225, 245);
    border-radius: 20%;
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
