<template>
 <transition name="transition">
    <div class="add-schedule">
        <div>
            <form @submit.prevent enctype="multipart/form-data">
                <h4>Schedule | <span style="color:gray;font-size:15px; font-weight:400">Schedule Information</span></h4>
                <div class="row">
                    <div class="col">
                        <label for="">Supplier Name <span class="text-danger" v-if="validation.supplier_name" >
                            {{ validation.supplier_name[0] }}
                        </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="input.supplier_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Item Name: <span class="text-danger" v-if="validation.item_code">
                            {{ validation.item_code[0] }}
                        </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="input.item_code" >
                    </div>
                    <div class="col">
                        <label for="">Quantity: <span class="text-danger" v-if="validation.quantity">
                            {{ validation.quantity[0] }}
                          </span></label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="" v-model="input.quantity" >
                          </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Date: <span class="text-danger" v-if="validation.date_schedule">
                                {{ validation.date_schedule[0] }}
                              </span></label>
                            <input type="date" data-date-format="YYYY-MM-DD" v-model="input.date_schedule" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-end">
                        <button class="btn btn-danger m-2" @click="closeModal">Close</button>
                        <button class="btn btn-success m-2" @click="submit" >Submit</button>
                    </div>
                </div>
              </form>
        </div>
    </div>
 </transition>
</template>

<script setup>
import { ref } from 'vue';

const input = ref({})
const validation = ref({})
const submit = () => {
   axios({
    method: 'POST',
    url: '/api/add-schedule',
    data: {
        supplier_name: input.value.supplier_name,
        item_code: input.value.item_code,
        quantity: input.value.quantity,
        status: input.value.status,
        date_schedule: input.value.date_schedule
    }
   }).then(response => {
    if(response.status === 200){
        modal('data')
    }
   }).catch(err => {
    console.log(err);
    if(err.response.status){
        validation.value = err.response.data.errors
    }
   })
}
const modal =  defineEmits(['data'])
const closeModal = () => {
modal('data')
}
</script>
<style scoped>
.add-schedule{
    position:absolute;
    width: 100%;
    height: 100%;
    display: grid;
    justify-content: center;
    align-content: center;
    background: rgb(248, 246, 246,0.9);
    z-index:999;
    margin:auto;

}
form{
    width: 70rem;
    margin: auto;
    display:grid;
    gap:25px;
    background:#ffffff;
    border-radius: 10px;
    padding:10px;
}


</style>
