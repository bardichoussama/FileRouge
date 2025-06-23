<template>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
      <!-- Total Check-ins -->
      <div class="card mb-0">
        <div class="flex justify-between mb-4">
          <div>
            <span class="block text-muted-color font-medium mb-4">Total Check-ins</span>
            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
              {{ kpis?.total_checkins || 0 }}
            </div>
          </div>
          <div class="flex items-center justify-center bg-blue-100 dark:bg-blue-400/10 rounded-border" style="width: 2.5rem; height: 2.5rem">
            <i class="pi pi-check-circle text-blue-500 !text-xl"></i>
          </div>
        </div>
        <span class="text-muted-color">Students submissions</span>
      </div>
  
      <!-- Total Students -->
      <div class="card mb-0">
        <div class="flex justify-between mb-4">
          <div>
            <span class="block text-muted-color font-medium mb-4">Total Students</span>
            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
              {{ kpis?.total_students || 0 }}
            </div>
          </div>
          <div class="flex items-center justify-center bg-green-100 dark:bg-green-400/10 rounded-border" style="width: 2.5rem; height: 2.5rem">
            <i class="pi pi-users text-green-500 !text-xl"></i>
          </div>
        </div>
        <span class="text-muted-color">Registered students</span>
      </div>
  
      <!-- AI Insights -->
      <div class="card mb-0">
        <div class="flex justify-between mb-4">
          <div>
            <span class="block text-muted-color font-medium mb-4">AI Insights</span>
            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
              {{ kpis?.total_ai_insights || 0 }}
            </div>
          </div>
          <div class="flex items-center justify-center bg-purple-100 dark:bg-purple-400/10 rounded-border" style="width: 2.5rem; height: 2.5rem">
            <i class="pi pi-brain text-purple-500 !text-xl"></i>
          </div>
        </div>
        <span class="text-muted-color">Generated insights</span>
      </div>
  
      <!-- Check-in Forms -->
      <div class="card mb-0">
        <div class="flex justify-between mb-4">
          <div>
            <span class="block text-muted-color font-medium mb-4">Check-in Forms</span>
            <div class="text-surface-900 dark:text-surface-0 font-medium text-xl">
              {{ kpis?.total_checkin_forms || 0 }}
            </div>
          </div>
          <div class="flex items-center justify-center bg-orange-100 dark:bg-orange-400/10 rounded-border" style="width: 2.5rem; height: 2.5rem">
            <i class="pi pi-file-edit text-orange-500 !text-xl"></i>
          </div>
        </div>
        <span class="text-muted-color">Available forms</span>
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    kpis: {
      type: Object,
      default: () => ({})
    }
  });
  </script>