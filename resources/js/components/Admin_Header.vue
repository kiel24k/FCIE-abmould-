<template>
    <div style="height: 4rem;">
        <header>
            <div class="row">
                <div class="col" style="max-width: 250px;">
                    <ul class="navbar nav d-flex justify-content-center">
                        <li class="nav-item">
                            <img src="/public/background/abMouldLogo.png" width="150px" @click="$emit('toggle-sidebar')" style="cursor:pointer">
                        </li>
                    </ul>
                </div>
                <div class="col">
                    <ul class="navbar nav justify-content-end" style="margin-right:20px;">
                        <li class="nav-item">
                            <a href="" class="nav-link">
                                {{ userInformation.first_name }}
                            </a>
                        </li>
                        <li class="nav-item profile">
                            <img :src="`/UserImage/${userInformation.image}`" width="20px" height="20px" alt=""
                                @click="profileModal" />
                        </li>
                    </ul>
                </div>

                <div class="profile-modal" v-if="showModal" ref="target">
                    <section>
                        <router-link class="btn btn-success" :to="{ name: 'admin-profile' }">Profile</router-link>
                        <button class="btn btn-danger" @click="logout">Logout</button>
                    </section>
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

// Modal logic
const showModal = ref(false);
const profileModal = () => {
    showModal.value = true;
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
    });
    if (!token) {
        router.push('/');
    }
});

const logout = () => {
    localStorage.removeItem("responseTKN");
    localStorage.removeItem("administrationPermission");
    router.push("/");
};
</script>
<style scoped>
header {
    background-color: #fff;
    box-shadow: 1px 1px 10px 0px gray;
    top: 0;
    width: 100%;
    ;
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
