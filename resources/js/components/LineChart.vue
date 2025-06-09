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
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        x: {
          responsive: true,
          ticks: {
            maxRotation: 45,
            minRotation: 0
          }
        },
        y: {
          responsive: true,
          beginAtZero: true
        }
      },
      plugins: {
        legend: {
          display: false
        }
      },
      elements: {
        point: {
          radius: function(context) {
            const width = context.chart.width;
            return width < 400 ? 3 : 5;
          },
          hoverRadius: function(context) {
            const width = context.chart.width;
            return width < 400 ? 5 : 8;
          }
        }
      }
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
.lineChart {
    width: 100%;
    height: 300px;
    position: relative;
    background: white;
}

#lineChart {
    width: 100% !important;
    height: 100% !important;
    background: white;
}

/* Desktop Styles */
@media (min-width: 1025px) {
    .lineChart {
        height: 320px;
    }
}

/* Tablet Styles */
@media (max-width: 1024px) and (min-width: 769px) {
    .lineChart {
        height: 280px;
    }
}

/* Mobile Styles */
@media (max-width: 768px) {
    .lineChart {
        height: 250px;
    }
}

/* Small Mobile Styles */
@media (max-width: 480px) {
    .lineChart {
        height: 220px;
    }
}

/* Very Small Screens */
@media (max-width: 360px) {
    .lineChart {
        height: 200px;
    }
}
</style>