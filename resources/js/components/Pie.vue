<template>
    <div class="pie text-center">
        <canvas id="pie" ref="piegraph"></canvas>
    </div>
</template>

<script setup>
import Chart from 'chart.js/auto';
import { onMounted, ref } from 'vue';

const pieGraphResponse = ref({})
const PIE_GRAPH_API = async () => {
    const response = await axios.get('api/piegraph')
    pieGraphResponse.value = response.data



}

const piegraph = ref()
onMounted(async () => {
    await PIE_GRAPH_API()
    new Chart(piegraph.value, {
        type: 'pie',
        data: {
            labels: pieGraphResponse.value.map((el) => el.category),
            datasets: [{
                label: 'Count',
                data: pieGraphResponse.value.map((el) => el.category_count),
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
#pie {
    width: 90rem;
    max-height: 23.5rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    padding: 20px;
    margin-top: 2rem;
}
</style>
