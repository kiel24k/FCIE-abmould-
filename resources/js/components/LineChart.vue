<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';


const lineChart = ref()
const lineChartResponse = ref({})

const LINE_CHART_API = async () => {
    const response = await axios.get('api/linegraph')
    lineChartResponse.value = response.data
}


onMounted(async () => {
    await LINE_CHART_API()
    new Chart(lineChart.value, {
        type: 'line',
        data: {
            labels: lineChartResponse.value.map((el) => el.item_code),
            datasets: [{
                label: 'Top 10 Stock Levels',
                data: lineChartResponse.value.map((el) => el.quantity),
                fill: true,
                borderColor: ' green',
                tension: 0.1,
                pointStyle: 'circle',
                pointRadius: 5,
                pointHoverRadius: 1
            }]
        }
    })
})
</script>
<template>
    <div class="lineChart">
        <canvas id="lineChart" ref="lineChart"></canvas>
    </div>
</template>


<style scoped>
#lineChart {
    width: 60rem;
    max-height: 20rem;
    background: white;
}
</style>
