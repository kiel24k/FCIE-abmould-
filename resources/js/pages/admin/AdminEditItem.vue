<template>
    <header>
        <Header />
    </header>
    <div class="row m-2">
        <div class="col">
            <div class="admin-edit-item">
                <form @submit.prevent enctype="multipart/form-data">
                    <h4>Edit Item | <span style="color:gray;font-size:15px; font-weight:400">Enter Item
                            Information</span></h4>
                    <div class="row">
                        <div class="col">
                            <span class="text-danger" v-if="validation.item_code">{{ validation.item_code[0] }}</span>
                            <FloatLabel variant="on">
                                <InputText id="on_label" size="large"  :invalid="validation.item_code"
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
                            <label for="">Quantity: <span class="text-danger" v-if="validation.quantity">
                                    {{ validation.quantity[0] }}
                                </span></label>
                            <InputNumber v-model="input.quantity" :invalid="validation.quantity" inputId="horizontal-buttons" showButtons
                                buttonLayout="horizontal" :step="1" :min="0" fluid>
                                <template #incrementbuttonicon>
                                    <span class="pi pi-plus" />
                                </template>
                                <template #decrementbuttonicon>
                                    <span class="pi pi-minus" />
                                </template>
                            </InputNumber>
                        </div>
                        <div class="col">
                            <label for="">Item Type: <span class="text-danger" v-if="validation.category">
                                    {{ validation.category[0] }}
                                </span></label>
                            <div class="card flex justify-center">
                                <Select v-model="input.category" :invalid="validation.category" :options="itemCategory" optionLabel="name"
                                    placeholder="Select a City" class="w-full md:w-56" />
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
                        <div class="row text-end">
                            <div class="col action">
                                <Button label="Back" icon="pi pi-arrow-circle-left" iconPos="left" severity="danger m-2 " raised @click="back"/>
                                <Button label="Update" icon="pi pi-refresh" iconPos="right" severity="success m-2" raised @click.enter="submit"/>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <Loading v-if="loading" />
    </div>
</template>
<script setup>
import Header from '@/components/Admin_Header.vue'
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router'
import { useRouter } from 'vue-router';
import BarcodeView from '@/components/BarcodeView.vue'
import Loading from '@/components/Loading.vue'
import { Button, FloatLabel, InputNumber, InputText, Select, Textarea } from 'primevue';

const route = useRoute()
const router = useRouter()
const itemCategory = ref([
    { name: 'tools' },
    { name: 'materials' }
])

//get updated data/Item
const input = ref({})
const loading = ref(false)
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

//update the current data
const validation = ref({})
const submit = () => {
    axios({
        method: 'POST',
        url: `/api/update-item/${route.params.id}`,
        data: {
            item_code: input.value.item_code,
            supplier_name: input.value.supplier_name,
            unit_cost: input.value.unit_cost,
            quantity: input.value.quantity,
            category: input.value.category.name,
            description: input.value.description,
            brand: input.value.brand
        }
    }).then(response => {
        if (response.status == 200) {
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


onMounted(() => {
    updatedItemResponse()
})
</script>

<style scoped>
form {
    width: 70rem;
    margin: auto;
    display: grid;
    gap: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 10px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
</style>
