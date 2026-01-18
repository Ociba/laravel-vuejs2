<template>
    <div class="login-container">
        <!-- Background Image with Overlay -->
        <div class="background-overlay">
            <div class="background-image"></div>
            <div class="overlay"></div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="row g-0">
                <!-- Left Side - Welcome/Brand Section -->
                <div class="col-lg-7 d-none d-lg-flex">
                    <div class="brand-section">
                        <div class="brand-content">
                            <!-- Logo -->
                            <div class="logo mb-4">
                                <i class="bi bi-shop logo-icon"></i>
                                <span class="logo-text">Ugatrade</span>
                            </div>
                            
                            <!-- Welcome Message -->
                            <h1 class="welcome-title">Welcome to Ugatrade</h1>
                            <p class="welcome-subtitle">Kenya's Leading E-commerce Platform</p>
                            
                            <!-- Features List -->
                            <div class="features-list">
                                <div class="feature-item">
                                    <i class="bi bi-shield-check feature-icon"></i>
                                    <div>
                                        <h6>Secure Transactions</h6>
                                        <p class="small">Buy and sell with confidence</p>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <i class="bi bi-truck feature-icon"></i>
                                    <div>
                                        <h6>Nationwide Delivery</h6>
                                        <p class="small">Fast shipping across Kenya</p>
                                    </div>
                                </div>
                                
                                <div class="feature-item">
                                    <i class="bi bi-chat-dots feature-icon"></i>
                                    <div>
                                        <h6>24/7 Support</h6>
                                        <p class="small">We're here to help you</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statistics -->
                        <div class="statistics">
                            <div class="stat-item">
                                <h4>50K+</h4>
                                <p>Happy Customers</p>
                            </div>
                            <div class="stat-item">
                                <h4>10K+</h4>
                                <p>Active Sellers</p>
                            </div>
                            <div class="stat-item">
                                <h4>100K+</h4>
                                <p>Products Listed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="col-lg-5">
                    <div class="login-form-section">
                        <!-- Back to Home -->
                        <div class="back-home mb-4">
                            <router-link to="/" class="back-link">
                                <i class="bi bi-arrow-left me-2"></i>
                                Back to Home
                            </router-link>
                        </div>

                        <!-- Login Form Card -->
                        <div class="login-card">
                            <!-- Header -->
                            <div class="login-header text-center mb-4">
                                <div class="avatar-wrapper mb-3">
                                    <div class="login-avatar">
                                        <i class="bi bi-person-circle"></i>
                                    </div>
                                </div>
                                <h2 class="fw-bold mb-2">Welcome Back!</h2>
                                <p class="text-muted">Sign in to your account</p>
                            </div>

                            <!-- Form -->
                            <form @submit.prevent="handleLogin">
                                <!-- Email -->
                                <div class="form-group mb-4">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope"></i>
                                        </span>
                                        <input 
                                            type="email" 
                                            class="form-control" 
                                            id="email"
                                            v-model="form.email"
                                            :class="{ 'is-invalid': errorMessage }"
                                            required
                                            placeholder="Enter your email"
                                            autofocus
                                            :disabled="loading"
                                        >
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="form-group mb-4">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock"></i>
                                        </span>
                                        <input 
                                            :type="showPassword ? 'text' : 'password'"
                                            class="form-control"
                                            id="password"
                                            v-model="form.password"
                                            :class="{ 'is-invalid': errorMessage }"
                                            required
                                            placeholder="Enter your password"
                                            :disabled="loading"
                                        >
                                        <button 
                                            class="btn btn-outline-secondary"
                                            type="button"
                                            @click="showPassword = !showPassword"
                                            :disabled="loading"
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
                                            :disabled="loading"
                                        >
                                        <label class="form-check-label" for="remember">
                                            Remember me
                                        </label>
                                    </div>
                                    <router-link to="/forgot-password" class="text-primary text-decoration-none">
                                        Forgot password?
                                    </router-link>
                                </div>

                                <!-- Error Message -->
                                <div v-if="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    {{ errorMessage }}
                                    <button type="button" class="btn-close" @click="errorMessage = ''"></button>
                                </div>

                                <!-- Submit Button -->
                                <button 
                                    type="submit" 
                                    class="btn btn-primary btn-lg w-100 mb-4 login-btn"
                                    :disabled="loading"
                                >
                                    <span v-if="loading">
                                        <span class="spinner-border spinner-border-sm me-2"></span>
                                        Logging in...
                                    </span>
                                    <span v-else>
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                                    </span>
                                </button>

                                <!-- Divider -->
                                <div class="divider my-4">
                                    <span class="divider-text">Or continue with</span>
                                </div>

                                <!-- Social Login -->
                                <div class="row g-2 mb-4">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-light w-100 social-btn google-btn" :disabled="loading">
                                            <i class="bi bi-google me-2"></i>Google
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn btn-outline-light w-100 social-btn facebook-btn" :disabled="loading">
                                            <i class="bi bi-facebook me-2"></i>Facebook
                                        </button>
                                    </div>
                                </div>

                                <!-- Register Link -->
                                <div class="text-center">
                                    <p class="mb-0">
                                        Don't have an account?
                                        <router-link to="/register" class="text-primary fw-semibold text-decoration-none ms-1">
                                            Create account
                                        </router-link>
                                    </p>
                                    <p class="small text-muted mt-2">
                                        By continuing, you agree to our 
                                        <a href="#" class="text-primary">Terms</a> and 
                                        <a href="#" class="text-primary">Privacy Policy</a>
                                    </p>
                                </div>
                            </form>
                        </div>

                        <!-- Footer Links -->
                        <div class="login-footer text-center mt-4">
                            <p class="small text-muted mb-0">
                                © 2024 Ugatrade. All rights reserved.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { ref, reactive } from 'vue'
    import { useRouter, useRoute } from 'vue-router'
    import { useAuthStore } from '../../stores/auth'
    
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
    
    // Handle login - FAST INSTANT REDIRECT
    const handleLogin = async () => {
        loading.value = true
        errorMessage.value = ''
    
        try {
            // Call login
            const success = await authStore.login({
                email: form.email,
                password: form.password
            })
    
            if (success) {
                // INSTANT redirect based on user type - NO WAITING
                const userType = authStore.user?.user_type || 'seller'
                
                switch(userType) {
                    case 'admin':
                        router.push('/dashboard/admin')
                        break
                    case 'seller':
                        router.push('/dashboard/seller')
                        break
                    case 'buyer':
                        router.push('/dashboard/buyer')
                        break
                    default:
                        router.push('/dashboard/seller')
                }
            } else {
                errorMessage.value = 'Invalid email or password'
            }
        } catch (error) {
            console.error('Login error:', error)
            errorMessage.value = error.message || 'An error occurred. Please try again.'
        } finally {
            loading.value = false
        }
    }
    </script>

