<template>
    <div class="relative">
      <canvas ref="chartRef"></canvas>
    </div>
  </template>

  <script setup>
  import { ref, onMounted, watch } from 'vue'
  import Chart from 'chart.js/auto'

  const props = defineProps({
    data: {
      type: Object,
      required: true
    }
  })

  const chartRef = ref(null)
  let chart = null

  const createChart = () => {
    const ctx = chartRef.value.getContext('2d')

    chart = new Chart(ctx, {
      type: 'line',
      data: props.data,
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            position: 'top',
            labels: {
              usePointStyle: true,
              padding: 20
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              drawBorder: false
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        },
        elements: {
          point: {
            radius: 4,
            hoverRadius: 6
          },
          line: {
            borderWidth: 2
          }
        }
      }
    })
  }

  onMounted(() => {
    createChart()
  })

  watch(() => props.data, (newData) => {
    if (chart) {
      chart.data = newData
      chart.update()
    }
  }, { deep: true })
  </script>
