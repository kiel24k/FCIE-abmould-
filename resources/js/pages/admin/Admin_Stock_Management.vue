<script setup>
import Header from '@/components/Admin_Header.vue'
import { Button, Message, Select } from 'primevue';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';

//COMPONENTS VARIABLE

//API VARIABLE
const getLogsData = ref({})
//API FUNCTION
const API_GET_LOGS = async () => {
    await axios({
        method: 'GET',
        url: 'api/get-logs',
    }).then(response => {
        getLogsData.value = response.data
    })
}

//COMPONENTS FUNCTION
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
        url: "api/remove-logs",
        params: {
            id: data
        }
    }).then(response => {
        API_GET_LOGS()
        
    })
    Swal.fire({
      title: "Removed!",
      text: "Your file has been removed.",
      icon: "success"
    });
  }
});

    
    
     
}

//HOOKS
onMounted(() => {
    API_GET_LOGS()
})
</script>

<template>
    <header>
        <Header />
    </header>
    <section>
      
        <div class="container bg-white">
            <Message severity="contrast" icon="pi pi-ellipsis-v" size="large">Stock Adjustment Logs</Message>
            <div class="row p-2">
                <div class="col">
                    <div class="category">
                        <Select placeholder="Filter" />
                    </div>
                </div>
            </div>
         
            <div class="row" v-for="(data, index) in getLogsData" :key="index" >
                <div class="col notif">
                    <div class="info">
                        <div class="notif-info">
                            <div class="date_and_time d-grid ">
                                <span>{{ data.date_released }}</span>
                                <b>{{ data.time }}</b>
                            </div>
                            <div class="user-info">
                                <Button icon="pi pi-wrench" severity="contrast" rounded raised class="m-3" v-if="data.action === 'treshold' " />
                                <Button icon="pi pi-wrench" severity="secondary" rounded raised class="m-3" v-if="data.action === 'quantity'" />
                            </div>
                            <div class="message">
                                <b>{{ data.action === "treshold" ? "Managing Treshold" : data.action === "quantity" ? "Managing Stocks" : "managing" }}</b>
                                <p>The User named "{{ data.first_name }}" Successfull <b class="text-primary">{{ data.action === "treshold" ? "Changed the Treshold" : data.action === "quantity" ? "Changed the Stock" : "Changed the Item" }}</b> From Inventory</p>
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