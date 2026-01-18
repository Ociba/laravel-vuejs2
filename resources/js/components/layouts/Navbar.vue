<template>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" :class="navbarClass">
        <div class="container">
            <!-- Logo/Brand -->
            <router-link class="navbar-brand fw-bold" to="/">
                <i class="bi bi-shop me-2"></i>Ugatrade
            </router-link>

            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left-aligned menu items -->
                <ul class="navbar-nav me-auto">
                    <li v-if="!authStore.isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/">
                            <i class="bi bi-house-door me-1"></i>Home
                        </router-link>
                    </li>
                    
                    <!-- Products -->
                    <li v-if="!authStore.isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/products">
                            <i class="bi bi-grid me-1"></i>All Products
                        </router-link>
                    </li>

                    <!-- Categories Dropdown - Show only if NOT logged in -->
                    <li v-if="!authStore.isAuthenticated" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="categoriesDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-tags me-1"></i>Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="categoriesDropdown">
                            <li><router-link class="dropdown-item" to="/category/electronics">
                                <i class="bi bi-cpu me-2"></i>Electronics
                            </router-link></li>
                            <li><router-link class="dropdown-item" to="/category/phones">
                                <i class="bi bi-phone me-2"></i>Phones & Tablets
                            </router-link></li>
                            <li><router-link class="dropdown-item" to="/category/computing">
                                <i class="bi bi-laptop me-2"></i>Computing
                            </router-link></li>
                            <li><router-link class="dropdown-item" to="/category/fashion">
                                <i class="bi bi-person-standing me-2"></i>Fashion
                            </router-link></li>
                            <li><router-link class="dropdown-item" to="/category/home">
                                <i class="bi bi-house-gear me-2"></i>Home & Garden
                            </router-link></li>
                            <li><router-link class="dropdown-item" to="/category/vehicles">
                                <i class="bi bi-car-front me-2"></i>Vehicles
                            </router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><router-link class="dropdown-item" to="/categories">
                                <i class="bi bi-list-ul me-2"></i>All Categories
                            </router-link></li>
                        </ul>
                    </li>

                    <!-- Condition Filter - Show only if NOT logged in -->
                    <li v-if="!authStore.isAuthenticated" class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="conditionDropdown" 
                           role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-stars me-1"></i>Condition
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="conditionDropdown">
                            <li><router-link class="dropdown-item" to="/condition/new">
                                <i class="bi bi-box-seam me-2"></i>Brand New
                            </router-link></li>
                            <li><router-link class="dropdown-item" to="/condition/used">
                                <i class="bi bi-arrow-repeat me-2"></i>Used - Like New
                            </router-link></li>
                            <li><router-link class="dropdown-item" to="/condition/refurbished">
                                <i class="bi bi-tools me-2"></i>Refurbished
                            </router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><router-link class="dropdown-item" to="/products">
                                <i class="bi bi-eye me-2"></i>View All
                            </router-link></li>
                        </ul>
                    </li>

                    <!-- For Admin - Only show when admin is logged in -->
                    <li v-if="authStore.isAuthenticated && authStore.isAdmin" class="nav-item">
                        <router-link class="nav-link" to="/dashboard/admin">
                            <i class="bi bi-shield-check me-1"></i>Admin Panel
                        </router-link>
                    </li>

                    <!-- For Buyers - Only show when buyer is logged in -->
                    <li v-if="authStore.isAuthenticated && authStore.isBuyer" class="nav-item">
                        <router-link class="nav-link" to="/dashboard/buyer">
                            <i class="bi bi-cart me-1"></i>Buyer Dashboard
                        </router-link>
                    </li>

                    <!-- Help/Support -->
                    <li class="nav-item">
                        <router-link class="nav-link" to="/help">
                            <i class="bi bi-question-circle me-1"></i>Help
                        </router-link>
                    </li>
                </ul>

                <!-- Right-aligned items -->
                <div class="d-flex align-items-center">
                    <!-- Desktop Search - Always show -->
                    <div class="d-none d-lg-block me-3">
                        <div class="input-group search-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input 
                                type="search" 
                                class="form-control" 
                                placeholder="Search products..."
                                v-model="searchQuery"
                                @keyup.enter="performSearch"
                                ref="searchInput"
                            >
                            <button 
                                v-if="searchQuery" 
                                class="btn btn-outline-secondary" 
                                @click="clearSearch"
                                type="button"
                            >
                                <i class="bi bi-x"></i>
                            </button>
                            <button 
                                class="btn btn-primary" 
                                @click="performSearch"
                                :disabled="searchLoading"
                                type="button"
                            >
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Mobile Search Toggle -->
                    <div class="d-lg-none me-3">
                        <button class="btn btn-outline-secondary btn-sm" @click="toggleMobileSearch">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>

                    <!-- User Account -->
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                           id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5"></i>
                            <span class="d-none d-md-inline ms-2">Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <!-- Not Authenticated -->
                            <template v-if="!authStore.isAuthenticated">
                                <li>
                                    <router-link class="dropdown-item" to="/login">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </router-link>
                                </li>
                                <li>
                                    <router-link class="dropdown-item" to="/register">
                                        <i class="bi bi-person-plus me-2"></i>Register
                                    </router-link>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <router-link class="dropdown-item" to="/register/seller">
                                        <i class="bi bi-shop me-2"></i>Become a Seller
                                    </router-link>
                                </li>
                            </template>
                            
                            <!-- Authenticated User -->
                            <template v-else>
                                <li class="dropdown-header">
                                    <small class="text-muted">Welcome, {{ authStore.user?.name }}</small>
                                </li>
                                <li>
                                    <router-link class="dropdown-item" to="/dashboard/seller">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                    </router-link>
                                </li>
                                <li v-if="authStore.isSeller">
                                    <router-link class="dropdown-item" to="/my-products">
                                        <i class="bi bi-grid me-2"></i>My Products
                                    </router-link>
                                </li>
                                <li v-if="authStore.isSeller">
                                    <router-link class="dropdown-item" to="/products/create">
                                        <i class="bi bi-plus-circle me-2"></i>Add Product
                                    </router-link>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <router-link class="dropdown-item" to="/profile">
                                        <i class="bi bi-person me-2"></i>Profile
                                    </router-link>
                                </li>
                                <li>
                                    <router-link class="dropdown-item" to="/messages">
                                        <i class="bi bi-chat-dots me-2"></i>Messages
                                        <span class="badge bg-primary rounded-pill ms-2">3</span>
                                    </router-link>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <button class="dropdown-item text-danger" @click="logout">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </li>
                            </template>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div v-if="showMobileSearch" class="mobile-search-container d-lg-none">
            <div class="container">
                <div class="search-container">
                    <div class="input-group mb-2">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input 
                            type="search" 
                            class="form-control" 
                            placeholder="Search for anything..."
                            v-model="mobileSearchQuery"
                            @keyup.enter="performMobileSearch"
                            ref="mobileSearchInput"
                        >
                        <button 
                            v-if="mobileSearchQuery" 
                            class="btn btn-outline-secondary" 
                            @click="clearMobileSearch"
                            type="button"
                        >
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button 
                            class="btn btn-primary btn-sm" 
                            @click="performMobileSearch"
                            :disabled="searchLoading"
                        >
                            <i class="bi bi-search me-1"></i>Search
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Loading Overlay -->
        <div v-if="searchLoading" class="search-loading-overlay">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Searching...</span>
            </div>
            <p class="mt-2">Searching products...</p>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed, onMounted, nextTick } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { useAuthStore } from '../../stores/auth'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

