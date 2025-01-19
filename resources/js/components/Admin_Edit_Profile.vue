<script setup>
import { Button, FloatLabel, InputText } from 'primevue';
import Swal from 'sweetalert2';
import { ref } from 'vue';

const emit = defineEmits(['closeModal'])
const props = defineProps(['userInformation'])
const closeModal = () => {
    emit('closeModal')
}


const input = ref({})
const inputValidation = ref({})
const status = ref()



const submit = async () => {  
    try {
        const response = await axios.post('api/change-password', {
            id: props.userInformation.id,
            old_password: props.userInformation.password,
            current_password: input.value.current_password,
            new_password: input.value.new_password,
            confirm_new_password: input.value.confirm_new_password,
            
        });
        if(response.data.status === 401){
            status.value = response.data.message
        }else if(response.data.status === 200){
            Swal.fire("Password Change Successful");
            emit('closeModal')
        }
        console.log(response.data.status);
        
    //    if(response.status === 200){
    //     Swal.fire("Password Changed Successful");
    //     emit('closeModal')
    //    }

    } catch (err) {
        inputValidation.value =  err.response.data.errors
    }
}

</script>

<template>
    <div class="modal-body">
        <div class="content p-4">
            <fieldset>
                <form action="" @submit.prevent>
                    <div class="row">
                        <div class="col form-title"
                            style="display: flex; justify-content:space-between; align-items:center">
                            <h5>Change Password</h5>
                            <Button rounded severity="contrast" icon="pi pi-times" size="small" raised
                                @click="closeModal" />
                        </div>
                    </div>
                    <div class="row" v-if="status">
                        <div class="col">
                            <span>{{status}}</span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText autocomplete="off" fluid v-model="input.current_password" />
                                <label for="on_label">Current Password</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="inputValidation.current_password">{{ inputValidation.current_password[0] }}</small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <FloatLabel variant="on">
                                <InputText autocomplete="off" fluid v-model="input.new_password" />
                                <label for="on_label">New Password</label>
                            </FloatLabel>
                            <small class="text-danger" v-if="inputValidation.new_password">{{ inputValidation.new_password[0] }}</small>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="co text-end">
                            <Button label="Submit" severity="danger" raised @click="submit" />
                        </div>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</template>
<style scoped>
.modal-body {
    position: absolute;
    height: 100%;
    width: 100%;
    display: grid;
    justify-content: center;
    align-items: center;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

.content {
    background: White;
    border-radius: 10px;
}
</style>