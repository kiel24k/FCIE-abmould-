<template>
    <div class="pie">
            <canvas id="pie"></canvas>
    </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';

onMounted(() => {
    const pie = document.getElementById("pie");
    new Chart(pie,{
        type:'pie',
        data: {
            labels: [
    'Red',
    'Blue',
    'Yellow'
  ],
  datasets: [{
    label: 'My First Dataset',
    data: [300, 50, 100],
    backgroundColor: [
      'rgb(255, 99, 132)',
      'rgb(54, 162, 235)',
      'rgb(255, 205, 86)'
    ],
    hoverOffset: 4
  }]
        }
    })
})
</script>

<style scoped>
.pie{
    height: rem;
    
}
</style>
