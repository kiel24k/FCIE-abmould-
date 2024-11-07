<template>
    <div class="out-modal">
        <div class="card">
            <div class="card-header">
                <h4>Edit Quantity</h4>
               
            </div>
            <div class="card-body">
                <div class="item">
                    <div class="row">
                        <div class="col">
                            <h4>{{ itemsResponseData.item_code }}</h4>
                        </div>
                        <div class="col text-end">
                            <h4>{{ itemsResponseData.unit_cost }}</h4>
                        </div>
                    </div>
                    <div class="row">
                        <b>Category</b>
                        <p>{{ itemsResponseData.category }}</p>
                    </div>
                    <div class="row">
                        <b>Description:</b>
                        <p>
                            {{itemsResponseData.description}}
                        </p>
                    </div>
                    <div class="row">
                        <b>Supplier Name</b>
                        <small>{{ itemsResponseData.supplier_name }}</small>
                    </div>
                    <div class="row">
                        <label for=""><b>Current Quantity:</b></label>
                        <h5>x{{ itemsResponseData.quantity }}</h5>
                    </div>
                    <form action="" @submit.prevent>
                        <div class="row">
                            <div class="col">
                                <label for=""><b>Reduce Quantity: </b></label> <span class="text-danger" v-if="outputValidation"><b>Warning: </b>{{ outputValidation }}</span>
                                <input type="number" min="0" class="form-control mt-2" v-model="reduceQuantity">
                            </div>
                        </div>
                        <div class="row" v-if="finalOutput">
                            <label for=""><b>Quantity Output: </b></label>
                            <h5>x{{ finalOutput }}</h5>
                        </div>
                        <div class="row mt-4">
                            <div class="col text-end" style="display:flex; justify-content:end;gap:10px;">
                                <button class="btn btn-danger" @click="exit">Close</button>
                                <button class="btn btn-dark" @click="submit(itemsResponseData.id)">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref, watch } from 'vue';

const dateValue = ref()
const props = defineProps(['reduceItemId'])
const itemsResponseData = ref({})
const userData = ref()
const items = () => {
    axios({
        method: 'GET',
        url: `/api/edit-quantity/1`
    }).then(response => {
        itemsResponseData.value = response.data
        console.log(response.data);
        let isoDate = itemsResponseData.value.created_at;
        let dateData = new Date(isoDate);
        const month = dateData.getUTCMonth() + 1
        const day = dateData.getUTCDate()
        const year = dateData.getUTCFullYear()
        const formatYear = year.toString().slice(-2);
        const formatDay = day.toString().padStart(2, '0')
        const formatMonth = month.toString().padStart(2, '0')
        dateValue.value = `${formatYear}/${formatMonth}/${formatDay}`

    })
}

const reduceQuantity = ref()
const finalOutput = ref()
const outputValidation = ref('')
watch(reduceQuantity, (oldVal, newVal) => {
    finalOutput.value = itemsResponseData.value.quantity - reduceQuantity.value
    if (finalOutput.value < 0) {
        outputValidation.value = "You've got a lot of reduced"
        finalOutput.value = 1
    } else if (finalOutput.value > 0) {
        outputValidation.value = ''
    }
})

const submit = async (id) => {
    await axios({
        method: 'POST',
        url: `/api/reduce-quantity-submit/${id}`,
        data: {
            quantity: finalOutput.value
        }
    }).then(response => {
        emit('exit')
    })
    await axios({
        method: 'POST',
        url: 'api/create-out-history',
        data: {
            date: dateValue.value,
            category: itemsResponseData.value.category,
            item_code: itemsResponseData.value.item_code,
            barcode: itemsResponseData.value.barcode,
            change_by_name: userData.value.first_name,
            made: 'Deleted'
        }
    }).then(response => {
        console.log(response);
        
    })
}

const getUser = () => {
    axios({
        method: 'GET',
        url: 'api/user'
    }).then(response => {
        userData.value = response.data
        
    })
}

const emit = defineEmits(['exit'])
const exit = () => {
    emit('exit')
}

onMounted(() => {
    items()
    getUser()
})
</script>

<style scoped>
.out-modal {
    position: absolute;
    display: grid;
    justify-content: center;
    align-items: center;
    background-color: rgb(221, 216, 216, 0.5);
    backdrop-filter: blur(15px);
    height: 100%;
    width: 100%;
}

.item {
    width: 40rem;
    background: rgb(255, 255, 255);
    height: auto;
    overflow: scroll;
    overflow-x: hidden;
    box-shadow: 0px 0px 5px 0px black;
    padding: 10px;
    border-radius: 5px;
}

.item::-webkit-scrollbar {
    width: 5px;
    height: 25px;
}

.item::-webkit-scrollbar-track {
    border-radius: 15px;
    background: rgb(192, 191, 191);
}

.item::-webkit-scrollbar-thumb {
    border-radius: 10px;
    -webkit-box-shadow: inset 0 0 6px rgba(26, 25, 25, 0.5);
}

.item h4 {
    color: rgb(72, 128, 231);
    font-weight: 600;
}

.title {
    display: flex;
    justify-content: space-between;
}

.card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}
</style>
