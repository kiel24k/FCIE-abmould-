<template>
    <div id="viewport">
        <!-- Sidebar -->
        <div id="sidebar">
          <header>
            <img src="/public/icon/back1.png" width="50px" alt="" @click="closeBtn" style="cursor:pointer">
          </header>
          <ul class="nav">
          <li class="nav-item text-center title">
            <b>Inventory</b>
          </li>
          <router-link :to="{name: 'admin-inventory-list'}" class="nav-link text-dark">
           <li class="nav-item p-2">
            <div class="item">
                <img
                    src="/public/icon/inventoryIcon.svg"
                    width="25px"
                    alt=""
                />
                <b>Item List</b>
            </div>
           </li>
        </router-link>
        <router-link :to="{name: 'admin-new-item'}" class="nav-link text-dark">
            <li class="nav-item p-2">
                <div class="item">
                    <img
                        src="/public/icon/inventoryIcon.svg"
                        width="25px"
                        alt=""
                    />
                    <b>New Item</b>
                </div>
            </li>
        </router-link>
        <router-link :to="{name: 'admin-scheduling'}" class="nav-link text-dark">
            <li class="nav-item p-2">
                <div class="item">
                    <img
                        src="/public/icon/schedulingIcon.svg"
                        width="25px"
                        alt=""
                    />
                    <b>Scheduling</b>
                </div>
            </li>
        </router-link>
          <li class="nav-item text-center title">
            <b>Accounts</b>
          </li>
          <li class="nav-item p-2">
            <router-link :to="{ name: 'create-user' }" class="nav-link text-dark">
               <div class="item">
                   <img
                       src="/public/icon/inventoryIcon.svg"
                       width="25px"
                       alt=""
                   />
                   <b>New User</b>
               </div>
           </router-link>
                      </li>
                      <li class="nav-item p-2">
                       <router-link :to="{name: 'admin-user-list'}" class="nav-link text-dark">
                           <div class="item">
                               <img
                                   src="/public/icon/inventoryIcon.svg"
                                   width="25px"
                                   alt=""
                               />
                               <b>User List</b>
                           </div>
                       </router-link>
                      </li>
 <li class="nav-item" @click="logout">
    <a href="" class="nav-link text-danger"
        ><b>Logout</b>
        </a
    >
</li>
          </ul>
        </div>
      </div>
</template>

<script setup>
import { ref } from 'vue';

const emitData = defineEmits(['closeSidebar'])
const closeBtn = () => {
    emitData('closeSidebar')
}
</script>
<style scoped>

  /* Sidebar Styles */


  #sidebar {
    z-index: 1000;
    position: fixed;
    top:0;
    left: 250px;
    width: 300px;
    height: 100%;
    margin-left: -250px;
    overflow-y: auto;
    background: #fdfdfd;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
  }

  #sidebar header {
    background-color: #3c4c53;
    font-size: 20px;
    line-height: 52px;
    text-align: center;
  }

  #sidebar header a {
    color: #fff;
    display: block;
    text-decoration: none;
  }
  #sidebar li{
    width: 100%;
  }
  #sidebar .title{
    background: rgb(214, 213, 213);
  }

  #sidebar .router-link-active,.router-link-exact-active{
    background: rgb(185, 186, 187);
}
#sidebar .nav-link{
    width: 100%;
}

header{
    display: flex;
    justify-content: end;
}
</style>
