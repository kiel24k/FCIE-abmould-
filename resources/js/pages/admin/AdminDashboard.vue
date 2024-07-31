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
import Header from '@/components/Header.vue'




</script>
