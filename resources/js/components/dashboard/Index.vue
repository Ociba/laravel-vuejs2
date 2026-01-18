<template>
    <div class="dashboard-container">
        <Navbar />

        <!-- Dashboard Header -->
        <div class="dashboard-header bg-primary text-white py-4">
            <div class="container">
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
                        <div class="card-bod">

                            <!-- Navigation -->
                            <SellerSidebar />
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
import SellerSidebar from '../layouts/SellerSidebar.vue'
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