<template>
    <div class="register-container">
        <!-- Background with e-commerce theme -->
        <div class="background-overlay">
            <div class="background-image"></div>
            <div class="overlay"></div>
            <div class="uganda-elements">
                <div class="floating-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="floating-icon">
                    <i class="bi bi-shop"></i>
                </div>
                <div class="floating-icon">
                    <i class="bi bi-currency-exchange"></i>
                </div>
                <div class="floating-icon">
                    <i class="bi bi-basket"></i>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="row g-0">
                <!-- Left side with brand and Uganda e-commerce theme -->
                <div class="col-lg-7 d-none d-lg-flex align-items-center">
                    <div class="brand-section px-5">
                        <div class="brand-logo mb-4">
                            <div class="logo-circle">
                                <i class="bi bi-shop-window"></i>
                            </div>
                            <h1 class="brand-name">Uganda<span>TradeHub</span></h1>
                        </div>
                        
                        <div class="brand-content">
                            <h2 class="display-5 fw-bold text-white mb-4">Join Uganda's Fastest Growing E-commerce Platform</h2>
                            
                            <div class="features-list">
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-lightning-charge"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Fast Transactions</h5>
                                        <p class="text-light">Instant payment processing with local mobile money</p>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Secure Platform</h5>
                                        <p class="text-light">Verified buyers and sellers with secure escrow</p>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-geo-alt"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Local Delivery</h5>
                                        <p class="text-light">Door-to-door delivery across all regions of Uganda</p>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <div class="feature-icon">
                                        <i class="bi bi-graph-up"></i>
                                    </div>
                                    <div class="feature-text">
                                        <h5>Grow Your Business</h5>
                                        <p class="text-light">Reach thousands of customers nationwide</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="uganda-stats mt-5">
                                <div class="stat">
                                    <h3 class="fw-bold text-warning">10,000+</h3>
                                    <p class="text-light mb-0">Active Sellers</p>
                                </div>
                                <div class="stat">
                                    <h3 class="fw-bold text-warning">50,000+</h3>
                                    <p class="text-light mb-0">Happy Customers</p>
                                </div>
                                <div class="stat">
                                    <h3 class="fw-bold text-warning">75+</h3>
                                    <p class="text-light mb-0">Districts Covered</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="trust-badges mt-5">
                            <span class="badge bg-warning me-2">MTN Mobile Money</span>
                            <span class="badge bg-warning me-2">Airtel Money</span>
                            <span class="badge bg-warning">Bank Integration</span>
                        </div>
                    </div>
                </div>

                <!-- Right side with registration form -->
                <div class="col-lg-5">
                    <div class="register-form-section">
                        <div class="back-home mb-4">
                            <router-link to="/" class="back-link">
                                <i class="bi bi-arrow-left me-2"></i>
                                Back to Home
                            </router-link>
                        </div>

                        <div class="register-card">
                            <!-- Header -->
                            <div class="register-header text-center mb-4">
                                <div class="avatar-wrapper mb-3">
                                    <div class="register-avatar">
                                        <i class="bi bi-person-plus"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bold mb-2">Create Seller Account</h2>
                                <p class="text-muted">Start selling on Uganda's largest e-commerce platform</p>
                                <div class="account-type-badge mt-2">
                                    <span class="badge bg-warning text-dark">
                                        <i class="bi bi-shop me-1"></i>Seller Account
                                    </span>
                                </div>
                            </div>
                            
                            <!-- Error Alert -->
                            <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                {{ errorMessage }}
                                <button type="button" class="btn-close" @click="errorMessage = ''"></button>
                            </div>

                            <!-- Success Alert -->
                            <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                {{ successMessage }}
                                <button type="button" class="btn-close" @click="successMessage = ''"></button>
                            </div>

                            <!-- Form -->
                            <form
                                ref="registerForm"
                                @submit.prevent="handleRegister"
                                class="needs-validation"
                                :class="{ 'was-validated': formSubmitted }"
                                novalidate
                            >
                                <!-- Full Name -->
                                <div class="form-group mb-4">
                                    <label for="name" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i> Full Name
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control-lg" 
                                        id="name" 
                                        placeholder="Enter your full name"
                                        v-model="form.name"
                                        :class="{ 'is-invalid': errors.name }"
                                        @input="clearError('name')"
                                    >
                                    <div class="invalid-feedback" v-if="errors.name">
                                        {{ errors.name }}
                                    </div>
                                </div>

                                <!-- Full Name -->
                                <div class="form-group mb-4">
                                    <label for="username" class="form-label fw-semibold">
                                        <i class="bi bi-person me-1"></i> Username
                                    </label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control-lg" 
                                        id="username" 
                                        placeholder="Enter your username"
                                        v-model="form.username"
                                        :class="{ 'is-invalid': errors.username }"
                                        @input="clearError('username')"
                                    >
                                    <div class="invalid-feedback" v-if="errors.username">
                                        {{ errors.username }}
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="bi bi-envelope me-1"></i> Email Address
                                    </label>
                                    <input 
                                        type="email" 
                                        class="form-control form-control-lg" 
                                        id="email" 
                                        placeholder="example@domain.com"
                                        v-model="form.email"
                                        :class="{ 'is-invalid': errors.email }"
                                        @input="clearError('email')"
                                    >
                                    <div class="invalid-feedback" v-if="errors.email">
                                        {{ errors.email }}
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="form-group mb-4">
                                    <label for="phone" class="form-label fw-semibold">
                                        <i class="bi bi-phone me-1"></i> Phone Number
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">+256</span>
                                        <input 
                                            type="tel" 
                                            class="form-control form-control-lg" 
                                            id="phone" 
                                            placeholder="700 123 456"
                                            v-model="form.phone"
                                            :class="{ 'is-invalid': errors.phone }"
                                            @input="clearError('phone')"
                                        >
                                    </div>
                                    <div class="form-text">
                                        We'll use this for order updates and mobile money
                                    </div>
                                    <div class="invalid-feedback" v-if="errors.phone">
                                        {{ errors.phone }}
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="bi bi-lock me-1"></i> Password
                                    </label>
                                    <input 
                                        :type="showPassword ? 'text' : 'password'" 
                                        class="form-control form-control-lg" 
                                        id="password" 
                                        placeholder="Create a strong password"
                                        v-model="form.password"
                                        :class="{ 'is-invalid': errors.password }"
                                        @input="clearError('password')"
                                    >
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i> Minimum 8 characters with at least one letter and one number
                                    </div>
                                    <div class="invalid-feedback" v-if="errors.password">
                                        {{ errors.password }}
                                    </div>
                                    <div class="password-strength mt-2">
                                        <div class="progress" style="height: 4px;">
                                            <div 
                                                class="progress-bar" 
                                                :class="passwordStrengthClass"
                                                :style="{ width: passwordStrength + '%' }"
                                            ></div>
                                        </div>
                                        <small class="text-muted">{{ passwordStrengthText }}</small>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-group mb-4">
                                    <label for="password_confirmation" class="form-label fw-semibold">
                                        <i class="bi bi-lock-fill me-1"></i> Confirm Password
                                    </label>
                                    <div class="input-group">
                                        <input 
                                            :type="showPassword ? 'text' : 'password'" 
                                            class="form-control form-control-lg" 
                                            id="password_confirmation" 
                                            placeholder="Confirm your password"
                                            v-model="form.password_confirmation"
                                            :class="{ 'is-invalid': errors.password_confirmation }"
                                            @input="clearError('password_confirmation')"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary" 
                                            type="button"
                                            @click="showPassword = !showPassword"
                                            title="Show/Hide Password"
                                        >
                                            <i class="bi" :class="showPassword ? 'bi-eye-slash' : 'bi-eye'"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback" v-if="errors.password_confirmation">
                                        {{ errors.password_confirmation }}
                                    </div>
                                </div>

                                <!-- Terms and Conditions -->
                                <div class="form-check mb-4">
                                    <input 
                                        class="form-check-input" 
                                        type="checkbox" 
                                        id="terms"
                                        v-model="termsAccepted"
                                        :class="{ 'is-invalid': errors.terms }"
                                        @change="clearError('terms')"
                                    >
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-primary fw-semibold">Terms & Conditions</a> and <a href="#" class="text-primary fw-semibold">Privacy Policy</a>
                                    </label>
                                    <div class="invalid-feedback" v-if="errors.terms">
                                        {{ errors.terms }}
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-lg w-100 mb-4 py-3 register-btn"
                                    :disabled="loading"
                                >
                                    <span v-if="loading">
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Creating Account...
                                    </span>
                                    <span v-else>
                                        <i class="bi bi-shop me-2"></i>Create Seller Account
                                    </span>
                                </button>

                                <!-- Divider -->
                                <div class="divider mb-4">
                                    <span class="divider-text">or continue with</span>
                                </div>

                                <!-- Social Login -->
                                <div class="social-login mb-4">
                                    <div class="row g-3">
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
                                </div>

                                <!-- Already have account -->
                                <div class="text-center pt-3 border-top">
                                    <p class="mb-0 text-muted">
                                        Already have an account?
                                        <router-link to="/login" class="text-primary fw-semibold text-decoration-none ms-1">
                                            Sign in here
                                        </router-link>
                                    </p>
                                    <p class="mt-2 mb-0">
                                        <small>
                                            Want to shop instead? 
                                            <router-link to="/register/buyer" class="text-warning fw-semibold">
                                                Create buyer account
                                            </router-link>
                                        </small>
                                    </p>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Security Badge -->
                        <div class="security-badge text-center mt-4">
                            <div class="d-inline-flex align-items-center bg-light p-3 rounded">
                                <i class="bi bi-shield-check text-success fs-4 me-2"></i>
                                <div class="text-start">
                                    <small class="d-block fw-semibold">256-bit SSL Encryption</small>
                                    <small class="text-muted">Your data is securely protected</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const registerForm = ref(null)

