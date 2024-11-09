<template>
    <div>
        <Bar :data="chartData" :options="chartOptions" class="bar" />
    </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);


const dataOfSumCategory = ref({})
const sumOfCategory = () => {
    axios({
        method: 'GET',
        url: '/api/bargraph'
    }).then(response => {
        dataOfSumCategory.value = response.data
        // chartData.value.datasets[0].data[1] = 30
        // console.log( chartData.value.datasets[0].data);
        // console.log(dataOfSumCategory.value.materials);

    })
}


const chartData = computed(() => ({
    labels: [
        "Tools",
        "Materials"
    ],
    datasets: [{
        label: 'consumed of recent used materials',
        data: [dataOfSumCategory.value.tools, dataOfSumCategory.value.materials],
        backgroundColor: ['skyblue'],
    },],
    fill: false,
}));

// const chartData = ref({
//     labels: ['tools', 'materials'],
//     datasets: [{
//
//         backgroundColor: ['green', 'yellow'],
//         data: [20, 10],
//         fill: false,
//     }]
// });


const chartOptions = ref({
    responsive: true,
    plugins: {
        legend: {
            position: 'top'
        },
        tooltip: {
            callbacks: {
                label: function (tooltipItem) {
                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                }
            }
        }
    },
    scales: {
        x: {
            title: {
                display: true,
                text: 'test'
            }
        },
        y: {
            title: {
                display: true,
                text: 'test'
            }
        }
    }
});

watch(chartData, (oldVal, NewVal) => {
    console.log("dsds");
})
onMounted(() => {

    sumOfCategory()

})
</script>

<style scoped>
.bar {
    width: 90rem;
    max-height: 30rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
</style>
