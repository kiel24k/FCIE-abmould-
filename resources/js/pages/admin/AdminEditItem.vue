<script setup>
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router'
import { useRouter } from 'vue-router';
import BarcodeView from '@/components/BarcodeView.vue'
import Loading from '@/components/Loading.vue'
import { Button, FloatLabel, InputNumber, InputText, Select, Textarea } from 'primevue';
import Swal from 'sweetalert2';

const route = useRoute()
const router = useRouter()
const itemCategory = ref([
    { name: 'tools' },
    { name: 'materials' }
])

//get updated data/Item
const input = ref({})
const loading = ref(false)
//API VARIABLES
const itemCategoryData = ref([])

//API FUNCTION

const updatedItemResponse = () => {
    loading.value = true
    axios({
        method: 'GET',
        url: `/api/updated-item/${route.params.id}`
    }).then(response => {
        loading.value = false
        input.value = response.data
    })
}
const userInformation = ref()
const user = (val) => {
    userInformation.value = val


}

const GET_ITEM_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: '/api/all-item-category'
    }).then(response => {
        itemCategoryData.value = response.data
    })
}

//update the current data
const validation = ref({})
const submit = () => {
    axios({
        method: 'POST',
        url: `/api/update-item/${route.params.id}`,
        data: {
            userId: userInformation.value.id,
            item_id: input.value.id,
            item_code: input.value.item_code,
            supplier_name: input.value.supplier_name,
            unit_cost: input.value.unit_cost,
            quantity: input.value.quantity,
            category: input.value.category,
            description: input.value.description,
            treshold: input.value.treshold,
            brand: input.value.brand
        }
    }).then(response => {
        if (response.status == 200) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Item has been updated",
                showConfirmButton: false,
                timer: 1500
            });
            router.push('/admin-inventory-list')
        }
    }).catch(err => {
        if (err.response.status) {
            validation.value = err.response.data.errors
        }

    })
}

const back = () => {
    history.back()
}

watch(() => route.params.id, (oldData, newData) => {
    updatedItemResponse()
   
});

//HOOKS


onMounted(() => {
    updatedItemResponse()
    GET_ITEM_CATEGORY_API()
})
</script>

<template>
    <header>
        <Header @user="user" />
    </header>
    <div class="row edit_form">
        <div class="col">
            <div class="admin-edit-item">
                <form @submit.prevent enctype="multipart/form-data">
                    <h4>Edit Item | <span style="color:gray;font-size:15px; font-weight:400">Enter Item
                            Information</span></h4>
                    <div class="row">
                        <div class="col">
                            <span class="text-danger" v-if="validation.item_code">{{ validation.item_code[0] }}</span>
                            <FloatLabel variant="on">
                                <InputText id="on_label" size="large" :invalid="validation.item_code"
                                    v-model="input.item_code" class="form-control" />
                                <label for="on_label">Item Code</label>
                            </FloatLabel>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText id="on_label" size="large" v-model="input.brand" class="form-control" />
                                <label for="on_label">Brand</label>
                            </FloatLabel>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mt-4">
                            <FloatLabel variant="on">
                                <InputText id="on_label" size="large" v-model="input.supplier_name"
                                    class="form-control" />
                                <label for="on_label">Suppier Name</label>
                            </FloatLabel>
                        </div>
                        <div class="col">
                            <label for="">Unit Cost: <span class="text-danger" v-if="validation.unit_cost">
                                    {{ validation.unit_cost[0] }}
                                </span></label>
                            <InputNumber v-model="input.unit_cost" size="large" inputId="currency-us" mode="currency"
                                currency="PHP" locale="en-US" fluid />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Qty: <span class="text-danger" v-if="validation.quantity">
                                    {{ validation.quantity[0] }}
                                </span></label>
                            <InputNumber v-model="input.quantity" :invalid="validation.quantity"
                                inputId="horizontal-buttons" showButtons buttonLayout="horizontal" :step="1" :min="0"
                                fluid>
                                <template #incrementbuttonicon>
                                    <span class="pi pi-plus" />
                                </template>
                                <template #decrementbuttonicon>
                                    <span class="pi pi-minus" />
                                </template>
                            </InputNumber>
                        </div>
                        <div class="col">
                            <label for="">Threshold: <span class="text-danger" v-if="validation.treshold">
                                    {{ validation.category[0] }}
                                </span></label>
                            <div class="card flex justify-center">
                                <InputNumber v-model="input.treshold" :invalid="validation.treshold"
                                inputId="horizontal-buttons" showButtons buttonLayout="horizontal" :step="1" :min="0"
                                fluid>
                                <template #incrementbuttonicon>
                                    <span class="pi pi-plus" />
                                </template>
                                <template #decrementbuttonicon>
                                    <span class="pi pi-minus" />
                                </template>
                            </InputNumber>
                            </div>
                        </div>
                        <div class="col">
                            <label for="">Item Type: <span class="text-danger" v-if="validation.category">
                                    {{ validation.category[0] }}
                                </span></label>
                            <div class="card flex justify-center">
                                <select class="form-select" v-model="input.category">
                                    <option :value="data.name" v-for="data in itemCategoryData">{{ data.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="">Description: <span class="text-danger" v-if="validation.description">
                                    {{ validation.description[0] }}
                                </span></label>
                            <Textarea name="" autoResize id="" cols="30" rows="10" class="form-control"
                                :invalid="validation.description" v-model="input.description"></Textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label for="">Barcode:</label>
                        <BarcodeView :barcodeValue="input.item_code" />

                    </div>
                    <div class="row">
                        <div class="row ">
                            <div class="col action">
                                <Button label="Back" icon="pi pi-arrow-circle-left" iconPos="left" severity="danger"
                                    raised @click="back" />
                                    
                                <Button label="Update" icon="pi pi-refresh" iconPos="right" severity="success" raised
                                    @click.enter="submit" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Loading v-if="loading" />
    </div>
</template>


<style scoped>
form {
    width: 100%;
    max-width: 1120px; /* ~70rem */
    margin: auto;
    display: grid;
    gap: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 2rem;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    box-sizing: border-box;
}

.action {
    display: flex;
    flex-wrap: wrap;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 1rem;
}

.edit_form {
    margin-top: 5rem;
    padding: 0 1rem;
}

/* Responsive layout */
@media screen and (max-width: 768px) {
    form {
        padding: 1rem;
        gap: 20px;
    }

    .row {
        flex-direction: column;
    }

    .col {
        width: 100% !important;
        margin-bottom: 1rem;
    }

    .action {
        justify-content: center;
    }
}

</style>
