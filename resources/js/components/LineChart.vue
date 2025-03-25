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
}


onMounted(async () => {
    await LINE_CHART_API()
    new Chart(lineChart.value, {
        type: 'line',
        data: {
            labels:lineChartResponse.value.map((el) => el.item_code),
            datasets: [{
                label: 'first 10 items newly added',
                data: lineChartResponse.value.map((el) => el.unit_cost),
                fill: true,
                borderColor: ' green',
                tension: 0.1
            }]
        }
    })
})
</script>

<style scoped>
#lineChart {
    width: 60rem;
    max-height: 20rem;
    background: white;
}
</style>
