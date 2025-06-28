<script setup>
import { Button, FloatLabel, InputNumber, Select } from 'primevue';
import { onMounted, ref, watch } from 'vue';
import AdminScheduleRequestModal from '@/components/Admin_Schedule_Request_Modal.vue'


const props = defineProps(['userData'])

//components variables
const selectCategory = ref('')

const selectItemCode = ref('')
const selectSupplierName = ref('')

const isAdminScheduleRequestModal = ref(false)
const itemId = ref()
const quantityVal = ref()


//API toVariables
const scheduleItemCategoryData = ref({})
const scheduleDataPerCategoryData = ref({})

//API FUNCTION
const GET_SCHEDULE_ITEM_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/schedule-item-category',
    }).then(response => {
        scheduleItemCategoryData.value = response.data

    })
}

const GET_SCHEDULE_DATA_PER_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: '/api/schedule-data-per-category',
        params: {
            category: selectCategory.value.category,
            item_code: selectItemCode.value.item_code,
            supplier_name: selectSupplierName.value.supplier_name
        }
    }).then(response => {
        scheduleDataPerCategoryData.value = response.data
        console.log(response.data);

    }).catch(e => {
        scheduleDataPerCategoryData.value = null

    })
}



//COMPONENTS FUNCTIONS
const modal = defineEmits(['data'])
const closeModal = () => {
    modal('data')
}


const clearCategory = () => {
    selectCategory.value = ''
    GET_SCHEDULE_DATA_PER_CATEGORY_API()
}
const clearItemCode = () => {
    selectItemCode.value = ''
    GET_SCHEDULE_DATA_PER_CATEGORY_API()
}
const clearSupplierName = () => {
    selectSupplierName.value = ''
    GET_SCHEDULE_DATA_PER_CATEGORY_API()
}

const request = (id,quantity) => {
    isAdminScheduleRequestModal.value = true
    itemId.value = id
    quantityVal.value = quantity
    
}

const closeScheduleRequestModal = () => {
  isAdminScheduleRequestModal.value = false
    
}

//HOOKS
watch(selectCategory, (oldVal, newVal) => {
    GET_SCHEDULE_ITEM_CATEGORY_API()
    GET_SCHEDULE_DATA_PER_CATEGORY_API()

})
watch(selectItemCode, (oldVal, newVal) => {
    GET_SCHEDULE_ITEM_CATEGORY_API()
    GET_SCHEDULE_DATA_PER_CATEGORY_API()
})
watch(selectSupplierName, (oldVal, newVal) => {
    GET_SCHEDULE_ITEM_CATEGORY_API()
    GET_SCHEDULE_DATA_PER_CATEGORY_API()
})
onMounted(() => {
    GET_SCHEDULE_ITEM_CATEGORY_API()
    GET_SCHEDULE_DATA_PER_CATEGORY_API()
})
</script>

