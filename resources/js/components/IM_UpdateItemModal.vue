<template>
    <div class="update-item">
        <div class="form p-5">
            <form @submit.prevent.enter enctype="multipart/form-data">
                <h4>New Material | <span style="color:gray;font-size:15px; font-weight:400">Enter Material Information</span></h4>
                <div class="row">
                    <div class="col">
                        <label for="">Item Code: <span class="text-danger" v-if="validation.item_code" >
                           {{validation.item_code[0] }}
                        </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="responseData.item_code" >
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Supplier Name: <span class="text-danger" >
                            optional
                        </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="responseData.supplier_name" >
                    </div>
                    <div class="col">
                        <label for="">Unit Cost: <span class="text-danger" v-if="validation.unit_cost" >
                            {{validation.unit_cost[0] }}
                          </span></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">₱</span>
                            <input type="number" class="form-control" placeholder="" v-model="responseData.unit_cost" >
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Quantity: <span class="text-danger" v-if="validation.quantity">
                            {{validation.quantity[0] }}
                        </span></label>
                        <input type="number" class="form-control" placeholder="" v-model="responseData.quantity">
                    </div>
                    <div class="col">
                        <label for="">Category: <span class="text-danger" v-if="validation.category" >
                            {{validation.category[0] }}
                        </span></label>
                        <select class="form-select" v-model="responseData.category">
                            <option value="" disabled>Select</option>
                            <option value="materials">Materials</option>
                            <option value="tools">Tools</option>
                        </select>
                    </div>
                </div>
               <div class="row">
                <div class="col">
                    <label for="">Description: <span class="text-danger" v-if="validation.description">
                        {{validation.description[0] }}
                    </span></label>
                    <textarea name="" id="" cols="30" rows="10" class="form-control" v-model="responseData.description"></textarea>
                </div>
               </div>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-danger" @click="closeBtn">Close</button>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-success" @click.enter="submit">Submit</button>
                    </div>
                </div>
              </form>
        </div>
        <Loading v-if="loading"/>
    </div>
</template>
<script setup>
import { onMounted, ref } from 'vue';
import Loading from '@/components/Loading.vue'


const closeModalEmit = defineEmits(['closeBtn'])
const props = defineProps(['itemId', 'getItem'])
const responseData = ref({})
const loading = ref(false)

const closeBtn = () => {
    closeModalEmit('closeBtn')
}

const getUpdatedItems = () => {
    loading.value = true
    axios({
        method: 'GET',
        url: `/api/IM_update-item/${props.itemId}`
    }).then(response => {
        loading.value = false
        responseData.value = response.data
    })
}

const validation = ref({})
const submit = () => {
    axios({
        method: 'POST',
        url: `/api/IM_submit-updated-item/${props.itemId}`,
        data: {
            item_code: responseData.value.item_code,
            supplier_name:responseData.value.supplier_name,
            unit_cost:responseData.value.unit_cost,
            quantity:responseData.value.quantity,
            description:responseData.value.description,
            category:responseData.value.category,
            brand:responseData.value.brand,
        }
    }).then(response => {
        if(response.status === 200){
            props.getItem()
            closeModalEmit('closeBtn')
        }
    }).catch(err => {
       if(err.response.status){
         validation.value = err.response.data.errors
       }
    })
}

onMounted(() => {
getUpdatedItems()
})

</script>
<style scoped>
.update-item{
    position:absolute;
    width: 100%;
    height: 100%;
    top:0;
    z-index: 999;
    background: rgb(228, 224, 224, 0.5);
    backdrop-filter: blur(5px);
    display: grid;
    justify-content: center;
    align-items: center;
}
.form{
    border-radius: 15px;
    background: rgb(228, 228, 228);
    box-shadow:0px 0px 15px 0px gray;
    width: 50rem;
    margin: auto;
    display:grid;
    gap:25px;
    border-radius: 10px;
    padding:10px;
}





</style>