// Search states
const searchQuery = ref('')
const mobileSearchQuery = ref('')
const showMobileSearch = ref(false)
const searchLoading = ref(false)

// Refs
const searchInput = ref(null)
const mobileSearchInput = ref(null)

// Computed property for navbar class based on user type
const navbarClass = computed(() => {
    if (!authStore.isAuthenticated) {
        return 'bg-gradient-navbar-public'
    }
    switch (authStore.user?.user_type) {
        case 'admin': return 'bg-gradient-navbar-admin'
        case 'seller': return 'bg-gradient-navbar-seller'
        case 'buyer': return 'bg-gradient-navbar-buyer'
        default: return 'bg-gradient-navbar-public'
    }
})

// Check for search query in URL
onMounted(() => {
    if (route.query.search) {
        searchQuery.value = route.query.search
        mobileSearchQuery.value = route.query.search
    }
})

// Toggle mobile search
const toggleMobileSearch = () => {
    showMobileSearch.value = !showMobileSearch.value
    if (showMobileSearch.value) {
        nextTick(() => {
            mobileSearchInput.value?.focus()
        })
    }
}

// Perform search
const performSearch = async () => {
    if (!searchQuery.value.trim() && !mobileSearchQuery.value.trim()) return
    
    searchLoading.value = true
    
    try {
        const query = searchQuery.value || mobileSearchQuery.value
        if (query.trim()) {
            router.push(`/products?search=${encodeURIComponent(query.trim())}`)
        }
        
        // Hide mobile search if open
        if (showMobileSearch.value) {
            showMobileSearch.value = false
        }
        
    } catch (error) {
        console.error('Search error:', error)
    } finally {
        searchLoading.value = false
    }
}

// Mobile search
const performMobileSearch = () => {
    searchQuery.value = mobileSearchQuery.value
    performSearch()
}

// Clear search
const clearSearch = () => {
    searchQuery.value = ''
    mobileSearchQuery.value = ''
    router.push('/products')
}

const clearMobileSearch = () => {
    mobileSearchQuery.value = ''
    searchQuery.value = ''
}

// Logout
const logout = async () => {
    await authStore.logout()
    router.push('/login')
}
</script>

