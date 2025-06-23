<script setup>
import { ref, computed, onMounted } from 'vue'
import AppMenuItem from './AppMenuItem.vue'

const userRole = ref('')

// Get user role from localStorage (same as your router guard)
const getUserRole = () => {
  const user = JSON.parse(localStorage.getItem('user') || '{}')
  return localStorage.getItem('role') || user.role || ''
}

// Responsable menu items
const responsableMenu = ref([
  {
    label: 'Modules',
    items: [
      {
        label: 'Entretien Individuel Module',
        icon: 'pi pi-fw pi-user',
        items: [
          {
            label: 'Dashboard',
            icon: 'pi pi-fw pi-home',
            to: '/',
          },
          {
            label: 'Checkin Forms',
            icon: 'pi pi-fw pi-file',
            to: '/entretien-individuel/checkin-forms',
          },
        ]
      }
      
    ]
  },
])

// Apprenant (Student) menu items
const apprenantMenu = ref([
  {
    label: 'Student Portal',
    items: [
      {
        label: 'Entretien Individuel',
        icon: 'pi pi-fw pi-user',
        items: [
          {
            label: 'Dashboard',
            icon: 'pi pi-fw pi-home',
            to: '/entretien-individuel/student/dashboard',
          },
         
          {
            label: 'My Submissions',
            icon: 'pi pi-fw pi-list',
            to: '/entretien-individuel/student/my-submissions',
          },
        ]
      }
    ]
  },
])

// Computed property to return the correct menu based on user role
const model = computed(() => {
  return userRole.value === 'apprenant' ? apprenantMenu.value : responsableMenu.value
})

onMounted(() => {
  userRole.value = getUserRole()
})
</script>

<template>
  <ul class="layout-menu">
    <template v-for="(item, i) in model" :key="item">
      <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
      <li v-if="item.separator" class="menu-separator"></li>
    </template>
  </ul>
</template>

<style lang="scss" scoped></style>