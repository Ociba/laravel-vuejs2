import { defineStore } from 'pinia'
import { ref } from 'vue'
import axios from 'axios'

export const useAuthStore = defineStore('auth', () => {
    // State
    const user = ref(null)
    const token = ref(localStorage.getItem('auth_token'))
    const isAuthenticated = ref(!!localStorage.getItem('auth_token'))
    const loading = ref(false)

    // Initialize axios with token
    if (token.value) {
        axios.defaults.headers.common['Authorization'] = `Bearer ${token.value}`
    }

    // FAST Login function
    const login = async (credentials) => {
        loading.value = true
        
        try {
            const response = await axios.post('/api/login', credentials)
            
            if (response.data.success) {
                // Store immediately
                const userToken = response.data.token
                localStorage.setItem('auth_token', userToken)
                
                // Update state
                token.value = userToken
                user.value = response.data.user
                isAuthenticated.value = true
                
                // Set axios header
                axios.defaults.headers.common['Authorization'] = `Bearer ${userToken}`
                
                return true
            } else {
                return false
            }
        } catch (error) {
            console.error('Login error:', error)
            
            // Clear on error
            localStorage.removeItem('auth_token')
            token.value = null
            user.value = null
            isAuthenticated.value = false
            
            throw new Error(error.response?.data?.message || 'Login failed')
        } finally {
            loading.value = false
        }
    }

    // FAST registration
    const register = async (userData) => {
        loading.value = true
        
        try {
            const response = await axios.post('/api/register', userData)
            
            if (response.data.success) {
                const userToken = response.data.token
                localStorage.setItem('auth_token', userToken)
                
                token.value = userToken
                user.value = response.data.user
                isAuthenticated.value = true
                
                axios.defaults.headers.common['Authorization'] = `Bearer ${userToken}`
                
                return true
            } else {
                return false
            }
        } catch (error) {
            console.error('Registration error:', error)
            throw new Error(error.response?.data?.message || 'Registration failed')
        } finally {
            loading.value = false
        }
    }

    // Logout
    const logout = () => {
        localStorage.removeItem('auth_token')
        token.value = null
        user.value = null
        isAuthenticated.value = false
        delete axios.defaults.headers.common['Authorization']
    }

    // Check auth - OPTIMIZED
    const checkAuth = async () => {
        const storedToken = localStorage.getItem('auth_token')
        
        if (!storedToken) {
            logout()
            return false
        }

        try {
            axios.defaults.headers.common['Authorization'] = `Bearer ${storedToken}`
            const response = await axios.get('/api/me')
            
            if (response.data.success) {
                user.value = response.data.user
                isAuthenticated.value = true
                token.value = storedToken
                return true
            } else {
                logout()
                return false
            }
        } catch (error) {
            console.error('Auth check error:', error)
            logout()
            return false
        }
    }

    // Computed properties
    const isAdmin = () => user.value?.user_type === 'admin'
    const isSeller = () => user.value?.user_type === 'seller'
    const isBuyer = () => user.value?.user_type === 'buyer'

    return {
        user,
        token,
        isAuthenticated,
        loading,
        login,
        register,
        logout,
        checkAuth,
        isAdmin,
        isSeller,
        isBuyer
    }
})