<template>
    <AdminScheduleRequestModal v-if="isAdminScheduleRequestModal" @closeScheduleRequestModal="closeScheduleRequestModal" :userData="userData" :itemId="itemId" :quantityVal="quantityVal"/>
    <transition name="transition">
        
        <div class="add-schedule">
            <div class="schedule">
                <form @submit.prevent enctype="multipart/form-data">
                    <h4>Schedule | <span style="color:gray;font-size:15px; font-weight:400">Schedule Information</span>
                    </h4>
                    <div class="row select-category">
                        <div class="col">
                            <div class="">
                                <Select v-model="selectCategory" :options="scheduleItemCategoryData.category" filter
                                    optionLabel="category" placeholder="Select a Category" >
                                    <template #value="slotProps">
                                        <div v-if="slotProps.value" class="flex items-center">
                                            <div>{{ slotProps.value.category }}</div>
                                        </div>
                                        <span v-else>
                                            {{ slotProps.placeholder }}
                                        </span>
                                    </template>
                                    <template #option="slotProps">
                                        <div class="flex items-center">
                                            <div>{{ slotProps.option.category }}</div>
                                        </div>
                                    </template>
                                </Select>
                            </div>
                        </div>
                        <div class="col-1">
                            <Button label="Clear" severity="contrast" raised @click="clearCategory()" />
                        </div>
                    </div>
                    <div class="row select-category">
                        <div class="col">
                            <div class="">
                                <Select v-model="selectSupplierName" :options="scheduleItemCategoryData.supplier_name"
                                    filter optionLabel="supplier_name" placeholder="Select a Supplier name "
                                    class="w-full md:w-">
                                    <template #value="slotProps">
                                        <div v-if="slotProps.value" class="flex items-center">
                                            <div>{{ slotProps.value.supplier_name }}</div>
                                        </div>

                                        <span v-else>
                                            {{ slotProps.placeholder }}

                                        </span>
                                    </template>
                                    <template #option="slotProps">
                                        <div class="flex items-center">
                                            <div>{{ slotProps.option.supplier_name }}</div>
                                        </div>
                                    </template>
                                </Select>
                            </div>

                        </div>
                        <div class="col-1">
                            <Button label="Clear" severity="contrast" raised @click="clearSupplierName()" />
                        </div>
                    </div>
                    <div class="row select-category">
                        <div class="col">
                            <div class="">
                                <Select v-model="selectItemCode" :options="scheduleItemCategoryData.item_code" filter
                                    optionLabel="item_code" placeholder="Select an Item Code " class="w-full md:w-56">
                                    <template #value="slotProps">

                                        <div v-if="slotProps.value" class="flex items-center">
                                            <div>{{ slotProps.value.item_code }}</div>
                                        </div>
                                        <span v-else>
                                            {{ slotProps.placeholder }}
                                        </span>
                                    </template>
                                    <template #option="slotProps">
                                        <div class="flex items-center">
                                            <div>{{ slotProps.option.item_code }}</div>
                                        </div>
                                    </template>
                                </Select>
                            </div>
                        </div>
                        <div class="col-1">
                            <Button label="Clear" severity="contrast" raised @click="clearItemCode()" />
                        </div>
                    </div>
                   
                    <div class="row">
                        <div class="table-class table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Item Code</th>
                                        <th>Category</th>
                                        <th>Supplier name</th>
                                        <th>Description</th>
                                        <th>Current quantity</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in scheduleDataPerCategoryData">
                                        <td>{{ data.item_code }}</td>
                                        <td>{{ data.category }}</td>
                                        <td>{{ data.supplier_name }}</td>
                                        <td>{{ data.description }}</td>
                                        <td>{{ data.quantity }}x</td>
                                        <td>
                                            <Button label="Request" severity="info" icon="pi pi-send"
                                                @click="request(data.id,data.quantity)" />
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col text-end">
                            <button class="btn btn-danger m-2" @click="closeModal">Close</button>

                        </div>
                    </div>
                </form>
                <div class="form_data">
                    <div class="row">
                        <div class="col">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </transition>
</template>


<style scoped>
.p-select{
    width: 100%;
}
.add-schedule {
    position: fixed;
    width: 100%;
    height: 100%;
    display: grid;
    justify-content: center;
    align-content: start;
    background: rgb(0,0,0,0.5);
    z-index: 999;
    margin: auto;
    top:0;
    left:0;
}

.schedule {
    display: flex;
    margin-top:2rem;
}

form {
    width: 60rem;
    margin: auto;
    display: grid;
    gap: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0px 0px 10px gray;
}
.table-class{
    max-width: auto;
}

.category {
    display: flex;
}

.quantity_table {
    display: flex;
}

.quantity_table input {
    width: 100px;
    border: solid 1px rgb(155, 153, 153);
}

.quantity_table input:focus {
    outline: none;
    box-shadow: none;
}

@media (max-width: 851px){
    .table-class{
        width: 23rem;
    }
    .p-select{
    width: 23rem;
}
  .select-category{
    display: grid;
    gap: 10px;
  }

.schedule {
    display: flex;
    margin-top:2rem;
}

form {
    width: 25rem;
    margin: auto;
    display: grid;
    gap: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0px 0px 10px gray;
}

.category {
    display: flex;
   
}

.quantity_table {
    display: flex;
  
}

.quantity_table input {
    width: 100px;
    border: solid 1px rgb(155, 153, 153);
}

.quantity_table input:focus {
    outline: none;
    box-shadow: none;
}
}

@media (max-width: 200px){
    .p-select{
    width: 10rem;
}
  .select-category{
    display: grid;
    gap: 10px;
  }

.schedule {
    display: flex;
    margin-top:2rem;
}

form {
    width: 30rem;
    margin: auto;
    display: grid;
    gap: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 10px;
    box-shadow: 0px 0px 10px gray;
}

.category {
    display: flex;
   
}

.quantity_table {
    display: flex;
  
}

.quantity_table input {
    width: 100px;
    border: solid 1px rgb(155, 153, 153);
}

.quantity_table input:focus {
    outline: none;
    box-shadow: none;
}
}
</style>
