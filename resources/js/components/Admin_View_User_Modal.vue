<script setup>
import { Button, FloatLabel, InputText, Message, Select } from 'primevue';
import { onMounted, ref } from 'vue';

const props = defineProps(['viewUserModalId'])
const emit = defineEmits(['closeViewUserModal'])

//COMPONENTS VARIABLE

//API VARIABLE
const viewUserData = ref({})

//API FUNCTION
const  GET_VIEW_USER_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/view-user',
        params: {
            id: props.viewUserModalId
        }
    }).then(response => {
        viewUserData.value = response.data
    })
}
//COMPONENTS FUNCTION
const closeViewUserModal = () => {
    emit('closeViewUserModal')
}

//HOOKS
onMounted(() => {
    GET_VIEW_USER_API()
})

</script>

<template>
    <div class="modal">
        
            <div class="container">
                <div class="row title">
                    <div class="col">
                        <Message severity="info" icon="pi pi-user" variant="outlined">Change Status</Message>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                       <Message >
                        First name: <b>{{ viewUserData.first_name }}</b>
                       </Message>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <Message>
                            Middle name: <b>{{ viewUserData.middle_name }}</b>
                           </Message>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <Message>
                            Last name: <b>{{ viewUserData.last_name }}</b>
                           </Message>
                    </div>
                    
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <Message>
                            Email: <b>{{ viewUserData.email }}</b>
                           </Message>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <Message icon="pi pi-phone">
                             <b>+63{{ viewUserData.tel_no }}</b>
                           </Message>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <Message icon="pi pi-info">
                             <b>{{ viewUserData.role }}</b>
                           </Message>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-end table-action">
                        <Button @click="closeViewUserModal()" label="Close" severity="danger" raised />
                    </div>
                </div>
            </div>
    </div>
</template>
<style scoped>
.modal {
    position: absolute;
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: center;
    height: 100%;
    z-index: 999;
    overflow: hidden;
    background: rgb(236, 236, 236, 0.5);

}



.container {
    padding: 15px;
    border-radius: 10px;
    background-color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}


.table-action {
    display: flex;
    justify-content: end;
    gap: 10px;
}
</style>