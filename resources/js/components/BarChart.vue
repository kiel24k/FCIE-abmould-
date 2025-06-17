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

const props = defineProps(['date_one','date_two'])

const barColor = ref([
    {bgColor: 'rgb(255, 0, 0, 0.5)'},
    {bgColor: 'rgb(255, 255, 0, 0.5)'},
    {bgColor: 'rgb(0, 0, 255,0.5)'},
    {bgColor: 'rgb(0, 128, 0,0.5)'},
    {bgColor: 'pink'},
    {bgColor: 'violet'},
    {bgColor: 'brown'},
    {bgColor: 'skyblue'},
    {bgColor: 'black'},
    {bgColor: 'red'},
])

const dataOfSumCategory = ref([])


const sumOfCategory = () => {
    axios({
        method: 'GET',
        url: '/api/bargraph',
        params: {
            date_one: date_one.value,
            date_two: date_two.value
        }
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
        label: "",
        labelColor: 'blue',
        data: dataOfSumCategory.value.map((el) => el.total_value),
        backgroundColor: barColor.value.map(el => el.bgColor),
    },
    
]
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
            position: 'top',
            display: true,
                labels: {
                    color: 'black', // Change the legend label color
                },

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
                // text: 'test'
            }
        },
        y: {
            title: {
                display: true,
                // text: 'test'
            }
        }
    }
});

const date_one = computed(() => {
    return props.date_one
})
const date_two = computed(() => {
    return props.date_two
})

watch([date_one,date_two], (oldVal, newVal) => {
    sumOfCategory()
})
onMounted(() => {
    sumOfCategory()

})
</script>

<style scoped>
@media (min-width: 1025px) {
    .bar {
        height: 320px;
    }
}

/* Tablet Styles */
@media (max-width: 1024px) and (min-width: 769px) {
    .bar {
        height: 280px;
    }
}

/* Mobile Styles */
@media (max-width: 768px) {
    .bar {
        height: 250px;
    }
}

/* Small Mobile Styles */
@media (max-width: 480px) {
    .bar {
        height: 220px;
    }
}

/* Very Small Screens */
@media (max-width: 360px) {
    .bar {
        height: 200px;
    }
}
</style>
