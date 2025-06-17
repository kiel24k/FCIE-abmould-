<script setup>
import { onMounted, ref } from 'vue';
import Header from '@/components/Admin_Header.vue';
import Doughnut from '@/components/Pie.vue';
import LineChart from '@/components/LineChart.vue';
import BarChart from '@/components/BarChart.vue';
import { Button } from 'primevue';


const dashboardApi = ref({})
const tableDataDashboardData = ref({})

const DASHBOARD_COUNT_API = async () => {
    const response = await axios('api/dashboard-count')
    dashboardApi.value = {
        user: response.data.user.toLocaleString(),
        item: response.data.item.toLocaleString(),
        unit_cost: response.data.unit_cost.toLocaleString()
    }
    
    

}

const GET_TABLE_DATA_DASHBOARD_API = async () => {
    await axios({
        method: 'GET',
        url: 'api/table-data-dashboard'
    }).then(response => {
        tableDataDashboardData.value = response.data
        console.log(tableDataDashboardData.value);
        
    })
}

onMounted(() => {
    DASHBOARD_COUNT_API()
    GET_TABLE_DATA_DASHBOARD_API()
})
</script>

<template>
    <header>
        <Header />
    </header>

    <div id="content">
        <section >
            <div class="row main">
                <div class="summary_content">
                    <div class="title text-center">
                        <b>Dashboard</b>
                        <hr>
                    </div>
                    <div class="col total">
                        <div class="user_total">
                            <figure>
                                <i class="pi pi-users"></i>
                            </figure>
                            <div class="content">
                                <b>{{ dashboardApi.user }}</b>
                                <span>Users</span>
                            </div>
                        </div>
                        <div class="item_total">
                            <figure>
                                <i class="pi pi-book"></i>
                            </figure>
                            <div class="content">
                                <b>{{ dashboardApi.item }}</b>
                                <span>Items</span>
                            </div>
                        </div>
    
                        <div class="unit_cost_total">
                            <figure>
                                <i class="pi pi-briefcase"></i>
                            </figure>
                            <div class="content">
                                <b>₱{{ dashboardApi.unit_cost }}.00</b>
                                <span>total cost</span>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
        </section>
    
        <section>
            <div class="row">
                <div class="col computation">
                    <div class="chart">
                        <div class="bg-white">
                            <b>Line Chart</b>
                            <LineChart />
                        </div>
                        <div class="bg-white">
                            <b>Bar Graph</b>
                            <BarChart />
                        </div>
                    </div>
                    <div class="listing bg-white">
                      <div class="table_title p-1">
                        <b>top 15 newly added items</b>
                      </div>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Supplier</th>
                                        <th>Item code</th>
                                        <th>Quantity</th>
                                        <th>Unit Cost</th>
                                        <!-- <th>Action</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(data, index) in tableDataDashboardData">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <i v-if="data.supplier_name === null" class="pi pi-user"></i>
                                            <p v-else>{{ data.supplier_name }}</p>
                                        </td>
                                        <td>{{data.item_code}}</td>
                                        <td>{{data.quantity}}x</td>
                                        <td>₱{{data.unit_cost}}</td>
                                        <!-- <td>
                                            <Button icon="pi pi-eye" severity="info"/>
                                        </td> -->
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
    margin-top: 20px;
    margin: 10px;
}

.summary_content {
    display: grid;
    padding: 10px;
    border: solid 2px rgb(231, 224, 224);
    border-radius: 5px;
    background: white;
}

.summary_content .title b, .listing b {
    color: rgb(139, 157, 165);
    font-size: 15px;
}

.total {
    display: flex;
    justify-content: center;
    gap: 10px;
    flex-wrap: wrap;
}

.total > div {
    width: 240px;
    height: 120px;
    background: red;
    display: flex;
    gap: 10px;
    justify-content: space-evenly;
    align-items: center;
    box-shadow: 0px 0px 2px 0px gray;
    min-width: 200px;
}

.total > div .content {
    display: grid;
}

.total > div .content b {
    font-size: 25px;
    color: rgb(255, 243, 219);
}

.total > div .content span {
    font-weight: 600;
    color: rgb(255, 243, 219);
    text-transform: uppercase;
}

.total > div figure i {
    font-size: 45px;
    color: rgb(255, 243, 219);
}

.total .user_total {
    background: rgb(34, 197, 94);
}

.total .item_total {
    background: rgb(182, 178, 178);
}

.total .unit_cost_total {
    background: orange;
}

.computation {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.computation .chart {
    display: grid;
    gap: 10px;
    flex: 1;
    min-width: 300px;
}

.computation .chart > div {
    background: white;
    border: solid 3px rgb(212, 216, 217);
    padding: 5px;
    color: gray;
    border-radius: 3px;
    width: 100%;
    overflow-x: auto;
}

.listing {
    flex: 1;
    min-width: 300px;
}

.table-container {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.listing table {
    width: 100%;
    min-width: 500px;
    border: solid 3px rgb(212, 216, 217);
    border-radius: 5px;
    border-collapse: collapse;
}

.listing table th,
.listing table td {
    padding: 8px 12px;
    text-align: left;
    border-bottom: 1px solid #e0e0e0;
}

.listing table th {
    font-weight: 600;
    color: rgb(138, 143, 148);
    background-color: #f5f5f5;
}

#content {
    margin-left: 4rem;
    padding-right: 1rem;
}

/* Mobile Styles */
@media (max-width: 768px) {
    #content {
        margin-left: 1rem;
        padding-right: 1rem;
    }
    
    .main {
        margin-top: 2rem;
    }
    
    section {
        margin: 5px;
    }
    
    .total {
        justify-content: center;
        gap: 8px;
    }
    
    .total > div {
        width: 100%;
        max-width: 280px;
        height: 100px;
        gap: 8px;
    }
    
    .total > div .content b {
        font-size: 20px;
    }
    
    .total > div figure i {
        font-size: 35px;
    }
    
    .computation {
        flex-direction: column;
        gap: 15px;
    }
    
    .computation .chart,
    .listing {
        min-width: unset;
        width: 100%;
    }
    
    .listing table {
        min-width: 400px;
        font-size: 14px;
    }
    
    .listing table th,
    .listing table td {
        padding: 6px 8px;
    }
}

/* Tablet Styles */
@media (max-width: 1024px) and (min-width: 769px) {
    #content {
        margin-left: 2rem;
    }
    
    .total > div {
        width: 220px;
        height: 110px;
    }
    
    .total > div .content b {
        font-size: 22px;
    }
    
    .total > div figure i {
        font-size: 40px;
    }
    
    .computation {
        gap: 12px;
    }
}

/* Small Mobile Styles */
@media (max-width: 480px) {
    #content {
        margin-left: 0.5rem;
        padding-right: 0.5rem;
    }
    
    .summary_content {
        padding: 8px;
    }
    
    .total {
        gap: 6px;
    }
    
    .total > div {
        height: 90px;
        padding: 5px;
    }
    
    .total > div .content b {
        font-size: 18px;
    }
    
    .total > div figure i {
        font-size: 30px;
    }
    
    .listing table {
        min-width: 350px;
        font-size: 12px;
    }
    
    .listing table th,
    .listing table td {
        padding: 4px 6px;
    }
    
    .computation .chart > div {
        padding: 8px;
    }
}

/* Very Small Screens */
@media (max-width: 360px) {
    .total > div {
        height: 80px;
        min-width: 160px;
    }
    
    .total > div .content b {
        font-size: 16px;
    }
    
    .total > div figure i {
        font-size: 25px;
    }
    
    .listing table {
        min-width: 320px;
        font-size: 11px;
    }
}
</style>