<style scoped>
/* Main Container */
.login-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

/* Background */
.background-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: -1;
}

.background-image {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    animation: zoomEffect 20s ease-in-out infinite alternate;
}

.overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(106, 17, 203, 0.85) 0%, rgba(37, 117, 252, 0.85) 100%);
}

@keyframes zoomEffect {
    0% {
        transform: scale(1);
    }
    100% {
        transform: scale(1.1);
    }
}

/* Main Content */
.main-content {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
    z-index: 1;
}

/* Brand Section */
.brand-section {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%;
    min-height: 85vh;
    padding: 3rem;
    color: white;
}

.logo {
    display: flex;
    align-items: center;
    gap: 10px;
}

.logo-icon {
    font-size: 2.5rem;
    color: #fff;
}

.logo-text {
    font-size: 2rem;
    font-weight: 700;
    color: white;
}

.welcome-title {
    font-size: 2.8rem;
    font-weight: 700;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.welcome-subtitle {
    font-size: 1.2rem;
    opacity: 0.9;
    margin-bottom: 3rem;
}

.features-list {
    margin-top: 3rem;
}

.feature-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 10px;
    backdrop-filter: blur(10px);
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateX(10px);
    background: rgba(255, 255, 255, 0.15);
}

.feature-icon {
    font-size: 1.5rem;
    color: #fff;
    min-width: 40px;
}

