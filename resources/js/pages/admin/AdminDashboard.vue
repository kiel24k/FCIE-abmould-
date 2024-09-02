<template>
    <header>
        <Header />
    </header>
    <div class="analytics">
        <div class="content">
            <section>
                <div class="title">
                    <h1>Dashboard</h1>
                </div>


                <div class="chart">
                    <div class="">
                        <BarChart />
                    </div>
                    <div class="pie">
                        <Doughnut />
                    </div>
                    <div class="">
                        <LineChart />
                    </div>
                    <div class="">
                        <h1>no data pa</h1>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="text-center mt-5">
        <b>History</b>
    </div>
    <div id="table" class="table-responsive-sm-2">

        <table class="table table-hover table mt-4">
            <thead>
                <tr>
                    <th class="">
                        <div class="head-title">
                            Date

                        </div>
                    </th>
                    <th>
                        <div class="head-title">
                            Category

                        </div>
                    </th>
                    <th>
                        <div class="head-title">
                            Item Code

                        </div>
                    </th>
                    <th>
                        <div class="head-title">
                            Barcode

                        </div>
                    </th>
                    <th>
                        <div class="head-title">
                            Changed by
                        </div>
                    </th>
                    <th>
                        <div class="head-title">
                            status
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(data, index) in responseData.data" :index="index">
                    <td>{{ data.date }}</td>
                    <td>{{ data.category }}</td>
                    <td>{{ data.item_code }}</td>
                    <td>{{ data.barcode }}</td>
                    <td>{{ data.change_by_name }} </td>
                    <td>{{ data.made }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
import Header from '@/components/Admin_Header.vue'
import Doughnut from '@/components/Pie.vue'
import LineChart from "@/components/LineChart.vue";
import BarChart from '@/components/BarChart.vue';
import { onMounted, ref } from 'vue';


const responseData = ref({})
const getInHistory = () => {
    axios({
        method: 'GET',
        url: ' api/get-in-history'
    }).then(response => {
        responseData.value = response.data
        console.log(response);
    })
}

// setInterval(() => {
//     getInHistory()
// }, 2000)

onMounted(() => {
    getInHistory()
})
</script>

<style scoped>
/* laptop or pc */
@media screen and (min-width: 769px) {
    .analytics {
        display: flex;
    }

    .analytics .content {
        width: 100%;
    }

    .analytics .chart {
        display: grid;
        grid-template-columns: 50rem 30rem;

        gap: 25px;
    }

    .analytics .chart>div {
        box-shadow: 0px 0px 2px 0px gray;

        height: 25rem;
    }

    .analytics section {
        width: fit-content;
        margin: auto;
    }

    .analytics .pie {
        display: grid;
        justify-content: center;
        align-content: center;
    }

    #table {
        margin: auto;
        display: grid;
        justify-content: center;

    }

    table {
        margin: auto;
        height: auto;
        display: block;
    }

    table th {
        color: rgb(94, 93, 93);
        font-weight: 600;
        position: sticky;
        top: 0;
    }

    table td {

        border-bottom: 2px solid white;
    }

    table .head-title {
        display: flex;
        justify-content: space-between;
    }

    .action {
        display: flex;
    }

    table tbody button {
        border-radius: 5px;
        color: white;
        border: 0px;
        font-weight: 600;
    }

    .btnView {
        background: none;
    }

    .btnUpdate {
        background: none;
    }

    .btnDelete {
        background: none;
    }

    .pagination {
        display: grid;
        align-items: center;
        justify-content: center;
    }

    .pagination-action button {
        border-radius: 4px;
        background-color: black;
        color: white;
        font-weight: 550;
        width: 4rem;
        text-align: center;
    }
}

/* for small phones */
@media screen and (max-width: 1116px) {
    #table {
        margin: auto;
        max-width: 80rem;
    }

    table {
        border: solid 1px rgb(211, 208, 208);
        margin: auto;
        height: 30rem;
        overflow-x: scroll;
        overflow-y: scroll;
        display: block;
    }

    table th {
        color: rgb(94, 93, 93);
        font-weight: 600;
        border: solid 2px black;
        border-bottom: 2px solid white;
        position: sticky;
        top: 0;
    }

    table td {
        background-color: rgb(247, 243, 243);
        border: solid 2px black;
        border-bottom: 2px solid white;
    }

    table .head-title {
        display: flex;
        justify-content: space-between;
    }

    .action {
        display: flex;
    }

    table tbody button {
        border-radius: 5px;
        color: white;
        border: 0px;
        font-weight: 600;
    }

    .btnView {
        background: none;
    }

    .btnUpdate {
        background: none;
    }

    .btnDelete {
        background: none;
    }

    .pagination {
        display: grid;
        align-items: center;
        justify-content: center;
    }

    .pagination-action button {
        border-radius: 4px;
        background-color: black;
        color: white;
        font-weight: 550;
        width: 4rem;
        text-align: center;
    }
}

/* screen and tablets */
@media screen and (min-width: 601px) {}
</style>
