// src/stores/auth.js
import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import AuthService from '@/modules/EntretienIndividuel.module/service/Auth.service'

export const useAuthStore = defineStore('auth', () => {
  // State
  const user = ref(null)
  const token = ref(localStorage.getItem('token') || null)
  const isLoading = ref(false)

  // Getters
  const isAuthenticated = computed(() => !!token.value)
  const userRole = computed(() => user.value?.role || null)

  // Actions
  const login = async (credentials) => {
    isLoading.value = true
    try {
      const response = await AuthService.login(credentials)
      
      // Store token and user data
      token.value = response.token
      user.value = response.user
      
      // Store token in localStorage
      localStorage.setItem('token', response.token)
      
      return response
    } catch (error) {
      throw error
    } finally {
      isLoading.value = false
    }
  }

  const logout = async () => {
    isLoading.value = true
    try {
      await AuthService.logout()
    } catch (error) {
      console.warn('Logout API call failed:', error)
    } finally {
      // Clear state regardless of API call success
      token.value = null
      user.value = null
      localStorage.removeItem('token')
      isLoading.value = false
    }
  }

  const fetchProfile = async () => {
    if (!token.value) return
    
    try {
      const response = await AuthService.getProfile()
      user.value = response.user
      return response
    } catch (error) {
      // If profile fetch fails, token might be invalid
      logout()
      throw error
    }
  }

  const initAuth = () => {
    // Initialize auth state from localStorage
    const storedToken = localStorage.getItem('token')
    if (storedToken) {
      token.value = storedToken
      // Optionally fetch user profile on init
      fetchProfile().catch(() => {
        // If profile fetch fails, clear invalid token
        logout()
      })
    }
  }

  return {
    // State
    user,
    token,
    isLoading,
    
    // Getters
    isAuthenticated,
    userRole,
    
    // Actions
    login,
    logout,
    fetchProfile,
    initAuth
  }
})