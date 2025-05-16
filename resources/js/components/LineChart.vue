<script setup>
import Chart from 'chart.js/auto';
import { computed, onMounted, ref, watch } from 'vue';
import axios from 'axios'; // Added missing axios import

const lineChart = ref(null);
const lineChartResponse = ref({});
const props = defineProps(['date_one', 'date_two']);

// Create local reactive refs that reference the props
const date_one = ref(props.date_one);
const date_two = ref(props.date_two);

// Update local refs when props change
watch(() => props.date_one, (newVal) => {
  date_one.value = newVal;
}, { immediate: true });

watch(() => props.date_two, (newVal) => {
  date_two.value = newVal;
}, { immediate: true });

const LINE_CHART_API = async () => {
    try {
        const response = await axios.get('api/linegraph', {
            params: {
                date_one: date_one.value,
                date_two: date_two.value
            }
        });
        if (response.status === 200) {
            lineChartResponse.value = response.data;
            chart();
        }
    } catch (error) {
        console.error('Error fetching chart data:', error);
    }
};

let chartInstance = null;

const chart = () => {
  if (chartInstance) {
    chartInstance.destroy();
  }

  chartInstance = new Chart(lineChart.value, {
    type: 'line',
    data: {
      labels: lineChartResponse.value.map(el => el.item_code),
      datasets: [{
        label: "",
        data: lineChartResponse.value.map(el => el.quantity),
        fill: true,
        borderColor: 'green',
        tension: 0.1,
        pointStyle: 'circle',
        pointRadius: 5,
        pointHoverRadius: 1
      }]
    }
  });
};

// Watch for changes in the date values
watch(
  [date_one, date_two],
  ([newDateOne, newDateTwo], [oldDateOne, oldDateTwo]) => {
    console.log('Dates changed, fetching new data');
    LINE_CHART_API();
  }
);

onMounted(() => {
    LINE_CHART_API();
});
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