.statistics {
    display: flex;
    justify-content: space-between;
    gap: 1rem;
    margin-top: auto;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 255, 255, 0.2);
}

.stat-item {
    text-align: center;
    flex: 1;
}

.stat-item h4 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: white;
}

.stat-item p {
    font-size: 0.9rem;
    opacity: 0.8;
    margin: 0;
}

/* Login Form Section */
.login-form-section {
    background: white;
    height: 100%;
    min-height: 85vh;
    padding: 3rem;
    border-radius: 20px;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.back-link {
    color: #6c757d;
    text-decoration: none;
    transition: color 0.3s ease;
}

.back-link:hover {
    color: #007bff;
}

.login-card {
    max-width: 400px;
    margin: 0 auto;
    width: 100%;
}

.login-avatar {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    color: white;
    box-shadow: 0 8px 25px rgba(106, 17, 203, 0.3);
}

/* Form Styles */
.form-group {
    position: relative;
}

.input-group {
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.input-group:focus-within {
    border-color: #6a11cb;
    box-shadow: 0 0 0 0.25rem rgba(106, 17, 203, 0.25);
}

.input-group-text {
    background: #f8f9fa;
    border: none;
    color: #6a11cb;
    padding: 0.75rem 1rem;
}

.form-control {
    border: none;
    padding: 0.75rem 1rem;
    border-radius: 0;
}

.form-control:focus {
    box-shadow: none;
}

.login-btn {
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    border: none;
    padding: 1rem;
    border-radius: 10px;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.login-btn:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(106, 17, 203, 0.3);
}

.login-btn:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

/* Divider */
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
    background: #dee2e6;
    z-index: 1;
}

.divider-text {
    position: relative;
    z-index: 2;
    background: white;
    padding: 0 1rem;
    color: #6c757d;
    font-size: 0.9rem;
}

/* Social Buttons */
.social-btn {
    border-radius: 10px;
    padding: 0.75rem;
    transition: all 0.3s ease;
    border: 1px solid #dee2e6;
    color: #495057;
}

.google-btn:hover {
    background: #4285F4;
    border-color: #4285F4;
    color: white;
}

.facebook-btn:hover {
    background: #4267B2;
    border-color: #4267B2;
    color: white;
}

.social-btn:hover i {
    color: white;
}

/* Responsive Design */
@media (max-width: 991.98px) {
    .login-form-section {
        padding: 2rem;
        min-height: auto;
        border-radius: 15px;
        margin-top: 2rem;
    }
    
    .brand-section {
        min-height: auto;
        padding: 2rem;
    }
    
    .welcome-title {
        font-size: 2.2rem;
    }
    
    .main-content {
        padding: 1rem;
    }
}

@media (max-width: 767.98px) {
    .login-form-section {
        padding: 1.5rem;
        margin: 1rem;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .welcome-title {
        font-size: 1.8rem;
    }
    
    .logo-text {
        font-size: 1.5rem;
    }
    
    .statistics {
        flex-direction: column;
        gap: 1rem;
        margin-top: 2rem;
    }
    
    .stat-item {
        text-align: left;
        padding: 1rem;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
    }
}

@media (max-width: 575.98px) {
    .login-form-section {
        padding: 1rem;
        margin: 0.5rem;
    }
    
    .login-header h2 {
        font-size: 1.5rem;
    }
    
    .login-avatar {
        width: 60px;
        height: 60px;
        font-size: 1.8rem;
    }
    
    .features-list .feature-item {
        padding: 0.75rem;
    }
    
    .feature-icon {
        font-size: 1.2rem;
        min-width: 30px;
    }
}
</style>