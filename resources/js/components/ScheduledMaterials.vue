<template>

    <div class="container-fluid">
        <div class="col text-center">
            <h4>Schedules of materials & Equipments</h4>
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
        url: `/api/scheduled-date/${props.selectedDate}`
    }).then(response => {
        scheduledData.value = response.data.data
    })
})

</script>
<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

h4{
    font-family: 'Poppins', 'san-serif';
}

.container-fluid {
    box-shadow: 5px 5px 15px 0px rgb(83, 81, 81);
    border-radius: 15px;
    height: 34rem;
    width: 90%;
    padding: 30px 20px;
    background-color: rgb(255, 255, 255);
}

th,
tbody {
    text-align: center;
}
</style>
