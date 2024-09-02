<template>

  <Sidebar v-if="showSidebar" @hideSidebar="hideSidebar" :class="{ hideSidebarActive: hideSidebarIsActive }" />
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
          <button class="btn btn-success">Profile</button>
          <button class="btn btn-danger" @click="logout">Logout</button>
        </section>
      </div>

    </div>
    <Loader v-if="loader" />


  </header>

  <!-- <div class="row header">
      <div class="col-1 menu" @click="menu">
       <img src="/public/icon/menu.png" width="40px" alt="">
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
        </div> -->
</template>

<script setup>
import { onClickOutside } from '@vueuse/core';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";
import Sidebar from '@/components/Admin_Sidebar.vue'
import Loader from '@/components/Loading.vue'

//modal
const target = ref(null)
onClickOutside(target, event => showModal.value = false)

const showModal = ref(false)
const profileModal = () => {
  showModal.value = true
}

const router = useRouter()
const userInformation = ref({})

const loader = ref(true)
onMounted(() => {
  loader.value = true
  const token = localStorage.getItem('responseTKN')
  axios.defaults.headers.common['Authorization'] = `Bearer ${token}`
  axios.get('api/user').then(response => {
    userInformation.value = response.data
    loader.value = false
  })
  if (!token) {
    router.push('/')
  }
})


const showSidebar = ref(true)
const menu = () => {
  hideSidebarIsActive.value = false
}

const hideSidebarIsActive = ref(false)
const hideSidebar = () => {
  hideSidebarIsActive.value = true
}

const logout = () => {
   localStorage.removeItem("responseTKN")
   localStorage.removeItem("administrationPermission")
   router.push("/")
}

</script>

<style scoped>
.hideSidebarActive {
  transform: translate(-100%);
}

header {
  background-color: #f8f7f7;
  box-shadow: 1px 1px 10px 0px gray;
}

.nav-link {
  color: rgb(170, 170, 170);
  font-weight: 600;
}

.profile-modal{
  position: absolute;
  width: 12rem;
  background: rgb(223, 220, 220);
  top:4rem;
  right:0;
  display: grid;
  justify-content: center;
  box-shadow: 0px 0px 5px 0px gray;
  padding:10px;
}
.profile-modal section {
  display: grid;
  gap:10px;
}


</style>
