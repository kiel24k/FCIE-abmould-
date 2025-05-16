<script setup lang="ts">
import { Button, DatePicker, FloatLabel, InputNumber, Message } from 'primevue';
import Swal from 'sweetalert2';
import { onMounted, ref } from 'vue';

const emits = defineEmits(['closeScheduleRequestModal'])
const props = defineProps(['userData', 'itemId','quantityVal'])

const minDate = ref(new Date()) // January 1, 2023
const maxDate = ref(new Date())
maxDate.value.setFullYear(maxDate.value.getFullYear() + 1)

const closeModal = () => {
    emits('closeScheduleRequestModal')
}

//COMPONENTS VARIABLE
const quantity = ref(1)
const date = ref('')
const validation = ref({})

//COMPONENTS FUNCTION
const save = async () => {
    await axios({
        method: 'POST',
        url: 'api/add-schedule',
        data: {
            user_id: props.userData.id,
            item_id: props.itemId,
            quantityVal: props.quantityVal,
            schedule_quantity: quantity.value,
            schedule_date: date.value,
        }
    }).then(response => {
        console.log(response);

        if (response.status === 200) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Schedule request has been saved",
                showConfirmButton: false,
                timer: 1500
            });
            emits('closeScheduleRequestModal')
        }
    }).catch(e => {
        validation.value = e.response.data.errors
        console.log(e);


    })
}

onMounted(() => {
    console.log(maxDate.value);
    
})

</script>

<template>
    <div id="modal">
        <div class="main p-4">
            <div class="row">
                <div class="col">
                    <h4>Request Item</h4>
                </div>
                <hr>
            </div>
            <form action="" @submit.prevent>
                <span class="text-danger validation" v-if="validation.quantity">{{ validation.quantity[0] }}</span>
                <p class="text-danger validation" v-if="validation.schedule_quantity">{{ validation.schedule_quantity[0]}}</p>
                <div class="row">
                    <div class="col quantity">
                        
                        <Button icon="pi pi-minus" @click="quantity > 1 ? quantity = quantity - 1 : 1" />
                        <FloatLabel variant="in">
                            <InputNumber inputId="in_label" fluid variant="filled" v-model="quantity" />
                            <label for="in_label">Target quantity</label>
                        </FloatLabel>
                        <Button icon="pi pi-plus" @click="quantity >= 1 ? quantity = quantity + 1 : 0" />
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col">
                        <p class="text-danger validation" v-if="validation.schedule_date">{{ validation.schedule_date[0]
                        }}</p>
                        <DatePicker showIcon fluid iconDisplay="input" placeholder="Choose Schedule" :minDate="minDate"
                            :maxDate="maxDate" v-model="date" dateFormat="yy/mm/dd" />
                    </div>
                </div>
                <div class="row ">
                    <div class="col modal_action">
                        <Button label="Close" severity="danger" @click="closeModal()" />
                        <Button label="Save" severity="info" @click="save()" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<style scoped>
#modal {
    display: grid;
    justify-content: center;
    position: fixed;
    height: 100%;
    width: 100%;
    background: rgba(17, 16, 16, 0.5);
    z-index: 1000;
    justify-content: center;
    align-items: center;
    top: 0;

}

.main {
    background: white;
    display: grid;
    box-shadow: 0px 0px 10px gray;
    border-radius: 10px;
}

.quantity {
    display: flex;
    gap: 5px;
}

.modal_action {
    display: flex;
    justify-content: end;
    gap: 5px;
    margin-top: 1rem;
}

form .validation {
    width: 18rem;
}
</style>