const form = reactive({
    name: '',
    username: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    user_type: 'seller'
})

const errors = reactive({
    name: '',
    username: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    terms: ''
})

const loading = ref(false)
const errorMessage = ref('')
const successMessage = ref('')
const showPassword = ref(false)
const termsAccepted = ref(false)
const formSubmitted = ref(false)

/* -------------------------
   COMPUTED
-------------------------- */

const passwordStrength = computed(() => {
    if (!form.password) return 0
    let s = 0
    if (form.password.length >= 8) s += 25
    if (/[a-z]/.test(form.password)) s += 25
    if (/[A-Z]/.test(form.password)) s += 25
    if (/\d/.test(form.password)) s += 25
    return s
})

const passwordStrengthClass = computed(() => {
    if (passwordStrength.value < 50) return 'bg-danger'
    if (passwordStrength.value < 75) return 'bg-warning'
    return 'bg-success'
})

const passwordStrengthText = computed(() => {
    if (passwordStrength.value < 50) return 'Weak password'
    if (passwordStrength.value < 75) return 'Good password'
    return 'Strong password'
})

/* -------------------------
   VALIDATION
-------------------------- */

const clearError = (field) => {
    errors[field] = ''
}

const validateForm = () => {
    let isValid = true
    
    // Clear all errors
    Object.keys(errors).forEach(key => errors[key] = '')
    
    // Validate name
    if (!form.name.trim()) {
        errors.name = 'Full name is required'
        isValid = false
    }

    // Validate username
    if (!form.username.trim()) {
        errors.username = 'Username is required'
        isValid = false
    }
    
    // Validate email
    if (!form.email.trim()) {
        errors.email = 'Email address is required'
        isValid = false
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email)) {
        errors.email = 'Please enter a valid email address'
        isValid = false
    }
    
    // Validate phone
    if (!form.phone.trim()) {
        errors.phone = 'Phone number is required'
        isValid = false
    } else if (!/^[0-9]{9}$/.test(form.phone)) {
        errors.phone = 'Please enter a valid 9-digit phone number'
        isValid = false
    }
    
    // Validate password
    if (!form.password.trim()) {
        errors.password = 'Password is required'
        isValid = false
    } else if (form.password.length < 8) {
        errors.password = 'Password must be at least 8 characters long'
        isValid = false
    } else if (!/(?=.*[a-zA-Z])(?=.*\d)/.test(form.password)) {
        errors.password = 'Password must contain both letters and numbers'
        isValid = false
    }
    
    // Validate password confirmation
    if (!form.password_confirmation.trim()) {
        errors.password_confirmation = 'Please confirm your password'
        isValid = false
    } else if (form.password !== form.password_confirmation) {
        errors.password_confirmation = 'Passwords do not match'
        isValid = false
    }
    
    // Validate terms
    if (!termsAccepted.value) {
        errors.terms = 'You must agree to the terms and conditions'
        isValid = false
    }
    
    return isValid
}

