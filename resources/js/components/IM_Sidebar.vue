<template>
   
    <aside>
        <Logout v-if="logoutModal" @cancel="cancel"/>
        <ul>
            <div class="title text-center">
                <img src="/public/background/abMouldLogo.png" width="130px" height="45px" alt="">
                <img
                    src="/public/icon/menu.png"
                    width="30px"
                    height="30px"
                    alt=""
                    class="menu"
                    @click="menu"
                />
            </div>
            <router-link :to="{ name: 'inventory-manager-dashboard' }">
                <li>
                    <img
                        src="/public/icon/dashboard_icon.png"
                        width="25px"
                        alt=""
                    />
                    <span>Dashboard</span>
                </li>
            </router-link>
            <hr>
            <h5 class="text-center">Barcode</h5>
                <router-link :to="{ name: 'inventory-manager-in-barcode' }">
                    <li>
                        <img
                            src="/public/icon/barcode_icon.png"
                            width="25px"
                            alt=""
                        />
                        <span>In</span>
                    </li>
                </router-link>
                <router-link :to="{ name: 'inventory-manager-out-barcode' }">
                    <li>
                        <img
                            src="/public/icon/barcode_icon.png"
                            width="25px"
                            alt=""
                        />
                        <span>Out</span>
                    </li>
                </router-link>
                <router-link :to="{ name: 'inventory-manager-view-barcode' }">
                    <li>
                        <img
                            src="/public/icon/barcode_icon.png"
                            width="25px"
                            alt=""
                        />
                        <span>View</span>
                    </li>
                </router-link>
                <hr>
                <router-link :to="{ name: 'inventory-manager-schedule-request' }">
                    <li>
                       <i class="pi pi-calendar"/>
                        <span>Schedule request</span>
                    </li>
                </router-link>
            <router-link :to="{ name: 'inventory-manager-item-list' }">
                <li>
                    <img
                        src="/public/icon/list_icon.png"
                        width="25px"
                        alt=""
                    />
                    <span>Item List</span>
                </li>
            </router-link>
            
            <router-link :to="{ name: 'inventory-manager-scheduling' }">
                <li>
                    <img
                        src="/public/icon/schedulingIcon.svg"
                        width="25px"
                        alt=""
                    />
                    <span>Scheduling</span>
                </li>
            </router-link>
        </ul>
    </aside>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from "vue-router";
import Logout from '@/components/IM_Logout_Modal.vue'

const router = useRouter()
const logoutModal = ref(false)
const emit = defineEmits(["hideSidebar"]);

const menu = () => {
    emit("hideSidebar");
};

const cancel = () => {
    logoutModal.value = false
}

</script>
<style scoped>
aside {
    width: 15rem;
    position: fixed;
    height: 100%;
    overflow: scroll;
    overflow-x: hidden;
    z-index: 998;
    background: rgb(255, 255, 255);
    box-shadow: 0px 0px 15px 0px gray;
    transition: all linear 0.3s;
}
ul {
    list-style: none;
    display: grid;
    gap: px;
    padding: 0;
}

a {
    text-decoration: none;
    font-weight: 600;
    color: black;
    transition: all linear 2s;
}
a li {
    display: flex;
    align-items: center;
    gap: 20px;
    height: 50px;
    padding: 10px;
    border-radius: 20px;
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

.router-link-active, .router-link-exact-active{
    background: rgb(232, 248, 248);
    border-radius: 20px;
}
</style>
