<template>
    <Logout v-if="logoutModal" @cancel="cancel"/>
    <aside>
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
            <a @click="logout" style="cursor:pointer">
                <li>
                    <img src="/public/icon//logout_leave.png" width="25px" alt="">
                    <span>Logout</span>
                </li>
            </a>

        </ul>
    </aside>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import Logout from '@/components/Logout_Modal.vue'

const router = useRouter()
const logoutModal = ref(false)

const logout = () => {
    logoutModal.value = true
}
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
    box-shadow: 0px 15px 15px 0px gray;
   
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
a:hover{
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
