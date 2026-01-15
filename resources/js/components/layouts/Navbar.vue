<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <!-- Logo/Brand -->
            <router-link class="navbar-brand fw-bold text-primary" to="/">
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
                    <li class="nav-item">
                        <router-link class="nav-link" to="/">
                            <i class="bi bi-house-door me-1"></i>Home
                        </router-link>
                    </li>
                    
                    <!-- Products -->
                    <li class="nav-item">
                        <router-link class="nav-link" to="/products">
                            <i class="bi bi-grid me-1"></i>All Products
                        </router-link>
                    </li>

                    <!-- Categories Dropdown -->
                    <li class="nav-item dropdown">
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

                    <!-- Condition Filter -->
                    <li class="nav-item dropdown">
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


                     <!-- For Admin -->
                     <li class="nav-item" v-if="authStore.isAuthenticated && authStore.isAdmin">
                        <router-link class="nav-link" to="/dashboard/admin">
                            <i class="bi bi-speedometer2 me-1"></i>Admin Dashboard
                        </router-link>
                    </li>

                    <!-- For Sellers -->
                    <li class="nav-item" v-if="authStore.isAuthenticated && authStore.isSeller">
                        <router-link class="nav-link" to="/dashboard/seller">
                            <i class="bi bi-speedometer2 me-1"></i>Seller Dashboard
                        </router-link>
                    </li>

                    <!-- For Buyers -->
                    <li class="nav-item" v-if="authStore.isAuthenticated && authStore.isBuyer">
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

                <!-- Right-aligned items (Search, User) -->
                <div class="d-flex align-items-center">
                    <!-- Desktop Search -->
                    <div class="d-none d-lg-block me-3">
                        <div class="input-group search-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input 
                                type="search" 
                                class="form-control border-start-0" 
                                placeholder="Search products, sellers..."
                                v-model="searchQuery"
                                @keyup.enter="performSearch"
                                @input="onSearchInput"
                                ref="searchInput"
                            >
                            <button 
                                v-if="searchQuery" 
                                class="btn btn-outline-secondary border-start-0 text-white" 
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
                                <i class="bi bi-search"></i> Search
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
                                    <router-link class="dropdown-item" to="/dashboard">
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
                                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                                    </router-link>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <router-link class="dropdown-item" to="/profile">
                                        <i class="bi bi-person me-2"></i>My Profile
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

        <!-- Mobile Search Bar (hidden by default) -->
        <div v-if="showMobileSearch" class="bg-light border-top py-3 d-lg-none">
            <div class="container">
                <div class="search-container">
                    <div class="input-group mb-2">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search text-muted"></i>
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
                            class="btn btn-outline-secondary text-white" 
                            @click="clearMobileSearch"
                            type="button"
                        >
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button 
                            class="btn btn-primary btn-sm text-white" 
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
import { ref, onMounted, nextTick } from 'vue'
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

// Handle search input
const onSearchInput = () => {
    // Search suggestions logic can go here
}

// Logout
const logout = async () => {
    await authStore.logout()
    router.push('/login')
}
</script>

<style scoped>
.navbar {
    padding: 0.8rem 0;
    transition: all 0.3s ease;
    z-index: 1030;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.navbar-brand {
    font-size: 1.5rem;
    color: #2c3e50;
    font-weight: 700;
}

.navbar-brand:hover {
    color: #007bff;
}

.nav-link {
    font-weight: 500;
    color: #555;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    transition: all 0.3s ease;
    margin: 0 2px;
    font-size: 0.95rem;
}

.nav-link:hover, .nav-link.router-link-exact-active {
    color: #007bff;
    background-color: rgba(0, 123, 255, 0.08);
    transform: translateY(-1px);
}

.nav-link.router-link-exact-active {
    font-weight: 600;
}

/* Search Styles */
.search-group {
    position: relative;
    min-width: 300px;
    border-radius: 2px;
    overflow: visible;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.search-group:focus-within {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    transform: translateY(-1px);
}

.search-group .form-control {
    border: none;
    padding-left: 0;
    background: transparent;
}

.search-group .form-control:focus {
    box-shadow: none;
    background: transparent;
}

.search-group .input-group-text {
    background: transparent;
    border: none;
    color: #6c757d;
}

.search-group .btn {
    border-radius: 0 2px 2px 0;
    padding: 0.5rem 1.5rem;
}

/* Mobile Search */
.search-container {
    background: white;
    padding: 1rem;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

/* Dropdown Styles */
.dropdown-menu {
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border-radius: 10px;
    padding: 0.5rem 0;
    margin-top: 0.5rem;
    animation: fadeIn 0.3s ease;
    min-width: 220px;
}

.dropdown-item {
    padding: 0.6rem 1.5rem;
    color: #495057;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.dropdown-item:hover {
    background-color: #007bff;
    color: white;
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

/* Search Loading Overlay */
.search-loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    z-index: 2000;
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
    }
    
    .nav-item {
        margin: 5px 0;
    }
    
    .dropdown-menu {
        border: 1px solid #dee2e6;
        box-shadow: none;
        margin-left: 1rem;
    }
    
    .search-group {
        min-width: 100%;
        margin-bottom: 1rem;
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
}

/* Badge styles */
.badge {
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
}
</style>