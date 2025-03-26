<script setup>
import axios from 'axios';
import { Button, FloatLabel, InputNumber, InputText } from 'primevue';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';

const emit = defineEmits(['closeSetStockModal'])
const props = defineProps(['tableId','userId'])

//API VARIABLE
const quantityData = ref({})
const validation = ref({})

const GET_STOCK_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/get-quantity',
        params: {
            id: props.tableId
        }

    }).then(response => {
        quantityData.value = response.data
console.log(response.data);

    })
}

const submit = async () => {
    await axios({
        method: 'POST',
        url: 'api/update-quantity',
        data: {
            userId: props.userId,
            id: quantityData.value.id,
            quantity: quantityData.value.quantity
        }
    }).then(response => {
        if (response.status === 200) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Change successfully",
                showConfirmButton: false,
                timer: 1500
            });
            emit('closeSetStockModal')
        }

    }).catch(e => {
        console.log(e);
        
        validation.value = e.response.data.errors

    })
}

const closeAdjustTresholdModal = () => {
    emit('closeSetStockModal')
}

//HOOKS
onMounted(() => {
    GET_STOCK_API()
})
</script>
<template>
    <div class="modal-main">
        <div class="content">
            <fieldset>
                <form action="">
                    <input type="hidden" v-model="quantityData.id">
                    <div class="form-title ">
                        <h5>Adjust Stock</h5>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <i class="text-danger" v-if="validation.quantity">{{ validation.quantity[0] }}</i>
                            <FloatLabel variant="in">
                                <InputNumber :useGrouping="false" v-model="quantityData.quantity" />
                                <label for="in_label">Stock</label>
                            </FloatLabel>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-end form-action">
                            <Button label="Cancel" severity="danger" @click="closeAdjustTresholdModal()" />
                            <Button severity="info" label="Save" raised @click="submit()" />
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</template>
<style scoped>
.modal-main {
    position: absolute;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
    background: rgb(0, 0, 0, 0.5);
}

form {
    background: #ffffff;
    padding: 20px;
}


.form-action {
    display: flex;
    gap: 5px;
    justify-content: end;
}
</style>