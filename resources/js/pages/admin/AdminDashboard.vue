<template>
    <header>
        <Header @toggle-sidebar="toggleSidebar" />
    </header>
    <div class="row">
        <div :class="isSidebarHidden ? 'col-0' : 'col-2'" :key="sidebar">
            <Sidebar :class="{ hideSidebar: isSidebarHidden }" />
        </div>
        <div :class="isSidebarHidden ? 'col-12' : 'col-9'" key="content">
            <div class="analytics py-3 px-5 border-info rounded">
                <div class="content">
                    <section class="item-count">
                        <div class="text-center no-items">
                            <b>Items</b>
                           <div class="item-response">
                            <h2>{{ dashboardApi.item }}</h2>
                           </div>
                        </div>
                        <div class="text-center no-users">
                            <b>Users</b>
                            <div class="item-response">
                                <h2>{{dashboardApi.user}}</h2>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="title">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="chart">
                            <div>
                                <BarChart />
                            </div>
                            <div>
                                <LineChart />
                            </div>
                            <div class="pie">
                                <Doughnut />
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</template>


<script setup>
import { onMounted, ref } from 'vue';
import Header from '@/components/Admin_Header.vue';
import Sidebar from '@/components/Admin_Sidebar.vue';
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


<style scoped>
.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.sidebarVisible {
    transform: translateX(0);
}

.col-0 {
    width: 0;
    overflow: hidden;
    transition: width 0.5s ease;
}
.item-count{
    display: flex;
    gap:10px;
    justify-content: start;
    flex-wrap: wrap;
}
.item-count > div{
    width: 12rem;
    height: 12rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
.item-response{
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: center;
    height:10rem;
    
}
.no-items{
    background-color: red; 
    background-image: linear-gradient(to right, rgb(160, 236, 186) , rgb(91, 155, 8));
}
.no-users{
    background-color: rgb(31, 143, 187); 
    background-image: linear-gradient(to right, rgb(195, 246, 255) , rgb(10, 150, 185));
}

@media screen and (min-width: 769px) {
    .analytics {
        display: flex;
    }

    .analytics .content {
        width: 100%;
    }

    .analytics .chart {
        
        
    }

    .analytics .chart>div {
       
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
