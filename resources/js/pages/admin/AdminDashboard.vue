<template>

    <div class="row">
        <div class="col-1">
            <Sidebar/>
        </div>
        <div class="col">
            <Header :userInformation="userInformation"/>
        </div>
    </div>


</template>
<script setup>

import Sidebar from '@/components/AdminSidebar.vue'
import Header from '@/components/AdminHeader.vue'
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";

const router = useRouter()
const userInformation = ref({})

onMounted(() => {
    const token = localStorage.getItem('responseTKN')
    axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
    axios.get('api/user').then(response => {
       userInformation.value = response.data
    })
    if(!token){
        router.push('/')
    }
})


</script>
