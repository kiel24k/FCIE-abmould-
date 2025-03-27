<script setup>
import Header from '@/components/Admin_Header.vue'
import axios from 'axios';
import { Button, Message, Select } from 'primevue';
import { onMounted, ref } from 'vue';

//API VARIABLES
const itemLogsData = ref({})
//API FUNCTIONS
const GET_ITEM_LOGS_API = async () => {
    await axios({
        method:"GET",
        url:'api/get-item-logs'
    }).then(response => {
        itemLogsData.value = response.data
    })
}

//HOOKS
onMounted(() => {
    GET_ITEM_LOGS_API() 
})
</script>
<template>
<header>
    <Header/>
</header>
<section>
      
    <div class="container bg-white">
        <Message severity="contrast" icon="pi pi-ellipsis-v" size="large">Item Logs</Message>
        <div class="row p-2">
            <div class="col">
                <div class="category">
                    <Select placeholder="Filter" />
                </div>
            </div>
        </div>
     
        <div class="row" v-for="(data, index) in itemLogsData" :key="index" >
            <div class="col notif">
                <div class="info">
                    <div class="notif-info">
                        <div class="date_and_time d-grid ">
                            <span>{{ data.date_created }}</span>
                            <b>{{ data.time }}</b>
                        </div>
                        <div class="user-info">
                            <Button icon="pi pi-check" severity="success" rounded raised class="m-3" v-if="data.action === 'created' " />
                            <Button icon="pi pi-pencil" severity="info" rounded raised class="m-3" v-if="data.action === 'update'" />
                            <Button icon="pi pi-trash" severity="danger" rounded raised class="m-3" v-if="data.action === 'deleted'" />
                        </div>
                        <div class="message">
                            <b>{{ data.action === "created" ? "Managing Item" : data.action === "update" ? "Changing Item" : data.action === "deleted" ? "Deleting Item " : "" }}</b>
                            <p>The User named <b>"{{ data.first_name }}"</b> Successfull <b class="text-primary">{{ data.action === "update" ? "Update the item" : data.action === "created" ? "Create the item" : data.action === "deleted" ? "Delete the item" : "Changing Item"}}</b> From Inventory</p>
                        </div>
                    </div>
                    <div class="notif_info_option">
                        <i class="pi pi-user m-1"></i>
                        <small class="text-warning">Track User</small> |
                        <Button label="remove" icon="pi pi-trash" severity="secondary" @click="removeLogs(data.id)" />
                    </div>
                </div>

                <div />
            </div>
        </div>
    </div>
</section>
</template>
<style scoped>
section {
    margin-top: 10px;
   
}
.container{
    box-shadow: 2px 10px 15px 2px gray;
}

.notif-info {
    display: flex;
    align-items: center;

}

.info {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    border: 1px rgb(177, 207, 8) solid;
    border-width: 0px 0px 1px 0px;
    background: rgb(247, 245, 245);
    border-radius: 15px;
    padding: 10px;
}
</style>