import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
    const user = ref(null)
    const token = ref(localStorage.getItem('token') || null)
    const isAuthenticated = computed(() => !!token.value)

    // Initialize axios with token
    if (token.value) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
    }

    // Register user
    const register = async (userData) => {
        try {
            const response = await axios.post('/api/register', userData)
            
            if (response.data.success) {
                user.value = response.data.user
                token.value = response.data.token
                
                // Save token to localStorage
                localStorage.setItem('token', token.value)
                localStorage.setItem('user', JSON.stringify(user.value))
                
                // Set axios default header
                axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
                
                return { success: true, data: response.data }
            }
        } catch (error) {
            console.error('Registration error:', error)
            return { 
                success: false, 
                errors: error.response?.data?.errors || {},
                message: error.response?.data?.message || 'Registration failed'
            }
        }
    }

    // Login user
    const login = async (credentials) => {
        try {
            const response = await axios.post('/api/login', credentials)
            
            if (response.data.success) {
                user.value = response.data.user
                token.value = response.data.token
                
                // Save token to localStorage
                localStorage.setItem('token', token.value)
                localStorage.setItem('user', JSON.stringify(user.value))
                
                // Set axios default header
                axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
                
                return { success: true, data: response.data }
            }
        } catch (error) {
            console.error('Login error:', error)
            return { 
                success: false, 
                message: error.response?.data?.message || 'Login failed'
            }
        }
    }

    // Logout user
    const logout = async () => {
        try {
            await axios.post('/api/logout')
        } catch (error) {
            console.error('Logout error:', error)
        } finally {
            // Clear local state
            user.value = null
            token.value = null
            
            // Remove from localStorage
            localStorage.removeItem('token')
            localStorage.removeItem('user')
            
            // Remove axios header
            delete axios.defaults.headers.common['Authorization']
        }
    }

    // Check if user is authenticated
    const checkAuth = async () => {
        if (!token.value) return false
        
        try {
            const response = await axios.get('/api/me')
            if (response.data.success) {
                user.value = response.data.user
                return true
            }
        } catch (error) {
            console.error('Auth check error:', error)
            logout()
            return false
        }
    }

    // Get user type
    const userType = computed(() => user.value?.user_type || null)
    
    // Check if user is admin
    const isAdmin = computed(() => user.value?.user_type === 'admin')
    
    // Check if user is seller
    const isSeller = computed(() => user.value?.user_type === 'seller')
    
    // Check if user is buyer
    const isBuyer = computed(() => user.value?.user_type === 'buyer')

    return {
        user,
        token,
        isAuthenticated,
        userType,
        isAdmin,
        isSeller,
        isBuyer,
        register,
        login,
        logout,
        checkAuth
    }
})