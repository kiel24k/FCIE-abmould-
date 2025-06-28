<script setup>
import Header from '@/components/Admin_Header.vue'
import axios from 'axios';
import { Button, Message, Select } from 'primevue';
import { onMounted, ref } from 'vue';
import AdminViewUserProfileModal from "@/components/Admin_View_User_Logs_Modal.vue"
import Swal from 'sweetalert2';


const isAdminViewUserProfileModal = ref(false)
const userId = ref(null)
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

//COMPONENTS

const removeLogs =  (data) => {    
    Swal.fire({
  title: "Are you sure?",
  text: "You won't be able to revert this!",
  icon: "warning",
  showCancelButton: true,
  confirmButtonColor: "#3085d6",
  cancelButtonColor: "#d33",
  confirmButtonText: "Yes, remove it!"
}).then((result) => {
    
  if (result.isConfirmed) {
   axios({
        method: "DELETE",
        url: "api/remove-item-logs",
        params: {
            id: data
        }
    }).then(response => {
        GET_ITEM_LOGS_API() 
        
    })
    Swal.fire({
      title: "Removed!",
      text: "Remove successfully.",
      icon: "success"
    });
  }
});


}

const viewUser = (id) => {
    isAdminViewUserProfileModal.value = true
    userId.value = id

}

const closeProfileModal = () => {
    isAdminViewUserProfileModal.value = false
}


//HOOKS
onMounted(() => {
    GET_ITEM_LOGS_API() 
})
</script>
<template>
<header>
    <AdminViewUserProfileModal v-if="isAdminViewUserProfileModal" @closeProfileModal="closeProfileModal" :userId="userId"/>
    <Header/>
</header>
<section>
      
    <div class="container bg-white">
        <Message severity="contrast" icon="pi pi-ellipsis-v" size="large">Item Logs</Message>
        <!-- <div class="row p-2">
            <div class="col">
                <div class="category">
                    <Select placeholder="Filter" />
                </div>
            </div>
        </div> -->
     
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
                        
                        <router-link :to="{name: 'admin-edit-item', params: {id: data.item_id} }">View/Edit this item</router-link> |
                        <i class="pi pi-user m-1"></i>
                        <small class="text-warning" @click="viewUser(data.user_id)">Track User</small> |
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

.container {
    box-shadow: 2px 10px 15px 2px gray;
    margin-top: 5rem;
    padding: 1rem;
    border-radius: 10px;
    width: 100%;
    box-sizing: border-box;
}

.notif {
    margin-bottom: 1rem;
}

.notif-info {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
}

.info {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    border-bottom: 1px solid rgb(177, 207, 8);
    background: rgb(247, 245, 245);
    border-radius: 15px;
    padding: 1rem;
}

.date_and_time {
    font-size: 0.9rem;
    color: #555;
}

.message b {
    display: block;
    margin-bottom: 0.25rem;
}

.notif_info_option {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

@media (min-width: 768px) {
    .info {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }

    .notif-info {
        flex: 1;
    }

    .notif_info_option {
        flex: 0 0 auto;
        justify-content: flex-end;
    }
}
</style>
