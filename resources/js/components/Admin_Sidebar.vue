<template>
    <Logout v-if="logoutModal" @cancel="cancel" />
    <aside :class="{ hideSidebar: isHideSidebar }">
        <ul>
            <router-link :to="{ name: 'admin-dashboard' }">
                <li>
                    <img src="/public/icon/dashboard_icon.png" width="25px" alt="" 
                         />
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
const cancel = () => {
    logoutModal.value = false
}


</script>
<style scoped>
aside {
    width: 13.5rem;
    position: fixed;
    height: 100%;
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

a {
    text-decoration: none;
    font-weight: 600;
    color: black;
    transition: all linear 0.2s;
}

a li {
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

.router-link-active,
.router-link-exact-active {
    background: rgb(232, 248, 248);
    border-radius: 20px;
}


</style>
