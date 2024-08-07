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
    </div>
   <table class="table table-borderless table-hover">

    <thead>
        <tr>
            <th>Supplier</th>
            <th>Item</th>
            <th>Quantity</th>
            <th>Date scheduled</th>
        </tr>
    </thead>
    <tbody>
        <tr v-for="(data, index) in scheduledData" :key="index">
            <td>{{ data.supplier_name }}</td>
            <td>{{ data.item_code }}</td>
            <td>{{ data.quantity }}</td>
            <td>{{ data.date_schedule }}</td>
        </tr>
    </tbody>
   </table>
   </div>

</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
const props = defineProps(['selectedDate'])

//get date selected
const scheduledData = ref({})
watch(props, (oldVal, newVal) => {
    axios({
        method: 'GET',
        url:`/api/scheduled-date/${props.selectedDate}`
    }).then(response => {
        scheduledData.value = response.data.data
    })
})

</script>
<style scoped>
.container-fluid{
    box-shadow: 5px 5px 15px 0px rgb(83, 81, 81);
    border-radius: 15px;
    height: 40rem;
    width: 100%;
}
</style>
