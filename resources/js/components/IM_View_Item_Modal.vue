<script setup>
import { onMounted, ref } from 'vue';
import Loading from '@/components/Loading.vue'
import Swal from 'sweetalert2';
import { Message } from 'primevue';


const emit = defineEmits(['closeViewModal'])
const props = defineProps(['itemId', 'getItem'])
const responseData = ref({})
const loading = ref(false)

const closeBtn = () => {
    emit('closeViewModal')
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


onMounted(() => {
    getUpdatedItems()
})

</script>

<template>
    <div class="update-item">
        <div class="form p-5">
                <h4>Materials | <span style="color:gray;font-size:15px; font-weight:400">View materials</span></h4>
                <div class="row">
                    <div class="col">
                        <label for="">Item Code:</label>
                        <Message severity="info">
                            {{ responseData.item_code }}
                        </Message>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Supplier Name:</label>
                        <Message severity="info" icon="pi pi-user">
                            {{ responseData.supplier_name }}
                        </Message>
                    </div>
                    <div class="col">
                        <label for="">Unit Cost:</label>
                            <Message severity="info" icon="pi pi-credit-card">
                                {{ responseData.unit_cost }}
                            </Message>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Quantity:</label>
                        <Message severity="info" icon="pi pi-hashtag">
                            {{ responseData.quantity }}x
                        </Message>
                    </div>
                    <div class="col">
                        <label for="">Category:</label>
                       <Message severity="info" icon="pi pi-list">
                        {{ responseData.category }}
                       </Message>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Brand:</label>
                        <Message severity="info" icon="pi pi-hammer">
                            {{ responseData.brand }}
                        </Message>
                    </div>
                    <div class="col">
                        <label for="">Release date</label>
                            <Message severity="info" icon="pi pi-calendar">
                                {{ responseData.release_date }}
                            </Message>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="">Description:</label>
                       <Message severity="info" icon="pi pi-pencil">
                        {{ responseData.description }}
                       </Message>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-end mt-3">
                        <button class="btn btn-danger" @click="closeBtn()">Close</button>
                    </div>
                </div>
        </div>
        <Loading v-if="loading" />
    </div>
</template>

<style scoped>
.update-item {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    z-index: 999;
    background: rgb(0, 0, 0, 0.3);
    backdrop-filter: blur(5px);
    display: grid;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

.form {
    border-radius: 15px;
    background: rgb(255, 255, 255);
    box-shadow: 0px 0px 15px 0px gray;
    width: 50rem;
    margin: auto;
    display: grid;
    gap: 25px;
    border-radius: 10px;
    padding: 10px;
}
</style>
