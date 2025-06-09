<script setup>
import Header from "@/components/Admin_Header.vue"
import BarChart from "../../components/BarChart.vue";
import LineChart from "../../components/LineChart.vue";
import { Button, DatePicker, Message, Select } from "primevue";
import { ref, watch } from "vue";
import html2pdf from 'html2pdf.js';

//COMPONENTS VARIABLES
const selectType = ref([
    { name: 'Analytics' },
    { name: 'Item List' },
    { name: 'User List' }
])

const printBargraphContent = ref(null)
const printLineChartContent = ref(null)
const printItemListContent = ref(null)

const date_one = ref(null)
const date_two = ref(null)



//API VARIABLES
const printItemListData = ref({})
const printUserListData = ref({})

//COMPONENTS FUNCTION 
const printBargraph = () => {
    const elem = printBargraphContent.value
    const options = {
        margin: 1,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, allowTaint: false },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' },
    };
    html2pdf()
        .from(elem)
        .set(options)
        .save();
}

const printLineChart = () => {
    const elem = printLineChartContent.value
    const options = {
        margin: 1,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, allowTaint: false },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' },
    };
    html2pdf()
        .from(elem)
        .set(options)
        .save();
}

const printItemList = () => {
    const elem = printItemListContent.value
    const options = {
        margin: 1,
        filename: 'document.pdf',
        image: { type: 'jpeg', quality: 0.98 },
        html2canvas: { scale: 2, useCORS: true, allowTaint: false },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' },
    };
    html2pdf()
        .from(elem)
        .set(options)
        .save();
}



//API FUNCTIONS
const GET_PRINT_ITEM_LIST_API = async () => {
    await axios({
        method: 'GET',
        url: '/api/print-item-list',
        params : {
            date_one:date_one.value,
            date_two: date_two.value
        }
    }).then(response => {
        console.log(response);
        
        printItemListData.value = response.data
    })
}
const GET_PRINT_USER_LIST_API = async () => {
    await axios({
        method: 'GET',
        url: '/api/print-user-list',
        params: {
             date_one:date_one.value,
            date_two: date_two.value
        }
    }).then(response => {
        printUserListData.value = response.data
    })

}

const clear = () => {
    date_one.value = null
    date_two.value = null
     GET_PRINT_ITEM_LIST_API()
    GET_PRINT_USER_LIST_API()
}



// HOOKS

watch(date_one,(oldVal,newVal) => {
    GET_PRINT_ITEM_LIST_API()
    GET_PRINT_USER_LIST_API()
})
watch(date_two,(oldVal,newVal) => {
    GET_PRINT_ITEM_LIST_API()
    GET_PRINT_USER_LIST_API()
})

GET_PRINT_ITEM_LIST_API()
GET_PRINT_USER_LIST_API()
</script>

