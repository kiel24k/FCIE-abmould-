<template>
    <header>
     <Header/>
    </header>
   <div class="analytics">
       <div class="content">
           <section>
               <div class="title">
                   <h1>Inventory Reports & Analytics</h1>
               </div>
               <div class="chart">
                   <div class="">
                       <BarGraph/>
                   </div>
                   <div class="pie">
                       <Doughnut/>
                   </div>
                   <div class=""><LineChart/></div>
                   <div class=""><h1>no data pa</h1></div>
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
import Header from '@/components/IM_Header.vue'
import BarGraph from "@/components/BarChart.vue";
import Doughnut from '@/components/Pie.vue'
import LineChart from "@/components/LineChart.vue";
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
.analytics .chart > div {
   box-shadow: 0px 0px 10px 0px gray;
   border-radius: 15px;
   height: 25rem;
}
.analytics section {
   width: fit-content;
   margin: auto;
}
.analytics .pie{
   display: grid;
   justify-content: center;
   align-content: center;
}
</style>
