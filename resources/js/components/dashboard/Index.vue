<template>
    <div class="dashboard-container">
        <Navbar />

        <!-- Dashboard Header -->
        <div class="dashboard-header bg-primary text-white py-4">
            <div class="containe">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h1 class="h2 mb-2">Dashboard</h1>
                        <p class="mb-0">Welcome back, {{ user.name }}!</p>
                        <small class="opacity-75">
                            <i class="bi bi-person-badge me-1"></i>
                            {{ userTypeLabel }}
                        </small>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="badge bg-light text-primary px-3 py-2 fs-6">
                            <i class="bi bi-calendar-check me-2"></i>
                            {{ currentDate }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="containe py-4">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="dashboard-sidebar card shadow-sm border-0">
                        <div class="card-body">
                            <!-- User Profile Summary -->
                            <div class="user-summary text-center mb-4">
                                <div class="avatar mb-3">
                                    <img :src="user.profile_image || '/images/default-avatar.png'"
                                        class="rounded-circle" width="80" height="80" alt="Profile">
                                </div>
                                <h5 class="mb-1">{{ user.name }}</h5>
                                <p class="text-muted small mb-2">{{ user.email }}</p>
                                <span class="badge" :class="userTypeBadgeClass">
                                    {{ userTypeLabel }}
                                </span>
                            </div>

                            <!-- Navigation -->
                            <nav class="dashboard-nav">
                                <div class="nav flex-column">
                                    <router-link v-if="authStore.isSeller" to="/dashboard/seller" class="nav-link"
                                        :class="{ active: $route.name === 'seller-dashboard' }">
                                        <i class="bi bi-shop me-2"></i>
                                        Seller Center
                                    </router-link>
                                    <router-link to="/dashboard" class="nav-link"
                                        :class="{ active: $route.name === 'role-dashboard' }">
                                        <i class="bi bi-speedometer2 me-2"></i>
                                        Dashboard
                                    </router-link>

                                    <router-link v-if="authStore.isAdmin" to="/dashboard/admin" class="nav-link"
                                        :class="{ active: $route.name === 'admin-dashboard' }">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Admin Panel
                                    </router-link>
                                    <router-link v-if="authStore.isBuyer" to="/dashboard/buyer" class="nav-link"
                                        :class="{ active: $route.name === 'buyer-dashboard' }">
                                        <i class="bi bi-cart me-2"></i>
                                        Buyer Center
                                    </router-link>

                                    <div class="nav-divider"></div>

                                    <router-link to="/categories" class="nav-link">
                                        <i class="bi bi-plus-circle"></i>
                                        Categories
                                    </router-link>

                                    <router-link to="/types" class="nav-link">
                                        <i class="bi bi-plus-circle"></i>
                                        Types
                                    </router-link>

                                    <router-link to="/colors" class="nav-link">
                                        <i class="bi bi-plus-circle"></i>
                                        Colors
                                    </router-link>

                                    <router-link v-if="authStore.isAdmin" to="/measures" class="nav-link">
                                        <i class="bi bi-plus-circle"></i>
                                        Measures
                                    </router-link>

                                    <router-link to="/locations" class="nav-link">
                                        <i class="bi bi-plus-circle"></i>
                                        Location
                                    </router-link> 

                                    <router-link to="/adcharges" class="nav-link">
                                        <i class="bi bi-plus-circle"></i>
                                        AdCharges
                                    </router-link>

                                    <router-link to="/news-subscription" class="nav-link">
                                        <i class="bi bi-plus-circle"></i>
                                        News Subscription
                                    </router-link>

                                    <router-link v-if="authStore.isSeller" to="/my-products" class="nav-link">
                                        <i class="bi bi-grid"></i>
                                        <span>My Products</span>
                                        <span class="badge count-badge">{{ productCount }}</span>
                                    </router-link>

                                    <router-link to="/messages" class="nav-link">
                                        <i class="bi bi-chat-dots"></i>
                                        <span>Messages</span>
                                        <span class="badge count-badge">3</span>
                                    </router-link>

                                    <router-link to="/profile" class="nav-link">
                                        <i class="bi bi-person"></i>
                                        <span>Profile</span>
                                    </router-link>

                                    <div class="menu-divider"></div>

                                    <router-link to="/help" class="nav-link">
                                        <i class="bi bi-question-circle"></i>
                                        <span>Help & Support</span>
                                    </router-link>

                                    <div class="nav-divider"></div>

                                    <button class="nav-link text-danger" @click="handleLogout">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Logout
                                    </button>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-lg-9">
                    <!-- Role-based dashboard -->
                    <router-view />
                </div>
            </div>
        </div>

        <AppFooter />
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../../stores/auth'
import Navbar from '../layouts/Navbar.vue'
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()
const authStore = useAuthStore()

// Get current user
const user = computed(() => authStore.user || {})

// Get user type label
const userTypeLabel = computed(() => {
    switch (user.value.user_type) {
        case 'admin': return 'Administrator'
        case 'seller': return 'Seller'
        case 'buyer': return 'Buyer'
        default: return 'User'
    }
})

// Get badge class based on user type
const userTypeBadgeClass = computed(() => {
    switch (user.value.user_type) {
        case 'admin': return 'bg-danger'
        case 'seller': return 'bg-success'
        case 'buyer': return 'bg-info'
        default: return 'bg-secondary'
    }
})

// Get current date
const currentDate = computed(() => {
    return new Date().toLocaleDateString('en-US', {
        weekday: 'long',
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    })
})

// Check authentication on mount
onMounted(async () => {
    if (!authStore.isAuthenticated) {
        const isAuthenticated = await authStore.checkAuth()
        if (!isAuthenticated) {
            router.push('/login')
        }
    }
})

// Handle logout
const handleLogout = async () => {
    if (confirm('Are you sure you want to logout?')) {
        await authStore.logout()
        router.push('/login')
    }
}
</script>

<style scoped>
.dashboard-container {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

.dashboard-header {
    background: linear-gradient(135deg, #007bff, #0056b3);
    margin-top: 56px;
    /* Account for fixed navbar */
}

.avatar img {
    object-fit: cover;
    border: 3px solid #007bff;
}

.dashboard-sidebar {
    position: sticky;
    margin-top: 3px;
}

.dashboard-nav .nav-link {
    color: #495057;
    padding: 0.75rem 1rem;
    border-radius: 8px;
    margin-bottom: 0.25rem;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.dashboard-nav .nav-link:hover {
    background-color: rgba(0, 123, 255, 0.1);
    color: #007bff;
    transform: translateX(5px);
}

.dashboard-nav .nav-link.active {
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    font-weight: 500;
}

.dashboard-nav .nav-link.active:hover {
    background: linear-gradient(135deg, #0056b3, #004085);
    transform: none;
}

.dashboard-nav .nav-link.text-danger:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.nav-divider {
    height: 1px;
    background-color: #dee2e6;
    margin: 1rem 0;
}

.badge {
    padding: 0.5em 0.75em;
    font-weight: 500;
}

/* Responsive adjustments */
@media (max-width: 991.98px) {
    .dashboard-header {
        margin-top: 0;
    }
}

@media (max-width: 768px) {
    .dashboard-sidebar {
        position: static;
        margin-bottom: 1rem;
    }
}
</style>