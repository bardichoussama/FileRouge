<template>
    <div class="card">
      <div class="flex justify-between items-center mb-6">
        <div class="font-semibold text-xl">{{ label }}</div>
      </div>
      
      <div v-if="loading" class="text-center py-8">
        <p class="text-muted-color">Loading...</p>
      </div>
      
      <div v-else-if="!stats?.length" class="text-center py-8">
        <p class="text-muted-color">No group data available</p>
      </div>
      
      <ul v-else class="list-none p-0 m-0">
        <li v-for="group in stats" :key="group.groupe_name" 
            class="flex flex-col md:flex-row md:items-center md:justify-between mb-6">
          <div>
            <span class="text-surface-900 dark:text-surface-0 font-medium mr-2 mb-1 md:mb-0">
              {{ group.groupe_name }}<span v-if="group.promotion_year" class="text-muted-color text-sm ml-2">({{ group.promotion_year }})</span>
            </span>
            <div class="mt-1 text-muted-color">
              {{ group.students_submitted }}/{{ group.total_students }} students submitted
            </div>
          </div>
          <div class="mt-2 md:mt-0 flex items-center">
            <div class="bg-surface-300 dark:bg-surface-500 rounded-border overflow-hidden w-40 lg:w-24" style="height: 8px">
              <div class="bg-primary-500 h-full" :style="{ width: group.percentage + '%' }"></div>
            </div>
            <span class="text-primary-500 ml-4 font-medium">{{ group.percentage }}%</span>
          </div>
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  defineProps({
    stats: {
      type: Array,
      default: () => []
    },
    loading: {
      type: Boolean,
      default: false
    },
    label: {
      type: String,
      default: 'Group Performance'
    }
  });
  </script>