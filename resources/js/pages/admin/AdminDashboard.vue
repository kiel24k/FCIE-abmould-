<script setup>
import { onMounted, ref } from 'vue';
import Header from '@/components/Admin_Header.vue';
import Doughnut from '@/components/Pie.vue';
import LineChart from '@/components/LineChart.vue';
import BarChart from '@/components/BarChart.vue';

const responseData = ref({});
const isSidebarHidden = ref(false);
const dashboardApi = ref({})

const DASHBOARD_COUNT_API = async () => {
    const response = await axios('api/dashboard-count')
    dashboardApi.value = response.data

}

// const getInHistory = () => {
//     axios({
//         method: 'GET',
//         url: 'api/get-in-history'
//     }).then(response => {
//         responseData.value = response.data;
//         console.log(response);
//     });
// };

// const toggleSidebar = () => {
//     isSidebarHidden.value = !isSidebarHidden.value;
// };

// onMounted(() => {
//     getInHistory();
// });

onMounted(() => {
    DASHBOARD_COUNT_API()
})
</script>

<template>
    <header>
        <Header />
    </header>

    <section >
        <div class="row m-1">
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
                            <span>items</span>
                        </div>
                    </div>

                    <div class="unit_cost_total">
                        <figure>
                            <i class="pi pi-briefcase"></i>
                        </figure>
                        <div class="content">
                            <b>P{{ dashboardApi.user }}.00</b>
                            <span>unit cost</span>
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
                        <b>Barchart</b>
                        <BarChart />
                    </div>
                </div>
                <div class="listing">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Total</th>
                                <th>q</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Bill Gates</td>
                                <td>23</td>
                                <td>34x</td>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section>



</template>





<style scoped>
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

.summary_content .title b {
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
    background: rgb(250, 84, 91);
}

.total .item_total {
    background: rgb(90, 201, 253);
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
    width: 45rem;
    border: solid 3px rgb(212, 216, 217);
    border-radius: 5px;
}

.listing table th {
    font-weight: 200px;
    color: rgb(138, 143, 148);
}
</style>
