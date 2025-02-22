<template>
    <div style="height: 4rem;">
        <header>
            <div class="row">
                <div class="col" style="max-width: 250px;">
                    <ul class="navbar nav d-flex justify-content-center">
                        <li>
                            <i class="pi pi-bars" style="font-size: 35px;" @click="sidebarBtn"></i>
                        </li>
                        <router-link :to="{ name: 'admin-dashboard' }">
                            <li class="nav-item">
                                <img src="/public/background/abMouldLogo.png" width="150px" style="cursor:pointer">
                            </li>
                        </router-link>
                    </ul>
                </div>
                <div class="col">
                    <ul class="navbar nav justify-content-end" style="margin-right:20px;">
                        <Button icon="pi pi-exclamation-triangle" severity="danger" raised rounded class="m-2" v-if="isStockAlertBtn"
                            @click="showStockAlert" />
                            <li class="nav-item">
                                    <Button type="button" icon="pi pi-bell" severity="secondary" @click="toggle" class="min-w-48" />
                            
                                    <Popover ref="op">
                                        <div class="pop flex flex-col gap-4">
                                            <div>
                                                <span class="font-medium block mb-2">Notification</span>
                                                <ul class="list-none p-0 m-0 flex flex-col">
                                                    <div v-for="notif in notifs" :key="notif.name" class="flex items-center gap-2 px-2 py-3 hover:bg-emphasis cursor-pointer rounded-border" @click="selectMember(member)">
                                                       <b></b>
                                                        <div>
                                                            <b class="font-medium">{{ notif.message }}</b>
                                                            <div class="text-sm text-surface-500 dark:text-surface-400">{{ notif.email }}</div>
                                                            <div><small>{{ notif.role }}</small></div>
                                                        </div>
                                                    </div>
                                                </ul>
                                            </div>
                                        </div>
                                    </Popover>
                            </li>
                        <li class="nav-item profile">
                            <div class="card flex justify-center">
                                <SplitButton :label="userInformation.first_name" severity="secondary" text @click="save"
                                    :model="items" />
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <Transition name="sidebar-transition">
                <Sidebar v-if="isSidebar" :class="{ hideSidebarActive: isSidebarActive }" />
            </Transition>
            <Loader v-if="loader" />
        </header>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';

import axios from 'axios';
import { useRouter } from "vue-router";
import Loader from '@/components/Loading.vue';
import { Button, Popover, SplitButton } from 'primevue';
import Swal from 'sweetalert2';
import Sidebar from '@/components/Admin_Sidebar.vue'

// Modal logic
const emit = defineEmits(['user'])
const isSidebar = ref(true)
const isSidebarActive = ref(true)
const isStockAlertBtn = ref(false)


const items = [
    {
        label: 'Profile',
        icon: 'pi pi-user',
        command: () => {
            router.push('/admin-profile')
        }
    },
    {
        separator: true
    },
    {
        label: 'Logout',
        icon: 'pi pi-sign-out',
        command: () => {
            logout()
        }
    }
];



const router = useRouter();
const userInformation = ref({});
const loader = ref(true);
onMounted(() => {
    loader.value = true;
    const token = localStorage.getItem('responseTKN');
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    axios.get('api/user').then(response => {
        userInformation.value = response.data;
        loader.value = false;
        emit('user', userInformation.value)
    });
    if (!token) {
        router.push('/');
    }
});

setTimeout(() => {
    LOW_STOCK_ALERT_API()
}, 2000)

const LOW_STOCK_ALERT_API = async () => {
    const response = await axios.get('api/low-stock-alert')
    if (response.data.status !== 200) {
        isStockAlertBtn.value = true
       
    }
}

const logout = () => {
    Swal.fire({
        title: "Do you want to logout?",
        text: "Don't worry you can login again! ",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: 'No',
        confirmButtonText: "Yes"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Logout Successful!",
                text: "Thank You!.",
                icon: "success"
            });
            localStorage.removeItem("responseTKN");
            localStorage.removeItem("administrationPermission");
            router.push("/");
        }
    });

};

const showStockAlert = () => {
    Swal.fire({
            title: "Low Stock Alert",
            text: "Kindly Check All Items",
            icon: "warning"
        }); 
}

const sidebarBtn = () => {
    if (isSidebar.value === true) {
        isSidebar.value = false
        isSidebarActive.value = false
    } else if (isSidebar.value === false) {
        isSidebar.value = true
        isSidebarActive.value = true
    }

}
//NOTIFICATION SECTION HERE!

const op = ref();
const selectedMember = ref(null);
const notifs = ref([
    { name: 'John Doe Member', message: 'Update the item', email: 'JohnDoe@email.com', role: 'Admin' },
    { name: 'Linus haven', message: 'Add new Item', email: 'Linus0404@email.com', role: 'Member' },
    { name: 'Ioni Bowcher', message: 'Delete the Item', email: 'ioni@email.com', role: 'TL' },
    { name: 'Linus haven', message: 'Add new Item', email: 'Linus0404@email.com', role: 'Member' },
    { name: 'Linus haven', message: 'Add new Item', email: 'Linus0404@email.com', role: 'Member' },
    { name: 'Linus haven', message: 'Add new Item', email: 'Linus0404@email.com', role: 'Member' },
    { name: 'Linus haven', message: 'Add new Item', email: 'Linus0404@email.com', role: 'Member' },
    { name: 'Linus haven', message: 'Add new Item', email: 'Linus0404@email.com', role: 'Member' },
    { name: 'Linus haven', message: 'Add new Item', email: 'Linus0404@email.com', role: 'Member' },
]);

const toggle = (event) => {
    op.value.toggle(event);
}

const selectMember = (member) => {
    selectedMember.value = member;
    op.value.hide();
}
</script>
<style scoped>
header {
    background-color: #fff;
    box-shadow: 1px 1px 10px 0px gray;
    top: 0;
    width: 100%;
    z-index: 999;
    position: fixed;
}

.nav-link {
    color: rgb(170, 170, 170);
    font-weight: 600;
}

.profile-modal {
    position: absolute;
    width: 12rem;
    background: rgb(223, 220, 220);
    top: 4rem;
    right: 0;
    display: grid;
    justify-content: center;
    box-shadow: 0px 0px 5px 0px gray;
    padding: 10px;
}

.profile-modal section {
    display: grid;
    gap: 10px;
}

.hideSidebarActive {
    transform: translate(-100%);
}
.pop{
    max-height: 20rem;
    overflow-y: scroll;
}
</style>
