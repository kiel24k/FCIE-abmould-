<script setup>
import axios from 'axios';
import { Button, FloatLabel, InputNumber, InputText, Message, Select } from 'primevue';
import Swal from 'sweetalert2';
import { onMounted, ref, watch } from 'vue';

const emit = defineEmits(['closeUpdateUserRoleModal'])
const props = defineProps(['tableData', 'userId'])

//API VARIABLE


const selectRole = ref(props.tableData.role)
const validation = ref({})



const submit = async () => {
    await axios({
        method: 'POST',
        url: 'api/assign-role',
        data: {
            id: props.tableData.id,
            role: selectRole.value
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
            emit('closeUpdateUserRoleModal')
        }


    }).catch(err => {
        validation.value = err.response.data.errors
    })

}

const closeUpdateUserRoleModal = () => {
    emit('closeUpdateUserRoleModal')
}


//HOOKS


// onMounted(() => {

// })
</script>
<template>
    <div class="modal-main">
        <div class="content">
            <fieldset>
                <form action="">
                    <div class="form-title ">
                        <h5>Assign Role</h5>
                        <i class="pi pi-cog"></i>
                    </div>
                    <div class="row mt-2">
                        <div class="col user_info">
                            <!-- <Message icon="pi pi-user">
                                <small>{{ tableData.first_name }} {{ tableData.last_name }}</small>
                            </Message>
                            <Message icon="pi pi-envelope">
                                <small>{{ tableData.email }}</small>
                            </Message> -->
                            <span class="text-danger" v-if="validation.role">{{ validation.role[0] }}</span>
                            <select class="form-select" v-model="selectRole">
                                <option value="admin">ADMIN</option>
                                <option value="TL">TL</option>
                                <option value="inventory-manager">INVENTORY MANAGER</option>
                                <option value="member">MEMBER</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col text-end form-action">
                            <Button label="Cancel" severity="danger" raised @click="closeUpdateUserRoleModal()" />
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
    position: fixed;
    height: 100%;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
    background: rgb(0, 0, 0, 0.5);
    top: 0;
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

.form-title {
    display: flex;

    gap: 10px;
}

.user_info {
    display: grid;
    gap: 10px;
}
</style>