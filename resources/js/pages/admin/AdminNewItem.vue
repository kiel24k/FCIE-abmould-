<script setup>
import Header from '@/components/Admin_Header.vue'
import axios from 'axios';
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { FloatLabel, InputText, Message, InputNumber, Select, Textarea, Button, InputGroup, DatePicker } from 'primevue';
import Swal from 'sweetalert2';

const router = useRouter()
const userInformation = ref()


const validation = ref({})
const input = ref({
    item_code: '',
    supplier_name: '',
    unit_cost: '0',
    quantity: 0,
    category: '',
    treshold: 1,
    description: '',
    brand: ''
})
const allCategoryData = ref({})

const user = (id) => {
    userInformation.value = id
}

const GET_ALL_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/all-item-category'
    }).then(response => {
        allCategoryData.value = response.data
    })
}


const submit = () => {
    axios({
        method: 'POST',
        url: 'api/new-item',
        data: {
            user_id: userInformation.value.id,
            item_code: input.value.item_code,
            supplier_name: input.value.supplier_name,
            unit_cost: input.value.unit_cost,
            quantity: input.value.quantity,
            treshold: input.value.treshold,
            out_of_stock_notif: input.value.out_of_stock_notif,
            category: input.value.category.name,
            description: input.value.description,
            brand: input.value.brand,
            // barcode: barcodeValue.value
        }
    }).then(response => {
        console.log(response);
        if (response.status = 200) {
            router.push('/admin-inventory-list')
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Item Added!",
                showConfirmButton: false,
                timer: 2000
            });
        }
    }).catch(res => {
        console.log(res);
        if (res.response.status == 422) {
            validation.value = res.response.data.errors
        }
    })
}

const barcodeValue = ref(null)
const selectBarcode = () => {
    axios({
        method: 'GET',
        url: 'api/generate-barcode',
    }).then(response => {
        barcodeValue.value = response.data
    })
}
const back = () => {
    history.back()
}
onMounted(() => {
    selectBarcode()
    GET_ALL_CATEGORY_API()
})
</script>

<template>
    <header>
        <Header @user="user" />
    </header>
    <div class="row m-5">
        <div class="col">
            <form @submit.prevent enctype="multipart/form-data">
                <div class="card card-main">
                    <div class="card-header bg-dark">
                        <h4 class="text-white">New Item | <span
                                style="color:white;font-size:15px; font-weight:400">Enter Item Information</span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <span class="text-danger" v-if="validation.category">
                                    {{ validation.category[0] }}
                                </span>
                               <div class="category_input">
                                <Select placeholder="Select Category" :options="allCategoryData" optionLabel="name" v-model="input.category" />
                                <router-link :to="{name: 'admin-new-category'}">
                                    <Button label="Create category" icon="pi pi-plus" severity="info" />
                                </router-link>
                               </div>
                               
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <span class="text-danger" v-if="validation.item_code">{{ validation.item_code[0]
                                    }}</span>
                                <FloatLabel variant="on">
                                    <InputText id="Item Code" :invalid="validation.item_code" v-model="input.item_code"
                                        variant="filled" size="large" class="form-control" />
                                    <label for="Item Code">Item Code</label>
                                </FloatLabel>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <Message severity="error" variant="simple">Optional:</Message>
                                <FloatLabel variant="on">
                                     <InputText id="Item Code" v-model="input.brand" variant="filled" size="large"
                                        class="form-control" />
                                    <label for="Item Code">Brand</label>
                                </FloatLabel>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <Message severity="error" variant="simple">Optional:</Message>
                                <FloatLabel variant="on">
                                    <InputText id="label" v-model="input.supplier_name" variant="filled" size="large"
                                        class="form-control" />
                                    <label for="label">Supplier Name</label>
                                </FloatLabel>
                            </div>
                            <div class="col">
                                <InputNumber v-model="input.unit_cost" :invalid="validation.unit_cost" size="large"
                                    inputId="stacked-buttons" showButtons mode="currency" currency="PHP" fluid
                                    placeholder="Unit Cost" class="mt-4" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-3">
                                <label for="">Quantity: <span class="text-danger" v-if="validation.quantity">{{
                                    validation.quantity[0] }}</span></label>
                                <InputNumber v-model="input.quantity" :invalid="validation.quantity"
                                    inputId="horizontal-buttons" showButtons buttonLayout="horizontal" :step="1"
                                    :min="1" fluid>
                                    <template #incrementbuttonicon>
                                        <span class="pi pi-plus" />
                                    </template>
                                    <template #decrementbuttonicon>
                                        <span class="pi pi-minus" />
                                    </template>
                                </InputNumber>
                            </div>

                            <div class="col mt-3">
                                <label for="">Treshold: <span class="text-danger" v-if="validation.treshold">{{
                                    validation.treshold[0]
                                }}</span></label>
                                <InputNumber v-model="input.treshold" :invalid="validation.treshold"
                                    inputId="horizontal-buttons" showButtons buttonLayout="horizontal" :step="1"
                                    :min="1" fluid>
                                    <template #incrementbuttonicon>
                                        <span class="pi pi-plus" />
                                    </template>
                                    <template #decrementbuttonicon>
                                        <span class="pi pi-minus" />
                                    </template>
                                </InputNumber>
                            </div>


                          
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Description: <span class="text-danger" v-if="validation.description">
                                        {{ validation.description[0] }}
                                    </span></label>
                                <Textarea name="" :invalid="validation.description" id="" cols="30" rows="10" autoResize
                                    class="form-control" v-model="input.description"></Textarea>


                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-1 generate-barcode">
                                <label for="">Barcode:</label>
                                <div>
                                    <BarcodeComponent :barcodeValue="barcodeValue" />
                                    <button class="btn btn-dark" @click="selectBarcode">Generate Barcode</button>
                                </div>
                            </div>
                        </div> -->
                        <input type="hidden" v-model="barcodeValue">
                        <div class="row text-end">
                            <div class="col action">
                                <Button label="Back" icon="pi pi-arrow-circle-left" severity="danger m-2 " raised
                                    @click="back" />
                                <Button label="Save" icon="pi pi-check" iconPos="right" severity="success m-2" raised
                                    @click.enter="submit" />
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>



<style scoped>
form {
    width: 70rem;
    margin: auto;
    display: grid;
    gap: 25px;
    border-radius: 10px;
    padding: 10px;


}

.card-main {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}


label {
    font-weight: 500;
}



.action {
    display: flex;
    justify-content: end;
}
.category_input{
display: flex;
gap:10px;
}
</style>
