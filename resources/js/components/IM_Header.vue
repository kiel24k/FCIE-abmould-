<template>

  <header>
  <Sidebar v-if="showSidebar" @hideSidebar="hideSidebar" :class="{ hideSidebarActive: hideSidebarIsActive }" />
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
            <SplitButton :label="userInformation.first_name" severity="secondary" dropdownIcon="pi pi-chevron-down"
              @click="save" :model="items" />
          </div>
        </ul>
      </div>
    </div>
    <Loader v-if="loader" />
  </header>
</template>

<script setup>
import { onClickOutside } from '@vueuse/core';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import { useRouter } from "vue-router";
import Sidebar from '@/components/IM_Sidebar.vue'
import Loader from '@/components/Loading.vue'
import { SplitButton } from 'primevue';
import Swal from 'sweetalert2';


const items = [
  {
    label: 'Profile',
    icon: 'pi pi-user',
    command: () => {

    }
  },
  {
    label: 'Logout',
    icon: 'pi pi-sign-out',
    command: () => {
      logout()
    }
  },

];

const logout = () => {


  Swal.fire({
    title: "Are you sure?",
    text: "Do you want to logout?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "red",
    cancelButtonColor: "skyblue",
    confirmButtonText: "Logout"
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.removeItem("responseTKN")
      localStorage.removeItem("inventoryManagerPermission")
      router.push("/")
      Swal.fire({
        title: "Logout Success!",
        text: "Thank You.",
        icon: "success"
      });
    }
  });
}


//modal

const target = ref(null)

onClickOutside(target, event => showModal.value = false)

const showModal = ref(false)


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

</script>

<style scoped>
.hideSidebarActive {
  transform: translate(-100%);
}

header {
  position: fixed;
  top: 0;
  z-index:999;
  width: 100%;
  background-color: #f8f7f7;
  box-shadow: 1px 1px 10px 0px gray;
}

.nav-link {
  color: rgb(170, 170, 170);
  font-weight: 600;
}

.profile {
  border: solid 2px rgb(8, 8, 8);
  border-radius: 100%;
  padding: 4px;

}
.p-popover{
 z-index:999;
 position:absolute;
}
</style>
