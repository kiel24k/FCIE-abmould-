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


const dataOfSumCategory = ref([])


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
    labels: dataOfSumCategory.value.map((el) => el.category),
    datasets: [{
        label: 'consumed of recent used materials',
        data: dataOfSumCategory.value.map((el) => el.quantity),
        backgroundColor: ['rgb(218, 71, 69)'],
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


onMounted(() => {

    sumOfCategory()

})
</script>

<style scoped>
.bar {
    width: 60rem;
    max-height: 30rem;
    border-radius: 5px;
    background: white;
}
</style>
