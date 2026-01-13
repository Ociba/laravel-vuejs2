<template>
    <div class="auth-container">
        <Navbar />
        
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6">
                    <div class="auth-card shadow">
                        <div class="auth-header text-center mb-4">
                            <h2 class="fw-bold">Create Account</h2>
                            <p class="text-muted">Join our marketplace as a seller</p>
                        </div>

                        <div class="auth-body">
                            <form @submit.prevent="handleRegister">
                                <!-- Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="name"
                                        v-model="form.name"
                                        :class="{ 'is-invalid': errors.name }"
                                        required
                                        placeholder="Enter your full name"
                                    >
                                    <div class="invalid-feedback" v-if="errors.name">
                                        {{ errors.name[0] }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email"
                                        v-model="form.email"
                                        :class="{ 'is-invalid': errors.email }"
                                        required
                                        placeholder="Enter your email"
                                    >
                                    <div class="invalid-feedback" v-if="errors.email">
                                        {{ errors.email[0] }}
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input 
                                        type="tel" 
                                        class="form-control" 
                                        id="phone"
                                        v-model="form.phone"
                                        :class="{ 'is-invalid': errors.phone }"
                                        placeholder="Enter your phone number"
                                    >
                                    <div class="invalid-feedback" v-if="errors.phone">
                                        {{ errors.phone[0] }}
                                    </div>
                                </div>

                                <!-- User Type Selection -->
                                <div class="mb-3">
                                    <label class="form-label">I want to join as:</label>
                                    <div class="row">
                                        <div class="col-md-4 mb-2" v-for="type in userTypes" :key="type.value">
                                            <input 
                                                type="radio" 
                                                class="btn-check" 
                                                :id="`type-${type.value}`" 
                                                v-model="form.user_type" 
                                                :value="type.value"
                                            >
                                            <label class="btn btn-outline-primary w-100" :for="`type-${type.value}`">
                                                <i :class="type.icon"></i>
                                                <span class="d-block mt-1">{{ type.label }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password *</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="password"
                                        v-model="form.password"
                                        :class="{ 'is-invalid': errors.password }"
                                        required
                                        placeholder="Create a strong password"
                                    >
                                    <div class="invalid-feedback" v-if="errors.password">
                                        {{ errors.password[0] }}
                                    </div>
                                    <div class="form-text">
                                        Must be at least 8 characters long
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="password_confirmation"
                                        v-model="form.password_confirmation"
                                        :class="{ 'is-invalid': errors.password_confirmation }"
                                        required
                                        placeholder="Confirm your password"
                                    >
                                    <div class="invalid-feedback" v-if="errors.password_confirmation">
                                        {{ errors.password_confirmation[0] }}
                                    </div>
                                </div>

                                <!-- Terms Agreement -->
                                <div class="mb-4">
                                    <div class="form-check">
                                        <input 
                                            class="form-check-input" 
                                            type="checkbox" 
                                            id="terms"
                                            v-model="form.agree_terms"
                                            required
                                        >
                                        <label class="form-check-label" for="terms">
                                            I agree to the 
                                            <router-link to="/terms" class="text-primary">Terms of Service</router-link>
                                            and 
                                            <router-link to="/privacy" class="text-primary">Privacy Policy</router-link>
                                        </label>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-lg w-100 mb-3"
                                    :disabled="loading"
                                >
                                    <span v-if="loading">
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Creating Account...
                                    </span>
                                    <span v-else>
                                        <i class="bi bi-person-plus me-2"></i>Create Account
                                    </span>
                                </button>

                                <!-- Login Link -->
                                <div class="text-center">
                                    <p class="mb-0">
                                        Already have an account?
                                        <router-link to="/login" class="text-primary fw-semibold">Login here</router-link>
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
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import Navbar from '../layouts/Navbar.vue'
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()
const authStore = useAuthStore()

// Form data
const form = reactive({
    name: '',
    email: '',
    phone: '',
    user_type: 'seller', // Default to seller
    password: '',
    password_confirmation: '',
    agree_terms: false
})

// User types options
const userTypes = [
    { value: 'seller', label: 'Seller', icon: 'bi bi-shop', description: 'List and sell products' },
    { value: 'buyer', label: 'Buyer', icon: 'bi bi-cart', description: 'Browse and buy products' },
    { value: 'admin', label: 'Admin', icon: 'bi bi-gear', description: 'Manage platform' }
]

// State
const loading = ref(false)
const errors = ref({})
const errorMessage = ref('')

// Handle registration
const handleRegister = async () => {
    if (!form.agree_terms) {
        errorMessage.value = 'You must agree to the terms and conditions'
        return
    }

    loading.value = true
    errors.value = {}
    errorMessage.value = ''

    try {
        const result = await authStore.register({
            name: form.name,
            email: form.email,
            phone: form.phone,
            user_type: form.user_type,
            password: form.password,
            password_confirmation: form.password_confirmation
        })

        if (result.success) {
            // Show success message
            alert('Registration successful! Redirecting to dashboard...')
            
            // Redirect to dashboard based on user type
            router.push('/dashboard')
        } else {
            errors.value = result.errors || {}
            errorMessage.value = result.message || 'Registration failed'
        }
    } catch (error) {
        console.error('Registration error:', error)
        errorMessage.value = 'An unexpected error occurred. Please try again.'
    } finally {
        loading.value = false
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

.btn-outline-primary {
    padding: 1rem;
    border: 2px solid #dee2e6;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.btn-check:checked + .btn-outline-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-color: #007bff;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,123,255,0.3);
}

.btn-outline-primary:hover {
    border-color: #007bff;
    transform: translateY(-2px);
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

.invalid-feedback {
    display: block;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #dc3545;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .auth-card {
        padding: 1.5rem;
        margin-top: 1rem;
    }
    
    .btn-outline-primary {
        padding: 0.75rem;
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