/* -------------------------
   SUBMIT
-------------------------- */

const handleRegister = async () => {
    formSubmitted.value = true
    errorMessage.value = ''
    successMessage.value = ''
    
    // Validate form
    if (!validateForm()) {
        // Scroll to first error
        const firstErrorField = Object.keys(errors).find(key => errors[key])
        if (firstErrorField) {
            const element = document.getElementById(firstErrorField)
            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' })
                element.focus()
            }
        }
        return
    }
    
    loading.value = true
    
    try {
        // Prepare data for backend
        const registrationData = {
            name: form.name.trim(),
            username: form.username.trim(),
            email: form.email.trim(),
            phone: form.phone.trim(),
            password: form.password,
            password_confirmation: form.password_confirmation,
            user_type: 'seller'
        }
        
        console.log('Registering with data:', registrationData)
        
        const result = await authStore.register(registrationData)
        
        console.log('Registration result:', result)
        
        if (result.success) {
            successMessage.value = 'Account created successfully! Redirecting to dashboard...'
            
            // Determine redirect path based on user type
            let redirectPath = '/'
            const userType = authStore.user?.user_type || 'seller'
            
            switch(userType) {
                case 'admin':
                    redirectPath = '/admin/dashboard'
                    break
                case 'seller':
                    redirectPath = '/seller/dashboard'
                    break
                case 'buyer':
                    redirectPath = '/buyer/dashboard'
                    break
                default:
                    redirectPath = '/dashboard'
            }
            
            console.log('Redirecting to:', redirectPath)
            
            // Redirect after short delay
            setTimeout(() => {
                router.push(redirectPath)
            }, 1500)
        } else {
            // Handle validation errors from backend
            if (result.errors) {
                // Map backend errors to form fields
                if (result.errors.name) errors.name = result.errors.name[0]
                if (result.errors.username) errors.username = result.errors.username[0]
                if (result.errors.email) errors.email = result.errors.email[0]
                if (result.errors.phone) errors.phone = result.errors.phone[0]
                if (result.errors.password) errors.password = result.errors.password[0]
                if (result.errors.user_type) errors.user_type = result.errors.user_type[0]
                
                errorMessage.value = 'Please fix the errors in the form'
            } else {
                errorMessage.value = result.message || 'Registration failed. Please try again.'
            }
        }
    } catch (err) {
        console.error('Registration catch error:', err)
        errorMessage.value = 'An unexpected error occurred. Please try again.'
    } finally {
        loading.value = false
    }
}
</script>

