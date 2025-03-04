<script setup>
import { Button, InputText } from 'primevue';

const emit = defineEmits(['closeAdjustTresholdModal'])

const submit = () => {
    alert('Working...')
} 

const closeAdjustTresholdModal = () => {
    emit('closeAdjustTresholdModal')
}
</script>
<template>
    <div class="modal-main">
        <div class="content">
            <fieldset>
                <form action="">
                        <div class="form-title ">
                            <h5>Adjust Treshold</h5>
                        </div>  
                    <div class="row mt-4 ">
                        <div class="col">
                            <InputText placeholder="Current Stock" />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <InputText placeholder="Current Treshold" />
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <InputText placeholder="Adjust Treshold" />
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