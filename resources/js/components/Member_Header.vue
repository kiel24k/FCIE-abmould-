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
        <ul class="navbar nav justify-content-end" style="margin-right:50px;">
          <li class="nav-item">
            <div class="card flex justify-center">
              <SplitButton :label="userInformation.first_name" icon="pi pi-user" dropdownIcon="pi pi-chevron-down"
                @click="save" :model="items" severity="secondary" />
            </div>
          </li>
        </ul>
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
import Sidebar from '@/components/Member_Sidebar.vue'
import Loader from '@/components/Loading.vue'
import { SplitButton } from 'primevue';
import Swal from 'sweetalert2';
const emit = defineEmits(['user'])
const items = [
  // {
  //   label: 'Profile',
  //   icon: 'pi pi-user',
  //   command: () => {

  //   }
  // },
  {
    label: 'Logout',
    icon: 'pi pi-sign-out',
    command: () => {
      logout()
    }
  }
];



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
        localStorage.removeItem("responseTKN")
        localStorage.removeItem("memberPermission")
        router.push("/")
        Swal.fire({
          title: "Logout Successful!",
          text: "Thank You!.",
          icon: "success"
        });
        localStorage.removeItem("responseTKN")
        localStorage.removeItem("TLpermission")
        router.push("/")
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
    emit('user', userInformation.value)
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
  position: sticky;
  top:0;
  background-color: #f8f7f7;
  box-shadow: 1px 1px 10px 0px gray;
  width: 100%;
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
</style>
