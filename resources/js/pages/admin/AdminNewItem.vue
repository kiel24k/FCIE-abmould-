<template>
    <div class="row">
        <div class="col">
            <Header/>
            <form @submit.prevent enctype="multipart/form-data">
                <h4>New Item | <span style="color:gray;font-size:15px; font-weight:400">Enter Item Information</span></h4>
                <div class="row">
                    <div class="col">
                        <label for="">Item Code <span class="text-danger" v-if="validation.item_code">
                            {{ validation.item_code[0] }}
                        </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="input.item_code" >
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Brand: <span class="text-danger">
                            option
                        </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="input.brand" >
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Supplier Name <span class="text-danger" v-if="validation.supplier_name">
                            {{ validation.supplier_name[0] }}
                        </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="input.supplier_name">
                    </div>
                    <div class="col">
                        <label for="">Unit Cost: <span class="text-danger" v-if="validation.unit_cost" >
                            {{ validation.unit_cost[0] }}
                          </span></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">₱</span>
                            <input type="number" class="form-control" placeholder="" v-model="input.unit_cost">
                          </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Quantity: <span class="text-danger" v-if="validation.quantity">
                            {{ validation.quantity[0] }}
                        </span></label>
                        <input type="number" class="form-control" placeholder="" v-model="input.quantity">
                    </div>
                    <div class="col">
                        <label for="">Item Type: <span class="text-danger" v-if="validation.category">
                            {{ validation.category[0] }}
                        </span></label>
                        <select class="form-select" v-model="input.category">
                            <option value="materials">materials</option>
                            <option value="tools">tools</option>
                        </select>
                    </div>
                </div>
               <div class="row">
                <div class="col">
                    <label for="">Description: <span class="text-danger" v-if="validation.description">
                        {{ validation.description[0] }}
                    </span></label>
                    <textarea name="" id="" cols="30" rows="10" class="form-control" v-model="input.description"></textarea>
                </div>
               </div>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-success" @click.enter="submit">Submit</button>
                    </div>
                </div>
              </form>
        </div>
    </div>
</template>
<script setup>
import Header from '@/components/Admin_Header.vue'
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter()


const validation = ref({})
const input = ref({
    item_code: '',
    supplier_name: '',
    unit_cost: '',
    quantity: '',
    category: '',
    description: '',
    brand: ''

})
const submit = () => {
    axios({
        method: 'POST',
        url: 'api/new-item',
        data: {
        item_code: input.value.item_code,
        supplier_name: input.value.supplier_name,
        unit_cost: input.value.unit_cost,
        quantity: input.value.quantity,
        category: input.value.category,
        description: input.value.description,
        brand: input.value.brand

        }
    }).then(response => {
        console.log(response);
        if(response.status = 200){
            router.push('/admin-inventory-list')
        }
    }).catch(res => {
        console.log(res);
        if(res.response.status == 422){
          validation.value = res.response.data.errors
        }
    })
}

</script>

<style scoped>

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
