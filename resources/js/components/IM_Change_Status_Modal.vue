<script setup>
import { Button, FloatLabel, InputText, Message, Select } from 'primevue';
import { ref } from 'vue';
import Swal from 'sweetalert2';

const selectStatus = ref()
const status = ref([
    { name: 'pending' },
    { name: 'approved' },
    { name: 'not-approved' },
    {name:'released'}
])
const emit = defineEmits(['closeModal'])
const props = defineProps(['statusData'])
const closeModal = () => {
    emit('closeModal')
}

const updateBtn = async (id) => {
    const response = await axios.post('api/IM-update-schedule-status', {
        id: id,
        status: selectStatus.value.name
    })
    if (response.status === 200) {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Status has been changed",
            showConfirmButton: false,
            timer: 1500
        });
        emit('closeModal')

    }

}
</script>

<template>
    <div class="modal">
        <transition name="changeStatusModal">

            <div class="container">
                <div class="row title">
                    <div class="col">
                        <Message severity="warn" icon="pi pi-info-circle" variant="outlined">Change Status</Message>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <FloatLabel variant="in">
                            <InputText id="in_label" v-model="statusData.supplier_name" variant="filled" disabled
                                fluid />
                            <label for="in_label">Supplier Name</label>
                        </FloatLabel>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <FloatLabel variant="in">
                            <InputText id="in_label" v-model="statusData.item_code" variant="filled" disabled fluid />
                            <label for="in_label">Item Code</label>
                        </FloatLabel>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <FloatLabel variant="in">
                            <InputText id="in_label" v-model="statusData.quantity" variant="filled" disabled fluid />
                            <label for="in_label">Quantity</label>
                        </FloatLabel>
                    </div>
                    <div class="col">
                        <FloatLabel variant="in">
                            <InputText id="in_label" v-model="statusData.date_schedule" variant="filled" disabled
                                fluid />
                            <label for="in_label">Supplier Name</label>
                        </FloatLabel>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col">
                        <FloatLabel variant="in">
                            <InputText id="in_label" v-model="statusData.status" variant="filled" disabled fluid />
                            <label for="in_label">Quantity</label>
                        </FloatLabel>
                    </div>
                    <div class="col">
                        <FloatLabel variant="in">
                            <Select v-model="selectStatus" :options="status" id="in_label" optionLabel="name"
                                variant="filled" fluid />
                            <label for="in_label">Change Status</label>
                        </FloatLabel>

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col text-end table-action">
                        <Button @click="closeModal" label="Close" severity="danger" raised />
                        <Button @click="updateBtn(statusData.id)" :disabled="!selectStatus" label="Update" severity="info" raised />
                    </div>
                </div>
            </div>
        </transition>
    </div>
</template>
<style scoped>
.modal {
    position: fixed;
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: center;
    height: 100%;
    z-index: 999;
    overflow: hidden;
    background: rgb(236, 236, 236, 0.5);
    

}

.changeStatusModal-enter-active {
    transition: all 0.1s ease-out;
}

.changeStatusModal-enter-from {
    transform: translateY(-40px);
    opacity: 0;
}

.container {
    padding: 15px;
    border-radius: 10px;
    background-color: white;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

@keyframes bounce-in {
    0% {
        transform: scale(0);
    }

    50% {
        transform: scale(1.25);
    }

    100% {
        transform: scale(1);
    }
}

.table-action {
    display: flex;
    justify-content: end;
    gap: 10px;
}
</style>