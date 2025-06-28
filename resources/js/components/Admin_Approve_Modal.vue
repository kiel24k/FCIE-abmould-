<script setup lang="ts">
import { Button, FloatLabel, InputText, Message, Textarea } from 'primevue';
import Swal from 'sweetalert2';
import { ref } from 'vue';

//COMPONENTS VARIABLE
const props = defineProps(['approveData'])
const emit = defineEmits(['closeApproveModal'])
const message = ref('')

//COMPONENTS FUNCTION
const closeModal = () => {
    emit('closeApproveModal')
}

const release = async () => {
    await axios({
        method: 'POST',
        url: '/api/approve-schedule',
        data: {
            item_id: props.approveData.id,
            schedule_id: props.approveData.schedule_id,
            message: message.value
        }
    }).then(response => {
        if (response.status === 200) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Data has been Changed",
                showConfirmButton: false,
                timer: 1500
            });
            emit('closeApproveModal')
        }

    })
}
</script>

<template>
    <div id="modal">
        <div class="main">
            <section>
                <div class="details">
                    <div class="title">
                        <Message severity="success">
                            <h4>Approval Form</h4>
                        </Message>
                        <hr>
                    </div>
                    <div class="details_content">
                        <b>Details</b>
                        <hr>
                        <div class="row">
                            <div class="col-3"><b>Requested by:</b></div>
                            <div class="col">{{ approveData.first_name }} {{ approveData.middle_name }} {{
                                approveData.last_name }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Item Info:</b></div>
                            <div class="col item_details">
                                <span>{{ approveData.item_code }}</span>
                                <span>{{ approveData.category }}</span>
                                <span>{{ approveData.brand }}</span>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Schedule:</b></div>
                            <div class="col">{{ approveData.schedule_date }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Description</b></div>
                            <div class="col">{{ approveData.description }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Quantity Requested:</b></div>
                            <div class="col">{{ approveData.schedule_quantity }}x</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Remaining Quantity:</b></div>
                            <div class="col">{{ approveData.quantity }}x</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Overall Quantity</b></div>
                            <div class="col">{{ approveData.quantity - approveData.schedule_quantity }}x</div>
                        </div>


                        <hr>
                        <div class="row">
                            <div class="col">
                                <FloatLabel variant="in">
                                    <Textarea id="over_label" v-model="message" rows="5" cols="30" style="resize: none"
                                        fluid />
                                    <label for="in_label">Message</label>
                                </FloatLabel>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col form_action">
                                <Button label="Close" severity="danger" raised @click="closeModal()" />
                                <Button label="Release" severity="info" raised @click="release()" />
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
</template>
<style scoped>
#modal {
    top: 0;
    display: grid;
    place-items: center;
    position: fixed;
    height: 100%;
    width: 100%;
    background: rgba(17, 16, 16, 0.5);
    z-index: 1000;
    padding: 1rem;
    overflow-y: scroll;
}

.main {
    background: white;
    width: 100%;
    max-width: 800px; /* Responsive cap */
    padding: 1.5rem;
    border-radius: 15px;
    box-shadow: 0 0 10px rgba(0,0,0,0.2);
    box-sizing: border-box;
}

.form_action {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    flex-wrap: wrap;
}

.item_details {
    display: flex;
    flex-direction: column;
    gap: 4px;
    word-break: break-word;
}

/* Responsive stacking on small screens */
@media (max-width: 576px) {
    .row {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .col-3 {
        font-weight: bold;
    }

    .form_action {
        flex-direction: column;
        align-items: stretch;
    }

    .main {
        padding: 1rem;
    }
}

</style>