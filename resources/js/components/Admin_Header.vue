<template>
    <div style="height: 4rem;">
        <header>
            <div class="row">
                <div class="col" style="max-width: 250px;">
                    <ul class="navbar nav d-flex justify-content-center">
                       <router-link :to="{name: 'admin-dashboard'}">
                        <li class="nav-item">
                            <img src="/public/background/abMouldLogo.png" width="150px" @click="$emit('toggle-sidebar')"
                                style="cursor:pointer">
                        </li>
                       </router-link>
                    </ul>
                </div>
                <div class="col">
                    <ul class="navbar nav justify-content-end" style="margin-right:20px;">
                        <li class="nav-item">
                            <span>
                                {{ userInformation.first_name }} {{ userInformation.last_name }}  
                            </span>
                        </li>
                        <li class="nav-item profile">
                            <div class="card flex justify-center">
                                <SplitButton icon="pi pi-user" severity="contrast" raised @click="save"
                                    :model="items" />
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <Loader v-if="loader" />
        </header>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue';

import axios from 'axios';
import { useRouter } from "vue-router";
import Loader from '@/components/Loading.vue';
import { SplitButton } from 'primevue';
import { useToast } from "primevue/usetoast";
import Swal from 'sweetalert2';

// Modal logic

const emit = defineEmits(['user'])
const toast = useToast();

const items = [
    {
        label: 'Profile',
        command: () => {
            router.push('/admin-profile')
        }
    },
    {
        separator: true
    },
    {
        label: 'Quit',
        command: () => {
            logout()
        }
    }
];

const save = () => {
    toast.add({ severity: 'success', summary: 'Success', detail: 'Data Saved', life: 3000 });
};

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
                text: "Your data has been saved!.",
                icon: "success"
            });
            localStorage.removeItem("responseTKN");
            localStorage.removeItem("administrationPermission");
            router.push("/");
        }
    });

};
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
</style>
