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
                 
                   <div class="">
                    <LineChart/>
                </div>
                   <div class="pie">
                    <Doughnut/>
                </div>
               </div>
           </section>
       </div>
   </div>
   <div class="text-center mt-5">
    <b>History</b>
</div>
<div id="table" class="table-responsive-sm-2">
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
section .chart{
    width: 100rem;
}


.analytics section {
   width: fit-content;
   margin: auto;
   display: grid;
}

</style>
