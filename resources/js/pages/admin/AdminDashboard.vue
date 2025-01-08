<template>
    <header>
        <Header />
    </header>
    <div class="row">
        <div>
            <Sidebar :class="{ hideSidebar: isSidebarHidden }" />
        </div>
        <div class="content">
            <div class="analytics py-3 pl-5 border-info rounded">
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
                                <h2>{{ dashboardApi.user }}</h2>
                            </div>
                        </div>
                    </section>
                    <section>
                        <div class="title">
                            <h1>Dashboard</h1>
                        </div>
                        <div class="">
                            <div class="parent">
                                <div class="div1">
                                    <Doughnut />
                                </div>
                                <div class="div2">
                                    <LineChart />
                                </div>
                                <div class="div3">
                                    <BarChart />
                                </div>
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
@media screen and (max-width: 1116px) {}

@media screen and (max-width: 768px) {}

@media screen and (min-width: 601px) {}

.content {
    padding-left: 8rem;
}

.hideSidebar {
    transform: translateX(-100%);
    transition: transform 0.5s ease;
}

.sidebarVisible {
    transform: translateX(0);
}

.item-count {
    display: flex;
    gap: 10px;
    justify-content: center;
    flex-wrap: wrap;
}

.item-count>div {
    width: 12rem;
    height: 12rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.item-response {
    display: grid;
    justify-content: center;
    align-items: center;
    align-content: center;
    height: 10rem;

}

.no-items {
    background-color: red;
    background-image: linear-gradient(to right, rgb(160, 236, 186), rgb(91, 155, 8));
}

.no-users {
    background-color: rgb(31, 143, 187);
    background-image: linear-gradient(to right, rgb(195, 246, 255), rgb(10, 150, 185));
}

.div1, .div2, .div3{
    padding: 10px;
}
.parent {
display: grid;
grid-template-columns: repeat(5, 1fr);
grid-template-rows: repeat(2, 1.5fr) repeat(2, 2fr);
grid-column-gap: 0px;
grid-row-gap: 0px;
}
.div1 { grid-area: 1 / 1 / 3 / 3; }
.div2 { grid-area: 1 / 3 / 3 / 6; }
.div3 { grid-area: 3 / 1 / 5 / 6; }

@media screen and (min-width: 769px) {
    .analytics {
        display: flex;
    }

    .analytics .content {
        width: 100%;
    }

    .analytics section {
        margin: auto;
    }

    .analytics .pie {
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
