<template>
    <div class="lineChart">
        <canvas id="lineChart"></canvas>
    </div>
</template>

<script setup>
import Chart  from 'chart.js/auto';
import { onMounted } from 'vue';

onMounted(() => {
    const lineChart = document.getElementById("lineChart")
    new Chart(lineChart, {
        type:'line',
        data: {
            labels: "hahaha",
  datasets: [{
    label: 'My First Dataset',
    data: [65, 59, 80, 81, 56, 55, 40],
    fill: false,
    borderColor: 'rgb(75, 192, 192)',
    tension: 0.1
  }]
        }
    })
})
</script>

<style scoped>

</style>
