<template>
    <div class="card">
      <h2 class="text-lg font-semibold mb-4">Check-ins by Promotion</h2>
      
      <div v-if="loading" class="flex justify-center items-center h-80">
        <p class="text-muted-color">Loading...</p>
      </div>
      
      <div v-else-if="!chartData" class="flex justify-center items-center h-80">
        <p class="text-sm text-muted-color">No data available</p>
      </div>
      
      <Chart
        v-else
        type="bar"
        :data="chartData"
        :options="chartOptions"
        class="h-80"
      />
    </div>
  </template>
  
  <script setup>
  import { computed } from 'vue';
const documentStyle = getComputedStyle(document.documentElement);
const primaryColor = documentStyle.getPropertyValue('--primary-color') || '#0d6efd';
  
  const props = defineProps({
    data: {
      type: Array,
      default: () => []
    },
    loading: {
      type: Boolean,
      default: false
    }
  });
  
  const chartData = computed(() => {
    if (!props.data?.length) return null;
  
    const labels = props.data.map(item => item.promotion_name);
    const data = props.data.map(item => item.checkin_count);
  
    return {
      labels,
      datasets: [
        {
          label: 'Check-ins',
          data,
          backgroundColor: primaryColor,
          borderColor: primaryColor,
          borderWidth: 1,
          borderRadius: 6,
          barThickness: 32
        }
      ]
    };
  });
  
  const chartOptions = computed(() => {
    const documentStyle = getComputedStyle(document.documentElement);
    const borderColor = documentStyle.getPropertyValue('--surface-border');
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textMutedColor = documentStyle.getPropertyValue('--text-color-secondary');
  
    return {
      maintainAspectRatio: false,
      responsive: true,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          mode: 'index',
          intersect: false
        }
      },
      scales: {
        x: {
          ticks: {
            color: textMutedColor,
            font: { weight: '500' }
          },
          grid: {
            color: 'transparent'
          }
        },
        y: {
          ticks: {
            color: textMutedColor,
            stepSize: 1,
            callback: (value) => Number.isInteger(value) ? value : null
          },
          grid: {
            color: borderColor,
            borderDash: [4, 4],
            drawTicks: false
          },
          beginAtZero: true
        }
      }
    };
  });
  </script>