<template>
    <header>
        <Header />
    </header>
    <div class="main">
        <section>
            <div class="print_category">
                <DatePicker placeholder="Enter date" v-model="date_one" dateFormat="yy-mm-dd" /> to
                <DatePicker v-model="date_two" placeholder="Enter date" dateFormat="yy-mm-dd" variant="filled" /> <Button @click="clear"
                    label="clear" severity="secondary" variant="outlined" />
            </div>
            <div class="content mt-3">
                <div class="analytics">

                    <div class="chart">
                        <div class="bargraph">
                            <Message variant="simple" severity="secondary">
                                <Button label="Print Bar Graph" icon="pi pi-print" severity="contrast"
                                    @click="printBargraph()" class="m-1" />
                            </Message>
                            <div class="bargraph_content" ref="printBargraphContent">
                                <div class="modal_header">
                                    <figure>
                                        <img src="/public/background/abMouldLogo.png" alt="">
                                        <figcaption>
                                            <b>Unit C Lot 9, Block 7, First Cavite Industrial Estate (FCIE)</b>
                                            <b>Dasmarinas, Cavite, 4114 Philippines</b>
                                        </figcaption>
                                    </figure>
                                </div>
                                 <div class="title text-center">
                                    <b>Top 10 most-used categories</b>
                                </div>
                                <BarChart :date_one="date_one" :date_two="date_two" />
                            </div>
                        </div>
                        <div class="linechart">
                            <Message variant="simple" severity="secondary">
                                <Button label="Print Line Chart" icon="pi pi-print" severity="contrast"
                                    @click="printLineChart()" class="m-1" />
                            </Message>
                            <div class="linechart_content" ref="printLineChartContent">
                                <div class="modal_header">
                                    <figure>
                                        <img src="/public/background/abMouldLogo.png" alt="">
                                        <figcaption>
                                            <b>Unit C Lot 9, Block 7, First Cavite Industrial Estate (FCIE)</b>
                                            <b>Dasmarinas, Cavite, 4114 Philippines</b>
                                        </figcaption>
                                    </figure>
                                </div>
                                   <div class="title text-center">
                                    <b>Top 10 Stock levels</b>
                                </div>
                                <LineChart :date_one="date_one" :date_two="date_two" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tables mt-3">
                    <div class="list_table">
                        <Message variant="simple" severity="secondary">
                            <Button label="Print Item List" icon="pi pi-print" severity="contrast"
                                @click="printItemList()" />
                        </Message>
                        <div class="table_content" ref="printItemListContent">
                            <div class="modal_header">
                                <figure>
                                    <img src="/public/background/abMouldLogo.png" alt="">
                                    <figcaption>
                                        <b>Unit C Lot 9, Block 7, First Cavite Industrial Estate (FCIE)</b>
                                        <b>Dasmarinas, Cavite, 4114 Philippines</b>
                                    </figcaption>
                                </figure>
                            </div>
                            <div class="title text-center">
                                <h4>ITEM LIST</h4>
                            </div>
                            <table class="table mt-2">
                                <thead>
                                    <tr>
                                        <th>Item code</th>
                                        <th>Supplier name</th>
                                        <th>Unit cost</th>
                                        <th>Quantity</th>
                                        <th>Treshold</th>
                                        <th>Category</th>
                                        <th>Brand</th>
                                        <th>Release date</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="data in printItemListData">
                                        <td>{{ data.item_code }}</td>
                                        <td>{{ data.supplier_name }}</td>
                                        <td>{{ data.unit_cost }}</td>
                                        <td>{{ data.quantity }}x</td>
                                        <td>{{ data.treshold }}</td>
                                        <td>{{ data.category }}</td>
                                        <td>{{ data.brand }}</td>
                                        <td>{{ data.release_date }}</td>
                                        <td>{{ data.description }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="list_table">
                        <Message variant="simple" severity="secondary">
                            <Button label="Print User List" icon="pi pi-print" severity="contrast" @click="print()" />
                        </Message>
                        <div class="table_content">
                            <div class="modal_header">
                                <figure>
                                    <img src="/public/background/abMouldLogo.png" alt="">
                                    <figcaption>
                                        <b>Unit C Lot 9, Block 7, First Cavite Industrial Estate (FCIE)</b>
                                        <b>Dasmarinas, Cavite, 4114 Philippines</b>
                                    </figcaption>
                                </figure>
                            </div>
                             <div class="title text-center">
                                <h4>USER LIST</h4>
                            </div>
                            <table class="table mt-2">
                                <thead>
                                    <tr>
                                        <th>First name</th>
                                        <th>Middle name</th>
                                        <th>Last name</th>
                                        <th>Role</th>
                                        <th>Email</th>
                                        <th>Tel no.</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="data in printUserListData">
                                        <td>{{ data.first_name }}</td>
                                        <td>{{ data.middle_name }}</td>
                                        <td>{{ data.last_name }}</td>
                                        <td>{{ data.role }}x</td>
                                        <td>{{ data.email }}</td>
                                        <td>{{ data.tel_no }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.main {
    margin-top: 5rem;
}

section {
    margin-left: 3.5rem;
}

.print_category {
    margin-left: 1rem;
}

.chart {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 10px;

}

.chart>div {
    width: 51rem;
    box-shadow: 0px 0px 5px gray;
    background: white;
}

table {
    width: 100%;
    table-layout: fixed;
    word-wrap: break-word;
    border-collapse: collapse;
}

td,
th {
    padding: 8px;
    border: 1px solid #ccc;
    font-size: 12px;
    /* Reduce size to help fit */
}

tr {
    page-break-inside: avoid !important;
}

.tables {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
}

.tables>div {
    width: 51rem;
    display: grid;
    box-shadow: 0px 0px 10px gray;
    padding: 5px;
    background: white;
    align-content: start;

}

figure {
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: center;
}

figure img {
    width: 90%;
    height: 90%;
}

figcaption {
    display: grid;
    text-align: center;
}
</style>