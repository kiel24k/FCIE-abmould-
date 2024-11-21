<template>
    <div class="lineChart">
        <canvas id="lineChart" ref="lineChart"></canvas>
    </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';


const lineChart = ref()
const lineChartResponse = ref({})

const LINE_CHART_API = async() => {
    const response = await axios.get('api/linegraph')
   lineChartResponse.value = response.data
   console.log(lineChartResponse.value);
   
    
}
const test2 = ref([65, 59, 80, 81, 56, 55, 40])

onMounted(async () => {
    await LINE_CHART_API()
    new Chart(lineChart.value, {
        type: 'line',
        data: {
            labels:lineChartResponse.value.map((el) => el.item_code),
            datasets: [{
                label: 'My First Dataset',
                data: lineChartResponse.value.map((el) => el.unit_cost),
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    })
})
</script>

<style scoped>
#lineChart {
    width: 100%;
    max-height: 30rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    margin-top: 2rem;
    
}
</style>
