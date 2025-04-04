<script setup>
import Header from '@/components/IM_Header.vue'

import axios from 'axios';
import { Button, InputGroup, InputGroupAddon, InputText, Message, Select } from 'primevue';
import { computed, onMounted, ref, watch } from 'vue';
import StatusModal from '@/components/IM_Change_Status_Modal.vue'
import html2pdf from 'html2pdf.js';


const schedule = ref({})
const statusModal = ref(false)
const statusData = ref({})
const printTable = ref(null)
const statusCountApi = ref({})

const changeStatusBtn = (data) => {
    statusData.value = data
    statusModal.value = true
}
const closeModal = () => {
    statusModal.value = false
    GET_SCHEDULE_LIST_API()
    STATUS_COUNT_API()
}

//COMPONENTS VARIABLE 
const search = ref('')
const category = ref('')
const sortName = ref('')
const sortBy = ref('ASC')
const pagination = ref({
    current_page: null,
    last_page: null
})


//API VARIABLE
const dateScheduleData = ref({})
const scheduleListData = ref({})

//API FUNCTION
const GET_DATE_SCHEDULE_CATEGORY_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/IM-get-date-schedule-category'
    }).then(response => {
        dateScheduleData.value = response.data
    })
}

const GET_SCHEDULE_LIST_API = async (page = 1) => {
    await axios({
        method: 'GET',
        url: `api/IM-schedule-list?page=${page}`,
        params: {
            category: category.value,
            search: search.value,
            sortName: sortName.value,
            sortBy: sortBy.value
        }
    }).then(response => {
        console.log(response.data);

        pagination.value = {
            current_page: response.data.current_page,
            last_page: response.data.last_page
        }
        scheduleListData.value = response.data
    })
}

const STATUS_COUNT_API = async () => {
    const response = await axios('api/status-count')
    statusCountApi.value = response.data
}

//COMPONENTS FUNCTION
const generatePdf = () => {
    const elem = printTable.value
    const options = {
        margin: 1,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
    };
    html2pdf()
        .from(elem)
        .set(options)
        .save();

}

const clear = () => {
    search.value = ""
    category.value = ""
}

const sort = (data) => {
    sortName.value = data
    if (sortBy.value === 'ASC') {
        sortBy.value = 'DESC'
    } else {
        sortBy.value = 'ASC'
    }
    GET_SCHEDULE_LIST_API()
}

const prevBtn = () => {
    if (pagination.value.last_page >= pagination.value.current_page) {
        GET_SCHEDULE_LIST_API(pagination.value.last_page - 1)
    }

}

const nextBtn = () => {
    if (pagination.value.current_page < pagination.value.last_page) {
        GET_SCHEDULE_LIST_API(pagination.value.current_page + 1)
    }

}



//hookds

watch(category, (oldVal, newVal) => {
    GET_SCHEDULE_LIST_API()
})

watch(search, (oldVal, newVal) => {
    GET_SCHEDULE_LIST_API()
})
onMounted(() => {
    GET_DATE_SCHEDULE_CATEGORY_API()
    GET_SCHEDULE_LIST_API()
    STATUS_COUNT_API()

})



</script>

<template>
    <transition name="changeStatusModal">
        <StatusModal v-if="statusModal" @closeModal="closeModal" :statusData="statusData" />
    </transition>
    <header>
        <Header />
    </header>
    <section class="mt-5">
        <Message severity="info" icon="pi pi-calendar">
            <h3>SCHEDULE REQUEST</h3>
        </Message>
    </section>
    <section>

        <article class="box">
            <div class="text-center" v-for="(data) in statusCountApi">
                <b>{{ data.status }}</b>
                <h2>{{ data.statusCount }}</h2>
            </div>
        </article>
    </section>

    <section>
        <div class="">
           
            <figure class="table-main p-3 ">
                <figure class="table-action">
                    <div class="select-category">
                        <div class="flex justify-center">
                            <Select v-model="category" :options="dateScheduleData" optionLabel="date_schedule"
                                placeholder="Date schedule" checkmark />
                        </div>
    
                        <br>
    
                    </div>
    
                    <div class="search">
                        <InputGroup>
                            <InputText v-model="search" placeholder="Keyword" raised />
                            <InputGroupAddon>
                                <Button icon="pi pi-search" severity="secondary" variant="text" @click="toggle" />
                                <Button @click="clear()" label="Clear" severity="secondary" icon="pi pi-eraser" raised
                                    v-if="search || category" />
                            </InputGroupAddon>
                        </InputGroup>
                    </div>
                    <div class="print">
                        <Button label="Print" severity="danger" icon="pi pi-file-pdf" raised @click="generatePdf" />
                    </div>
    
                </figure>

                <table class="table table-bordered table-responsive table-hover" ref="printTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th @click="sort('supplier_name')">Supplier Name
                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'DESC'" />
                                <i class="pi pi-sort-amount-up" v-else />
                            </th>
                            <th @click="sort('item_code')">Item Code
                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'DESC'" />
                                <i class="pi pi-sort-amount-up" v-else />
                            </th>
                            <th @click="sort('quantity')">Quantity
                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'DESC'" />
                                <i class="pi pi-sort-amount-up" v-else />
                            </th>

                            <th @click="sort('status')">Status
                                <i class="pi pi-sort-amount-down-alt" v-if="sortBy === 'DESC'" />
                                <i class="pi pi-sort-amount-up" v-else />
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in scheduleListData.data" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ data.supplier_name }}</td>
                            <td>{{ data.item_code }}</td>
                            <td>{{ data.quantity }}x</td>
                            <td>
                                <span :style="{
                                    'background-color': data.status === 'pending' ? 'rgb(253,217,216)' :
                                        data.status === 'approved' ? 'rgb(215,229,254)' :
                                            data.status === 'not-approved' ? 'rgb(252,222,192)' :
                                                data.status === 'released' ? 'rgb(198,240,219)' :
                                                    'iherit'
                                }">{{ data.status }}</span>
                            </td>
                            <td><Button @click="changeStatusBtn(data)" label="Change" icon="pi pi-wrench" raised
                                    severity="info" :disabled="data.status === 'approved'" /></td>
                        </tr>
                    </tbody>
                </table>
                <figcaption>
                    <div class="paginate">

                        <Button severity="contrast" variant="text" label="Prev" icon="pi pi-chevron-left"
                            @click="prevBtn()" /> <span> {{ pagination.current_page }} of {{ pagination.last_page
                            }}</span>
                        <Button severity="contrast" variant="text" iconPos="right" label="Next"
                            icon="pi pi-chevron-right" @click="nextBtn()" />
                    </div>

                </figcaption>

            </figure>
        </div>

    </section>


</template>

<style scoped>
.table-main {
    overflow-y: auto;

}

section {
    width: 75%;
    margin: auto;
    padding: 10px;

}

.box {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;

}

.box>div {
    width: 12rem;
    height: 12rem;
    border-radius: 5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.table-action {
    display: flex;
    gap: 10px;
}

.table-main {
    border-radius: 5px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.paginate {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.changeStatusModal-leave-active {
    transition: all 0.1s cubic-bezier(1, 0.5, 0.8, 1);
}

.changeStatusModal-leave-to {
    transform: translateY(20px);
    opacity: 0;
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

td {
    text-align: start;
    vertical-align: middle;
}

td span {
    padding: 8px;
    border-radius: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(126, 126, 126, 0.2);
    font-weight: 600;
    text-transform: capitalize;
}

table th {

    backdrop-filter: blur(15);
}
</style>