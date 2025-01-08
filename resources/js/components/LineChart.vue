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
    width: 20rem; /* Set a fixed width */
    height: 20rem; /* Match the height to the width */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    margin-top: 2rem;
}
</style>
