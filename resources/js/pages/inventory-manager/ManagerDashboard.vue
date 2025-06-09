<script setup>
import { onMounted, ref } from 'vue';
import Header from '@/components/IM_Header.vue';
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
                        {{ dashboardApi.unit_cost }}
                    </div>
                    <div class="listing bg-white">
                      <div class="table_title p-1">
                        <b>top 15 newly added materials</b>
                      </div>
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
        </section>
    </div>



</template>





<style scoped>
.main{
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
.chart > div{

}
.total>div {
    width: 240px;
    height: 120px;
    background: red;
    display: flex;
    gap: 10px;
    justify-content: space-evenly;
    align-items: center;
    box-shadow: 0px 0px 2px 0px gray;
}

.total>div .content {
    display: grid;
}

.total>div .content b {
    font-size: 25px;
    color: rgb(255, 243, 219);
}

.total>div .content span {
    font-weight: 600;
    color: rgb(255, 243, 219);
    text-transform: uppercase;
}

.total>div figure i {
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

}

.computation .chart > div {
    background: white;
    border: solid 3px rgb(212, 216, 217);
    padding:5px;
    color:gray;
    border-radius: 3px;
}

.computation .chart {
    display: grid;
    gap: 10px;

}

.listing table {
    width: auto;
    border: solid 3px rgb(212, 216, 217);
    border-radius: 5px;
}

.listing table th {
    font-weight: 200px;
    color: rgb(138, 143, 148);
}
#content{
    margin-left:4rem;
}

</style>
