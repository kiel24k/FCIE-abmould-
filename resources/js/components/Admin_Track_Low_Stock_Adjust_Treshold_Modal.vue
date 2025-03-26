<script setup>
import axios from 'axios';
import { Button, FloatLabel, InputNumber, InputText } from 'primevue';
import { onMounted, ref } from 'vue';

const emit = defineEmits(['closeAdjustTresholdModal'])
const props = defineProps(['tableId'])

//API VARIABLE
const tresholdData = ref({})
const validation = ref({})

const GET_TRESHOLD_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/get-treshold',
        params:{
            id: props.tableId
        }

    }).then(response => {
       tresholdData.value = response.data
        
    })
}

const submit =  async () => {
    await axios({
        method: 'POST',
        url: 'api/update-treshold',
        data: {
            id: tresholdData.value.id,
            treshold:tresholdData.value.treshold
        }
    }).then(response => {
        console.log(response);
        
    }).catch(e => {
       validation.value = e.response.data.errors
        
    })
} 

const closeAdjustTresholdModal = () => {
    emit('closeAdjustTresholdModal')
}

//HOOKS
onMounted(() => {
    GET_TRESHOLD_API()
})
</script>
<template>
    <div class="modal-main">
        <div class="content">
            <fieldset>
                <form action="">
                    <input type="hidden" v-model="tresholdData.id">
                        <div class="form-title ">
                            <h5>Adjust Stock</h5>
                        </div>  
                    <div class="row mt-2">
                        <div class="col">
                            <i class="text-danger" v-if="validation.treshold">{{ validation.treshold[0] }}</i>
                            <FloatLabel variant="in">
                                <InputNumber :useGrouping="false" v-model="tresholdData.treshold" />
                                <label for="in_label">Adjust Treshold</label>
                            </FloatLabel>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-end form-action">
                            <Button label="Cancel" severity="danger" @click="closeAdjustTresholdModal()" />
                            <Button severity="info" label="Save" raised @click="submit()"/>
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


.form-action{
    display: flex;
    gap:5px;
    justify-content: end;
}
</style>