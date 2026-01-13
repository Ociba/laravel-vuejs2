<template>
    <div class="auth-container">
        <Navbar />
        
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-5">
                    <div class="auth-card shadow">
                        <div class="auth-header text-center mb-4">
                            <h2 class="fw-bold">Welcome Back</h2>
                            <p class="text-muted">Login to your account</p>
                        </div>

                        <div class="auth-body">
                            <form @submit.prevent="handleLogin">
                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email"
                                        v-model="form.email"
                                        :class="{ 'is-invalid': errorMessage }"
                                        required
                                        placeholder="Enter your email"
                                        autofocus
                                    >
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <input 
                                            :type="showPassword ? 'text' : 'password'"
                                            class="form-control"
                                            id="password"
                                            v-model="form.password"
                                            :class="{ 'is-invalid': errorMessage }"
                                            required
                                            placeholder="Enter your password"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary"
                                            type="button"
                                            @click="showPassword = !showPassword"
                                        >
                                            <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Remember Me & Forgot Password -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="remember"
                                            v-model="form.remember"
                                        >
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <router-link to="/forgot-password" class="text-primary">
                                        Forgot password?
                                    </router-link>
                                </div>

                                <!-- Error Message -->
                                <div v-if="errorMessage" class="alert alert-danger" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    {{ errorMessage }}
                                </div>

                                <!-- Submit Button -->
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-lg w-100 mb-3"
                                    :disabled="loading"
                                >
                                    <span v-if="loading">
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Logging in...
                                    </span>
                                    <span v-else>
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </span>
                                </button>

                                <!-- Divider -->
                                <div class="divider my-4">
                                    <span class="text-muted">Or continue with</span>
                                </div>

                                <!-- Social Login (optional) -->
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-dark w-100">
                                            <i class="bi bi-google me-2"></i>Google
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-primary w-100">
                                            <i class="bi bi-facebook me-2"></i>Facebook
                                        </button>
                                    </div>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="mb-0">
                                        Don't have an account?
                                        <router-link to="/register" class="text-primary fw-semibold">Register here</router-link>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <AppFooter />
    </div>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import Navbar from '../layouts/Navbar.vue'
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

// Form data
const form = reactive({
    email: '',
    password: '',
    remember: false
})

// State
const loading = ref(false)
const errorMessage = ref('')
const showPassword = ref(false)

// Handle login
const handleLogin = async () => {
    loading.value = true
    errorMessage.value = ''

    try {
        const result = await authStore.login({
            email: form.email,
            password: form.password
        })

        if (result.success) {
            // Check if there's a redirect URL
            const redirectTo = route.query.redirect || '/dashboard'
            
            // Show success message
            const userType = result.data.user.user_type
            const greeting = userType === 'admin' ? 'Admin' : 
                           userType === 'seller' ? 'Seller' : 'Buyer'
            
            alert(`Welcome ${greeting}! Redirecting to dashboard...`)
            
            // Redirect
            router.push(redirectTo)
        } else {
            errorMessage.value = result.message || 'Invalid credentials'
        }
    } catch (error) {
        console.error('Login error:', error)
        errorMessage.value = 'An unexpected error occurred. Please try again.'
    } finally {
        loading.value = false
    }
}

// Auto-fill for testing (remove in production)
const fillTestCredentials = (type) => {
    if (type === 'admin') {
        form.email = 'admin@example.com'
        form.password = 'password123'
    } else if (type === 'seller') {
        form.email = 'seller@example.com'
        form.password = 'password123'
    } else if (type === 'buyer') {
        form.email = 'buyer@example.com'
        form.password = 'password123'
    }
}
</script>

<style scoped>
.auth-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.auth-card {
    background: white;
    border-radius: 15px;
    padding: 2.5rem;
    margin-top: 2rem;
}

.auth-header {
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #eee;
}

.auth-header h2 {
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.auth-body {
    padding-top: 1.5rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.input-group .btn {
    border-color: #dee2e6;
}

.input-group .btn:hover {
    background-color: #f8f9fa;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    padding: 1rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}

.btn-primary:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.alert {
    border-radius: 8px;
    padding: 0.75rem 1rem;
}

.divider {
    display: flex;
    align-items: center;
    text-align: center;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    border-bottom: 1px solid #dee2e6;
}

.divider:not(:empty)::before {
    margin-right: 1em;
}

.divider:not(:empty)::after {
    margin-left: 1em;
}

.btn-outline-dark, .btn-outline-primary {
    padding: 0.75rem;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-outline-dark:hover, .btn-outline-primary:hover {
    transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .auth-card {
        padding: 1.5rem;
        margin-top: 1rem;
    }
    
    .btn-primary {
        padding: 0.875rem;
    }
}

@media (max-width: 576px) {
    .auth-card {
        padding: 1rem;
        border-radius: 10px;
    }
}
</style>