<style scoped>
/* Professional Gradient Backgrounds */
.bg-gradient-navbar-public {
    background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.bg-gradient-navbar-admin {
    background: linear-gradient(135deg, #8B0000 0%, #B22222 100%);
    box-shadow: 0 4px 20px rgba(139, 0, 0, 0.2);
}

.bg-gradient-navbar-seller {
    background: linear-gradient(135deg, #006400 0%, #228B22 100%);
    box-shadow: 0 4px 20px rgba(0, 100, 0, 0.2);
}

.bg-gradient-navbar-buyer {
    background: linear-gradient(135deg, #191970 0%, #4169E1 100%);
    box-shadow: 0 4px 20px rgba(25, 25, 112, 0.2);
}

/* Navbar Base Styles */
.navbar {
    padding: 0.8rem 0;
    transition: all 0.3s ease;
    z-index: 1030;
}

.navbar-brand {
    font-size: 1.5rem;
    font-weight: 700;
    color: white !important;
    transition: all 0.3s ease;
}

.navbar-brand:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

/* Nav Items */
.nav-link {
    font-weight: 500;
    color: rgba(255, 255, 255, 0.9) !important;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    transition: all 0.3s ease;
    margin: 0 2px;
    font-size: 0.95rem;
}

.nav-link:hover, .nav-link.router-link-exact-active {
    color: white !important;
    background-color: rgba(255, 255, 255, 0.15);
    transform: translateY(-1px);
}

.nav-link.router-link-exact-active {
    font-weight: 600;
    background-color: rgba(255, 255, 255, 0.2);
}

/* Dropdown Styles */
.dropdown-menu {
    border: none;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
    border-radius: 10px;
    padding: 0.5rem 0;
    margin-top: 0.5rem;
    animation: fadeIn 0.3s ease;
    min-width: 220px;
    border: 1px solid rgba(0, 0, 0, 0.1);
}

.dropdown-item {
    padding: 0.6rem 1.5rem;
    color: #495057;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.dropdown-item:hover {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white !important;
    transform: translateX(5px);
}

.dropdown-item i {
    width: 20px;
}

.dropdown-header {
    padding: 0.5rem 1.5rem;
    color: #6c757d;
    font-size: 0.85rem;
}

.dropdown-divider {
    margin: 0.5rem 0;
}

/* Search Styles */
.search-group {
    position: relative;
    min-width: 300px;
    border-radius: 25px;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.3);
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.search-group:focus-within {
    border-color: white;
    box-shadow: 0 0 0 0.25rem rgba(255, 255, 255, 0.25);
    transform: translateY(-1px);
}

.search-group .form-control {
    border: none;
    padding-left: 0;
    background: transparent;
    color: white;
}

.search-group .form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.search-group .form-control:focus {
    box-shadow: none;
    background: transparent;
}

.search-group .input-group-text {
    background: transparent;
    border: none;
    color: white;
}

.search-group .btn-primary {
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
    transition: all 0.3s ease;
}

.search-group .btn-primary:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

.search-group .btn-outline-secondary {
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
}

/* Mobile Search */
.mobile-search-container {
    background: rgba(0, 0, 0, 0.8);
    backdrop-filter: blur(10px);
    padding: 1rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.search-container {
    background: rgba(255, 255, 255, 0.1);
    padding: 1rem;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.search-container .form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
}

.search-container .form-control::placeholder {
    color: rgba(255, 255, 255, 0.7);
}

.search-container .input-group-text {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: white;
}

/* Contact Button */
.btn-outline-success {
    border-color: rgba(255, 255, 255, 0.5);
    color: white;
    background: rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}

.btn-outline-success:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: white;
    transform: translateY(-1px);
}

/* Search Loading Overlay */
.search-loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.7);
    backdrop-filter: blur(5px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 2000;
    color: white;
}

/* Animations */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Styles */
@media (max-width: 991.98px) {
    .navbar-collapse {
        padding: 1rem 0;
        background: inherit;
        border-radius: 0 0 15px 15px;
    }
    
    .nav-item {
        margin: 5px 0;
    }
    
    .dropdown-menu {
        background: white;
        border: 1px solid #dee2e6;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-left: 1rem;
    }
    
    .search-group {
        min-width: 100%;
        margin-bottom: 1rem;
    }
    
    /* Mobile-specific styles for dropdown items */
    .navbar-collapse .dropdown-item {
        color: #495057 !important;
    }
    
    .navbar-collapse .dropdown-item:hover {
        color: white !important;
    }
}

@media (max-width: 768px) {
    .navbar-brand {
        font-size: 1.3rem;
    }
    
    .nav-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.9rem;
    }
    
    .search-container {
        padding: 0.75rem;
    }
}

@media (max-width: 576px) {
    .navbar-brand span {
        display: none;
    }
    
    .nav-link span {
        display: none;
    }
    
    .nav-link i {
        margin-right: 0;
        font-size: 1.2rem;
    }
    
    .btn-outline-success span {
        display: none;
    }
    
    .btn-outline-success i {
        margin-right: 0;
    }
}

/* Badge styles */
.badge {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
}

/* Toggler button color for different themes */
.bg-gradient-navbar-public .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.bg-gradient-navbar-admin .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.bg-gradient-navbar-seller .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}

.bg-gradient-navbar-buyer .navbar-toggler {
    border-color: rgba(255, 255, 255, 0.3);
    color: white;
}
</style>