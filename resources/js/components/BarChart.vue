<template>
    <div>
        <Bar :data="chartData" :options="chartOptions" class="bar" />
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { Bar } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js';
ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

// Reactive variable to store the processed data
const summedCategories = ref([]);

// Function to fetch and process data
const sumOfCategory = async () => {
    try {
        const response = await axios.get('/api/bargraph');
        const rawData = response.data;

        // Group and sum quantities by category
        const categorySums = rawData.reduce((acc, item) => {
            if (!acc[item.category]) {
                acc[item.category] = 0;
            }
            acc[item.category] += item.quantity;
            return acc;
        }, {});

        // Convert the grouped data back to an array for the chart
        summedCategories.value = Object.entries(categorySums).map(([category, quantity]) => ({
            category,
            quantity,
        }));
    } catch (error) {
        console.error('Error fetching data:', error);
    }
};

// Chart data
const chartData = computed(() => ({
    labels: summedCategories.value.map((el) => el.category),
    datasets: [
        {
            label: 'Consumed of Recent Used Materials',
            data: summedCategories.value.map((el) => el.quantity),
            backgroundColor: 'skyblue',
        },
    ],
}));

// Chart options
const chartOptions = ref({
    responsive: true,
    plugins: {
        legend: {
            position: 'top',
        },
        tooltip: {
            callbacks: {
                label: function (tooltipItem) {
                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                },
            },
        },
    },
    scales: {
        x: {
            title: {
                display: true,
                text: 'Categories',
            },
        },
        y: {
            title: {
                display: true,
                text: 'Quantity',
            },
        },
    },
});

// Fetch data on mount
onMounted(() => {
    sumOfCategory();
});
</script>

<style scoped>
.bar {
    width: 90rem;
    max-height: 30rem;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}
</style>
