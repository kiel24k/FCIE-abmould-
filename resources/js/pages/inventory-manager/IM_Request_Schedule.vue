<script setup>
import Header from '@/components/IM_Header.vue'

import axios from 'axios';
import { Button, InputGroup, InputGroupAddon, InputText, Select } from 'primevue';
import { computed, onMounted, ref, watch } from 'vue';
import StatusModal from '@/components/IM_Change_Status_Modal.vue'
import html2pdf from 'html2pdf.js';

const dateCategory = ref(null);
const search = ref('')
const dateSchedule = ref([])
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
    SCHEDULE_LIST_API()
}




const SCHEDULE_LIST_API = async () => {
    const response = await axios.get('api/IM-schedule-list', {
        params: {
            category: dateCategory.value,
            search: search.value
        }
    })
    schedule.value = response.data
}


watch(dateCategory, async (oldVal, newVal) => {
    try {
        const response = await axios.get('api/IM-schedule-list',
            {
                params: {
                    category: dateCategory.value.name,
                    search: search.value
                }
            }
        )
        schedule.value = response.data

    } catch (error) {

    }
    if (dateCategory.value.name === 'all') {
        dateCategory.value = ''
    }

})

watch(search, async (oldVal, newVal) => {
    try {
        const response = await axios.get('api/IM-schedule-list',
            {
                params: {
                    category: dateCategory.value,
                    search: search.value
                }
            }
        )
        schedule.value = response.data


    } catch (error) {

    }
})

const GET_DATE_SCHEDULE_API = async () => {
    const response = await axios.get('api/IM-get-date-schedule')
    const test = response.data.map((el) => ({ name: el.date_schedule }))
    dateSchedule.value = test
}

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

const STATUS_COUNT_API = async () => {
    const response = await axios('api/status-count')
    statusCountApi.value = response.data
    console.log(response.data);
}

onMounted(() => {
    GET_DATE_SCHEDULE_API()
    SCHEDULE_LIST_API()
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
            <figure class="table-action">
                <div class="select-category">
                    <div class="flex justify-center">
                        <Select v-model="dateCategory" :options="dateSchedule" optionLabel="name"
                            placeholder="Schedule Date" checkmark />
                    </div>

                    <br>

                </div>

                <div class="search">
                    <InputGroup>
                        <InputText v-model="search" placeholder="Keyword" raised />
                        <InputGroupAddon>
                            <Button icon="pi pi-search" severity="secondary" variant="text" @click="toggle" />
                        </InputGroupAddon>
                    </InputGroup>
                </div>

                <div class="print">
                    <Button label="Print" severity="danger" icon="pi pi-file-pdf" raised @click="generatePdf" />
                </div>

            </figure>
            <figure class="table-main ">
                <table class="table table-striped table-responsive table-hover" ref="printTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Supplier Name
                                <i class="pi pi-sort-amount-down" />
                                <!-- <i class="pi pi-sort-amount-up"/> -->
                            </th>
                            <th>Item Code
                                <i class="pi pi-sort-amount-down" />
                                <!-- <i class="pi pi-sort-amount-up"/> -->
                            </th>
                            <th>Quantity
                                <i class="pi pi-sort-amount-down" />
                                <!-- <i class="pi pi-sort-amount-up"/> -->
                            </th>
                            <th>Date Schedule
                                <i class="pi pi-sort-amount-down" />
                                <!-- <i class="pi pi-sort-amount-up"/> -->
                            </th>
                            <th>Status
                                <i class="pi pi-sort-amount-down" />
                                <!-- <i class="pi pi-sort-amount-up"/> -->
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(data, index) in schedule" :key="index">
                            <td>{{ index + 1 }}</td>
                            <td>{{ data.supplier_name }}</td>
                            <td>{{ data.item_code }}</td>
                            <td>{{ data.quantity }}</td>
                            <td>{{ data.date_schedule }}</td>
                            <td>
                                <span :style="{
                                    'background-color': data.status === 'pending' ? 'rgb(253,217,216)' :
                                        data.status === 'approved' ? 'rgb(215,229,254)' :
                                            data.status === 'not-approved' ? 'rgb(252,222,192)' :
                                                data.status === 'released' ? 'rgb(198,240,219)' :
                                                    'iherit'
                                }">{{ data.status }}</span>
                            </td>
                            <td><Button @click="changeStatusBtn(data)" label="Change" icon="pi pi-wrench" rounded raised
                                    severity="info" :disabled="data.status === 'approved'" /></td>
                        </tr>
                    </tbody>
                </table>
            </figure>
        </div>
        <figcaption>
            <div class="paginate">

                <Button severity="secondary" rounded raised label="Prev" /> <span> 1 of 2</span> <Button
                    severity="secondary" rounded raised label="Next" />
            </div>

        </figcaption>

    </section>


</template>

<style scoped>
.table-main {
    overflow-y: scroll;

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
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.table-action {
    display: flex;
    gap: 10px;
}

.table-main {
    border-radius: 10px;
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
    background: rgba(165, 164, 164, 0.5);
    backdrop-filter: blur(15);
}
</style>