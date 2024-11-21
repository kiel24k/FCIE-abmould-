<template>
    <div class="lineChart">
        <canvas id="lineChart" ref="test"></canvas>
    </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

const test = ref()
const test2 = ref([65, 59, 80, 81, 56, 55, 40])

onMounted(() => {
  
    new Chart(test.value, {
        type: 'line',
        data: {
            labels:["Dsds","dsds"],
            datasets: [{
                label: 'My First Dataset',
                data: test2.value,
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
