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
</template>

<script setup>
import Header from '@/components/IM_Header.vue'
import BarGraph from "@/components/BarGraph.vue";
import Doughnut from '@/components/Pie.vue'
import LineChart from "@/components/LineChart.vue";



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