<style scoped>
/* Previous styles remain the same, adding only new styles */

.register-header .account-type-badge {
    animation: fadeIn 0.5s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

.password-strength {
    margin-top: 0.5rem;
}

.password-strength .progress {
    background-color: #e9ecef;
    border-radius: 2px;
}

.password-strength .progress-bar {
    transition: width 0.3s ease;
}

/* Highlight required fields */
.form-label:after {
    content: " *";
    color: #dc3545;
}

/* Improve button disabled state */
.btn:disabled {
    opacity: 0.5;
    cursor: not-allowed;
    transform: none !important;
}

.register-btn:disabled {
    background: #6c757d;
}

/* Focus styles for better accessibility */
.form-control:focus {
    outline: none;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .password-strength {
        font-size: 0.85rem;
    }
}

/* Add smooth transitions for validation */
.form-control, .form-check-input {
    transition: all 0.3s ease;
}

/* Validation feedback animation */
.invalid-feedback {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Previous styles remain unchanged below this line */
.register-container {
    min-height: 100vh;
    position: relative;
    overflow: hidden;
}

.background-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: -1;
}

.background-image {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image: linear-gradient(rgba(0, 50, 0, 0.85), rgba(0, 30, 60, 0.9)), 
                      url('https://images.unsplash.com/photo-1593642632559-0c6d3fc62b89?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0, 100, 0, 0.3) 0%, rgba(0, 50, 100, 0.4) 100%);
}

.uganda-elements {
    position: absolute;
    width: 100%;
    height: 100%;
}

.floating-icon {
    position: absolute;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255, 255, 255, 0.3);
    font-size: 24px;
    animation: float 6s ease-in-out infinite;
}

.floating-icon:nth-child(1) {
    top: 20%;
    left: 10%;
    animation-delay: 0s;
}

.floating-icon:nth-child(2) {
    top: 40%;
    right: 15%;
    animation-delay: 1s;
}

.floating-icon:nth-child(3) {
    bottom: 30%;
    left: 15%;
    animation-delay: 2s;
}

.floating-icon:nth-child(4) {
    bottom: 20%;
    right: 10%;
    animation-delay: 3s;
}

@keyframes float {
    0%, 100% {
        transform: translateY(0) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(5deg);
    }
}

.brand-section {
    z-index: 1;
    height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.brand-logo {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo-circle {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #ffd700, #ff9900);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: #000;
}

.brand-name {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin: 0;
}

.brand-name span {
    color: #ffd700;
}

.features-list {
    margin-top: 2rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 1.5rem;
    padding: 15px;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
    transition: all 0.3s ease;
}

.feature-item:hover {
    background: rgba(255, 255, 255, 0.1);
    transform: translateX(10px);
}

.feature-icon {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #ffd700, #ff9900);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: #000;
}

.feature-text h5 {
    color: #ffd700;
    margin-bottom: 5px;
}

.feature-text p {
    font-size: 0.9rem;
    opacity: 0.8;
}

.uganda-stats {
    display: flex;
    justify-content: space-between;
    text-align: center;
}

.stat {
    padding: 0 15px;
}

.stat h3 {
    font-size: 2.5rem;
}

.trust-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.register-form-section {
    min-height: 100vh;
    background: rgba(255, 255, 255, 0.95);
    padding: 2rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    backdrop-filter: blur(10px);
}

.back-link {
    color: #666;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.back-link:hover {
    color: #007bff;
    transform: translateX(-5px);
}

.register-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
}

.register-header {
    position: relative;
}

.avatar-wrapper {
    position: relative;
    display: inline-block;
}

.register-avatar {
    width: 100px;
    height: 100px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    font-size: 40px;
    color: white;
    box-shadow: 0 10px 20px rgba(0, 123, 255, 0.3);
}

.register-avatar::after {
    content: '';
    position: absolute;
    top: -5px;
    left: -5px;
    right: -5px;
    bottom: -5px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    z-index: -1;
    opacity: 0.3;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% {
        transform: scale(1);
        opacity: 0.3;
    }
    50% {
        transform: scale(1.05);
        opacity: 0.5;
    }
}

.form-control-lg {
    padding: 1rem 1.25rem;
    border: 2px solid #e9ecef;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.form-control-lg:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(0, 123, 255, 0.15);
    transform: translateY(-2px);
}

.form-control-lg.is-invalid {
    border-color: #dc3545;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right calc(0.375em + 0.1875rem) center;
    background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
}

.form-control-lg.is-invalid:focus {
    border-color: #dc3545;
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}

.form-label {
    color: #495057;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.register-btn {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
    border-radius: 12px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.register-btn:hover:not(:disabled) {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(0, 123, 255, 0.3);
}

.register-btn:disabled {
    opacity: 0.6;
    cursor: not-allowed;
}

.register-btn::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: 0.5s;
}

.register-btn:hover::after {
    left: 100%;
}

.divider {
    position: relative;
    text-align: center;
}

.divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e9ecef;
}

.divider-text {
    background: white;
    padding: 0 1rem;
    color: #6c757d;
    font-size: 0.9rem;
    position: relative;
    z-index: 1;
}

.social-login .btn {
    border-radius: 10px;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.social-login .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.security-badge {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 992px) {
    .register-form-section {
        padding: 1.5rem;
        background: white;
    }
    
    .register-card {
        padding: 2rem;
        box-shadow: none;
        border: 1px solid #e9ecef;
    }
    
    .brand-section {
        padding: 2rem;
    }
}

@media (max-width: 768px) {
    .register-card {
        padding: 1.5rem;
    }
    
    .uganda-stats {
        flex-direction: column;
        gap: 1.5rem;
    }
}

@media (max-width: 576px) {
    .register-form-section {
        padding: 1rem;
    }
    
    .register-card {
        padding: 1.25rem;
        border-radius: 15px;
    }
    
    .register-avatar {
        width: 80px;
        height: 80px;
        font-size: 32px;
    }
    
    .feature-item {
        flex-direction: column;
        text-align: center;
        padding: 1rem;
    }
    
    .feature-icon {
        margin-bottom: 0.5rem;
    }
}

.spinner-border {
    vertical-align: middle;
}

.form-check-input.is-invalid {
    border-color: #dc3545;
}

.form-check-input.is-invalid:checked {
    border-color: #dc3545;
    background-color: #dc3545;
}

.form-check-input.is-invalid:focus {
    box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
}
</style>