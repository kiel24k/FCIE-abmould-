<script setup lang="ts">
import { Button, FloatLabel, InputText, Message, Textarea } from 'primevue';
import Swal from 'sweetalert2';
import { ref } from 'vue';



//COMPONENTS VARIABLE
const props = defineProps(['notApproveData'])
const emit = defineEmits(['closeNotApproveModal'])
const message = ref('')

//COMPONENTS FUNCTION
const closeModal = () => {
    emit('closeNotApproveModal')
}

const submitBtn = async () => {
    await axios({
        method: 'POST',
        url: '/api/not-approved-schedule',
        data: {
            schedule_id: props.notApproveData.schedule_id,
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
            emit('closeNotApproveModal')

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
                        <Message severity="error">
                            <h4>Not approval form</h4>
                        </Message>
                        <hr>
                    </div>
                    <div class="details_content">
                        <b>Details</b>
                        <hr>
                        <div class="row">
                            <div class="col-3"><b>Requested by:</b></div>
                            <div class="col">{{ notApproveData.first_name }} {{ notApproveData.middle_name }} {{
                                notApproveData.last_name }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Item Info:</b></div>
                            <div class="col item_details">
                                <span>{{ notApproveData.item_code }}</span>
                                <span>{{ notApproveData.category }}</span>
                                <span>{{ notApproveData.brand }}</span>

                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Schedule:</b></div>
                            <div class="col">{{ notApproveData.schedule_date }}</div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-3"><b>Quantity Requested:</b></div>
                            <div class="col">{{ notApproveData.schedule_quantity }}x</div>
                        </div>

                        <hr>
                        <div class="row">
                            <div class="col">
                                <FloatLabel variant="in">
                                    <Textarea id="over_label" rows="5" cols="30" style="resize: none" fluid
                                        v-model="message" />
                                    <label for="in_label">Message</label>
                                </FloatLabel>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col form_action">
                                <Button label="Close" severity="danger" raised @click="closeModal()" />
                                <Button label="Submit" severity="info" raised @click="submitBtn()" />
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
    justify-content: center;
    position: fixed;
    height: 100%;
    width: 100%;
    background: rgba(17, 16, 16, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;

}

.main {
    background: white;
    height: auto;
    width: 50rem;
    padding: 10px;
    border-radius: 15px;
}

.form_action {
    display: flex;
    gap: 10px;
    justify-content: end;
}

.item_details {
    display: grid;
}
</style>