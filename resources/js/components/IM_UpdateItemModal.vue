<script setup>
import { onMounted, ref } from 'vue';
import Loading from '@/components/Loading.vue'
import Swal from 'sweetalert2';
import { Message } from 'primevue';


const emit = defineEmits(['closeBtn'])
const props = defineProps(['itemId', 'getItem'])
const responseData = ref({})
const loading = ref(false)

const closeBtn = () => {
    emit('closeBtn')
}

const getUpdatedItems = () => {
    loading.value = true
    axios({
        method: 'GET',
        url: `/api/IM_update-item/${props.itemId}`
    }).then(response => {
        loading.value = false
        responseData.value = response.data
    })
}

const validation = ref({})
const submit = () => {
    axios({
        method: 'POST',
        url: `/api/IM_submit-updated-item/${props.itemId}`,
        data: {
            item_code: responseData.value.item_code,
            supplier_name: responseData.value.supplier_name,
            unit_cost: responseData.value.unit_cost,
            quantity: responseData.value.quantity,
            description: responseData.value.description,
            category: responseData.value.category,
            brand: responseData.value.brand,
        }
    }).then(response => {


        if (response.status === 200) {
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your item has been update",
                showConfirmButton: false,
                timer: 1500
            });
            emit('closeBtn')
        }
    }).catch(err => {
        if (err.response.status) {
            validation.value = err.response.data.errors
        }
    })
}

onMounted(() => {
    getUpdatedItems()
})

</script>

<template>
    <div class="update-item">
        <div class="form p-5">
            <form @submit.prevent.enter enctype="multipart/form-data">
                <h4>Edit Material | <span style="color:gray;font-size:15px; font-weight:400">Enter Material
                        Information</span></h4>
                <div class="row">
                    <div class="col">
                        <label for="">Item Code: <span class="text-danger" v-if="validation.item_code">
                                {{ validation.item_code[0] }}
                            </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="responseData.item_code">
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Supplier Name: <span class="text-danger">
                                optional
                            </span></label>
                        <input type="text" class="form-control" placeholder="" v-model="responseData.supplier_name">
                    </div>
                    <div class="col">
                        <label for="">Unit Cost: <span class="text-danger" v-if="validation.unit_cost">
                                {{ validation.unit_cost[0] }}
                            </span></label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">₱</span>
                            <input type="number" class="form-control" placeholder="" v-model="responseData.unit_cost">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Quantity: <span class="text-danger" v-if="validation.quantity">
                                {{ validation.quantity[0] }}
                            </span></label>
                        <input type="number" class="form-control" placeholder="" v-model="responseData.quantity">
                    </div>
                    <div class="col">
                        <label for="">Category: <span class="text-danger" v-if="validation.category">
                                {{ validation.category[0] }}
                            </span></label>
                        <select class="form-select" v-model="responseData.category">
                            <option selected>{{ responseData.category }}</option>
                            <option value="" disabled>Select</option>
                            <option value="materials">Materials</option>
                            <option value="tools">Tools</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <span>Treshold: </span>
                        <Message>{{ responseData.treshold }}x</Message>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Description: <span class="text-danger" v-if="validation.description">
                                {{ validation.description[0] }}
                            </span></label>
                        <textarea name="" id="" cols="30" rows="10" class="form-control"
                            v-model="responseData.description"></textarea>
                    </div>
                </div>
               
                <div class="row">
                    <div class="col">
                        <button class="btn btn-danger" @click="closeBtn()">Close</button>
                    </div>
                    <div class="col text-end">
                        <button class="btn btn-success" @click.enter="submit()">Submit</button>
                    </div>
                </div>
            </form>
        </div>
        <Loading v-if="loading" />
    </div>
</template>

<style scoped>
.update-item {
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(0, 0, 0, 0.3);
    backdrop-filter: blur(5px);
    display: grid;
    place-items: center;
    padding: 1rem;
    box-sizing: border-box;
}

.form {
    width: 100%;
    max-width: 800px; /* Instead of fixed 50rem */
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    padding: 2rem;
    display: grid;
    gap: 1.5rem;
    box-sizing: border-box;
}

.row {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.col {
    flex: 1 1 100%;
}

@media (min-width: 768px) {
    .col {
        flex: 1;
    }
}

button {
    width: 100%;
    max-width: 100%;
}

@media (min-width: 576px) {
    button {
        width: auto;
    }
}

</style>
