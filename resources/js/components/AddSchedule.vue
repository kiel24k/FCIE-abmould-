<template>
    <transition name="transition">
        <div class="add-schedule">
            <div>
                <form @submit.prevent enctype="multipart/form-data">
                    <h4>
                        Schedule |
                        <span style="color:gray; font-size:15px; font-weight:400">
                            Schedule Information
                        </span>
                    </h4>

                    <!-- Scrollable Item List -->
                    <div class="item-list">
                        <div class="row mb-3" v-for="(item, index) in input.items" :key="index">
                            <div class="col">
                                <label for="">
                                    Item Name:
                                    <span class="text-danger" v-if="validation.items?.[index]?.item_code">
                                        {{ validation.items[index].item_code[0] }}
                                    </span>
                                </label>
                                <input type="text" class="form-control" placeholder="" v-model="item.item_code" />
                            </div>
                            <div class="col">
                                <label for="">
                                    Quantity:
                                    <span class="text-danger" v-if="validation.items?.[index]?.quantity">
                                        {{ validation.items[index].quantity[0] }}
                                    </span>
                                </label>
                                <input type="number" class="form-control" placeholder="" v-model="item.quantity" />
                            </div>
                            <div class="col-auto d-flex align-items-end">
                                <button type="button" class="btn btn-danger" @click="removeItem(index)">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Add Item Button -->
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn btn-primary" @click="addItem">
                                Add Item
                            </button>
                        </div>
                    </div>
                    <!-- Date Field -->
                    <div class="row mb-3">
                        <div class="col">
                            <label for="">
                                Date:
                                <span class="text-danger" v-if="validation.date_schedule">
                                    {{ validation.date_schedule[0] }}
                                </span>
                            </label>
                            <input type="date" data-date-format="YYYY-MM-DD" v-model="input.date_schedule"
                                class="form-control" />
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row">
                        <div class="col text-end">
                            <button class="btn btn-danger m-2" @click="closeModal">Close</button>
                            <button class="btn btn-success m-2" @click="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </transition>
</template>

<script setup>
import { ref } from 'vue';

// Initialize input and validation
const input = ref({
    date_schedule: '',
    items: [{ item_code: '', quantity: '' }],
});
const validation = ref({});

// Add Item Function
const addItem = () => {
    input.value.items.push({ item_code: '', quantity: '' });
};

// Remove Item Function
const removeItem = (index) => {
    input.value.items.splice(index, 1);
};

// Submit Function
const submit = () => {
    axios({
        method: 'POST',
        url: '/api/add-schedule',
        data: {
            date_schedule: input.value.date_schedule,
            items: input.value.items,
        },
    })
        .then((response) => {
            if (response.status === 200) {
                modal('data');
            }
        })
        .catch((err) => {
            console.log(err);
            if (err.response.status) {
                validation.value = err.response.data.errors;
            }
        });
};

// Modal and Close Functions
const modal = defineEmits(['data']);
const closeModal = () => {
    modal('data');
};
</script>

<style scoped>
.add-schedule {
    position: absolute;
    width: 100%;
    height: 100%;
    display: grid;
    justify-content: center;
    align-content: center;
    background: rgba(248, 246, 246, 0.9);
    z-index: 999;
    margin: auto;
}

form {
    width: 70rem;
    margin: auto;
    display: grid;
    gap: 25px;
    background: #ffffff;
    border-radius: 10px;
    padding: 10px;
}

.item-list {
    max-height: 15rem;
    /* Adjust height to accommodate 3 rows */
    overflow-y: auto;
    overflow-x: hidden;
    border: 1px solid #ccc;
    /* Optional: to visually separate the list */
    border-radius: 5px;
    /* Optional: to match form design */
    padding: 10px;
    /* Optional: for inner spacing */
}
</style>
