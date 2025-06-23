<template>
  <div class="p-4 space-y-6">
    <!-- Header with Promotion Selector -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
      <h1 class="text-2xl font-bold text-surface-900 dark:text-surface-0">Dashboard</h1>
      
      <div class="flex items-center gap-3">
        <label class="text-sm font-medium text-muted-color">Promotion:</label>
        <Dropdown 
          v-model="selectedPromotion" 
          :options="promotions" 
          optionLabel="description" 
          optionValue="id"
          placeholder="Select Promotion"
          class="w-56"
          :loading="promotionsLoading"
        />
      </div>
    </div>

    <!-- KPI Cards -->
    <KPICards :kpis="kpis" />

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <!-- Group Stats -->
      <GroupeStats 
        :label="promotionLabel" 
        :stats="groupeStats" 
        :loading="groupeStatsLoading" 
      />
      
      <!-- Check-ins Chart -->
      <CheckinsChart 
        :data="checkinsData" 
        :loading="checkinsLoading" 
      />
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch, computed } from 'vue';
import { getPromotions, getKPIs, getGroupeStats, getCheckinsByPromotion } from '@/modules/EntretienIndividuel.module/service/Dashboard.service';
import KPICards from '../../components/dashboard/KpiCards.vue';
import GroupeStats from '../../components/dashboard/GroupeStats.vue';
import CheckinsChart from '../../components/dashboard/CheckinsChart.vue';

// Reactive data
const promotions = ref([]);
const selectedPromotion = ref(null);
const kpis = ref({});
const groupeStats = ref([]);
const checkinsData = ref([]);

// Loading states
const promotionsLoading = ref(false);
const kpisLoading = ref(false);
const groupeStatsLoading = ref(false);
const checkinsLoading = ref(false);

// Computed
const hasSelectedPromotion = computed(() => selectedPromotion.value !== null);

const promotionLabel = computed(() => {
  if (selectedPromotion.value === 'all') {
    return 'Group Performance (All promotions)';
  }
  const promo = promotions.value.find(p => p.id === selectedPromotion.value);
  return promo ? `Group Performance (${promo.description})` : 'Group Performance';
});

// Methods
const fetchPromotions = async () => {
  try {
    promotionsLoading.value = true;
    const response = await getPromotions();
    // Prepend "All promotions" option (backend treats "all" as no filter)
    promotions.value = [{ id: 'all', description: 'All promotions' }, ...response.data];
    // Default to "all"
    selectedPromotion.value = 'all';
  } catch (error) {
    console.error('Error fetching promotions:', error);
  } finally {
    promotionsLoading.value = false;
  }
};

const fetchKPIs = async (promotionId) => {
  if (!promotionId) return;
  
  try {
    kpisLoading.value = true;
    const response = await getKPIs(promotionId);
    kpis.value = response.data.data;
  } catch (error) {
    console.error('Error fetching KPIs:', error);
    kpis.value = {};
  } finally {
    kpisLoading.value = false;
  }
};

const fetchGroupeStats = async (promotionId) => {
  if (!promotionId) return;
  
  try {
    groupeStatsLoading.value = true;
    const response = await getGroupeStats(promotionId);
    groupeStats.value = response.data.data;
  } catch (error) {
    console.error('Error fetching group stats:', error);
    groupeStats.value = [];
  } finally {
    groupeStatsLoading.value = false;
  }
};

const fetchCheckinsData = async () => {
  try {
    checkinsLoading.value = true;
    const response = await getCheckinsByPromotion();
    checkinsData.value = response.data.data;
  } catch (error) {
    console.error('Error fetching check-ins data:', error);
    checkinsData.value = [];
  } finally {
    checkinsLoading.value = false;
  }
};

// Watchers
watch(selectedPromotion, (newPromotionId) => {
  if (newPromotionId) {
    fetchKPIs(newPromotionId);
    fetchGroupeStats(newPromotionId);
  }
}, { immediate: true });

// Lifecycle
onMounted(() => {
  fetchPromotions();
  fetchCheckinsData();
});
</script>