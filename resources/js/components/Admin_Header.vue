<template>
    <div class="row header">
      <div class="col-1 menu" @click="menu">
       <img src="/public/icon/menu.png" alt="">
      </div>
      <div class="col">
        <a>
            <figure class="text-end">
                {{ userInformation.first_name }}
                <img @click="profileModal" src="/public/icon/user-profile.svg" height="60px" alt="" style="margin-right:10px;">
               </figure>
           </a>
           <div class="profile-modal" v-if="showModal" ref="target">
               <div class="view-profile text-center">
                   <b>Profile</b>
               </div>
               <div class="view-profile text-center">
                   <b>Logout</b>
               </div>
           </div>
      </div>
        </div>
        <transition name="sidebarTransition">
            <Sidebar v-if="sidebar" class="sidebar1" @closeSidebar="sidebar = false"/>
        </transition>
</template>

<script setup>
import { onClickOutside } from '@vueuse/core';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";
import Sidebar from '@/components/AdminSidebar.vue'
//modal
const target = ref(null)
onClickOutside(target, event => showModal.value = false)

const showModal = ref(false)
const profileModal = () => {
    showModal.value = true
}

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


const sidebar = ref(true)
const menu = () => {
   sidebar.value = true
}







</script>

<style scoped>
.header{
    background: white;
}

img{
    cursor: pointer;
}
.profile-modal{
    max-width: 15rem;
    margin-right:10px;
    border-radius: 10px;
    height:10rem;
    display: grid;
    position:absolute;
    right:0;
    top:5rem;

}
.profile-modal > div{
    width: 100%;
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
    background: rgb(241, 237, 237);
    border:solid 1px black;
    cursor: pointer;
    transition: all linear 0.1s;
}
.profile-modal > div:hover{
    background: rgb(216, 214, 214);

}

.sidebarTransition-enter-from,
.sidebarTransition-leave-to{
    transform: translateY(-100%);
    opacity: 0;
}

</style>
