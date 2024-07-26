<template>
   <div class="container-fluid">
    <div class="col text-center">
        <h4>Schedules of materials & Equipments</h4>
    </div>
    <div class="row text-center justify-content-center">
        <div class="col-2">
            <p>Materials</p>
        </div>
        <div class="col-2">
            <p>equipments</p>
        </div>
        <hr>
    </div>
   <table class="table table-borderless">
    <thead>
        <tr>
            <th>Supplier</th>
            <th>Materials</th>
            <th>Quantity</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody v-if="scheduledResponse.data != 0">
        <tr v-for="(data, index) in scheduledResponse" :key="index" >
            <td>{{ data[0].supplier_name }}</td>
            <td>{{ data[0].item_code }}</td>
            <td>{{ data[0].quantity }}</td>
            <td>{{ data[0].status }}</td>
        </tr>
    </tbody>
   </table>
    <Loading v-if="loading"/>
   </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
const props = defineProps(['data'])
import Loading from '@/components/Loading.vue'

const loading = ref(false)
const scheduledResponse = ref([])
try{

watch(props, (oldVal, newVal) => {
    loading.value = true
    axios({
        method: 'GET',
        url: `/api/scheduled-date/${props.data}`
    }).then(response=> {
        if(response.data.message == 200){
            loading.value = false
            scheduledResponse.value = response.data
        }else{
            loading.value = false
        }
    })
})

}catch(error) {
    alert("dsds")

}






</script>
<style scoped>
.container-fluid{

    box-shadow: 5px 5px 15px 0px gray;
    border-radius: 15px;
    height: 40rem;
    width: 100%;
}
</style>
