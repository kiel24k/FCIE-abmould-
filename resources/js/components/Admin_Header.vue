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
const isSidebar = ref(false)


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
    axios.get('/api/user').then(response => {
        userInformation.value = response.data;
        loader.value = false;
        emit('user', userInformation.value)


    });
    if (!token) {
        router.push('/');
    }
});

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




//NOTIFICATION SECTION HERE!


const notifs = ref({})

const NOTIFICATION_TABLE_API = async () => {
    axios({
        method: 'GET',
        url: '/api/notification-table'
    }).then(response => {
        notifs.value = response.data

    })
}
const menu = () => {
    // isSidebar.value = true
    alert("dsds")
}

const showSidebar = () => {
    isSidebar.value = true
}

const hideSidebar = () => {
    isSidebar.value = false
}


onMounted(() => {
    NOTIFICATION_TABLE_API();
})
</script>

<template>
 
    <Sidebar :isSidebar="isSidebar" @showSidebar="showSidebar" @hideSidebar="hideSidebar"  />
  
    <header>
        <div class="row">
            <div class="col-2">
                <ul class="navbar nav">
                    <li class="nav-item">
                        <img src="/public/icon/menu.png" width="40px" alt="" @click="menu" style="cursor:pointer">
                        <img src="/public/background/abMouldLogo.png" width="120px" alt="">
                    </li>
                </ul>
            </div>
            <div class="col">
                <ul class="navbar nav justify-content-end" style="margin-right:50px;">
                    <div class="card flex justify-center">
                        <SplitButton :label="userInformation.first_name" severity="secondary"
                            dropdownIcon="pi pi-chevron-down" @click="save" :model="items" />
                    </div>
                </ul>
            </div>
        </div>
        <Loader v-if="loader" />
    </header>

</template>

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

.pop {
    max-height: 20rem;
    overflow-y: scroll;
}


</style>
