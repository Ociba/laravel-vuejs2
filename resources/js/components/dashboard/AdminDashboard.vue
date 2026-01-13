<template>
    <div class="admin-dashboard">
        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-gradient-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Total Users</h6>
                                <h2 class="mb-0">{{ stats.totalUsers || 0 }}</h2>
                            </div>
                            <i class="bi bi-people fs-1 opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="opacity-75">
                                <i class="bi bi-arrow-up me-1"></i>
                                {{ stats.newUsers || 0 }} new this month
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-gradient-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Total Products</h6>
                                <h2 class="mb-0">{{ stats.totalProducts || 0 }}</h2>
                            </div>
                            <i class="bi bi-box-seam fs-1 opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="opacity-75">
                                {{ stats.availableProducts || 0 }} available
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-gradient-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Active Sellers</h6>
                                <h2 class="mb-0">{{ stats.activeSellers || 0 }}</h2>
                            </div>
                            <i class="bi bi-shop fs-1 opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="opacity-75">
                                {{ stats.newSellers || 0 }} new sellers
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm bg-gradient-warning text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-white-50 mb-1">Total Revenue</h6>
                                <h2 class="mb-0">UGX {{ stats.totalRevenue || 0 }}</h2>
                            </div>
                            <i class="bi bi-cash-coin fs-1 opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="opacity-75">
                                Last 30 days
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 pb-0">
                        <h5 class="card-title mb-0">Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3" v-for="action in quickActions" :key="action.id">
                                <router-link :to="action.route" class="quick-action-card">
                                    <div class="action-icon" :class="action.bgClass">
                                        <i :class="action.icon"></i>
                                    </div>
                                    <h6 class="mt-3 mb-1">{{ action.title }}</h6>
                                    <p class="text-muted small mb-0">{{ action.description }}</p>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities & User Management -->
        <div class="row g-4">
            <!-- Recent Activities -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Activities</h5>
                        <button class="btn btn-sm btn-outline-primary">View All</button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Activity</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="activity in recentActivities" :key="activity.id">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img :src="activity.user.image" 
                                                     class="rounded-circle me-2" 
                                                     width="30" 
                                                     height="30"
                                                     alt="User">
                                                <span>{{ activity.user.name }}</span>
                                            </div>
                                        </td>
                                        <td>{{ activity.description }}</td>
                                        <td>{{ activity.time }}</td>
                                        <td>
                                            <span class="badge" :class="activity.statusClass">
                                                {{ activity.status }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Management -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">User Management</h5>
                        <router-link to="/admin/users" class="btn btn-sm btn-outline-primary">Manage</router-link>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <span>Sellers</span>
                                    <span class="fw-semibold">{{ stats.sellerCount || 0 }}</span>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-success" 
                                         :style="{ width: (stats.sellerCount / stats.totalUsers * 100) + '%' }"></div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <span>Buyers</span>
                                    <span class="fw-semibold">{{ stats.buyerCount || 0 }}</span>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-info" 
                                         :style="{ width: (stats.buyerCount / stats.totalUsers * 100) + '%' }"></div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <span>Active Users</span>
                                    <span class="fw-semibold">{{ stats.activeUsers || 0 }}</span>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-primary" 
                                         :style="{ width: (stats.activeUsers / stats.totalUsers * 100) + '%' }"></div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex justify-content-between">
                                    <span>New This Month</span>
                                    <span class="fw-semibold">{{ stats.newUsers || 0 }}</span>
                                </div>
                                <div class="progress mt-2" style="height: 5px;">
                                    <div class="progress-bar bg-warning" 
                                         :style="{ width: (stats.newUsers / stats.totalUsers * 100) + '%' }"></div>
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
import { ref, onMounted } from 'vue'
import { useAuthStore } from '../../stores/auth'

const authStore = useAuthStore()

// Stats data
const stats = ref({
    totalUsers: 0,
    totalProducts: 0,
    activeSellers: 0,
    totalRevenue: 0,
    availableProducts: 0,
    newUsers: 0,
    newSellers: 0,
    sellerCount: 0,
    buyerCount: 0,
    activeUsers: 0
})

// Quick actions for admin
const quickActions = ref([
    {
        id: 1,
        title: 'Manage Users',
        description: 'View and manage all users',
        icon: 'bi bi-people',
        route: '/admin/users',
        bgClass: 'bg-primary'
    },
    {
        id: 2,
        title: 'Manage Products',
        description: 'Approve or remove products',
        icon: 'bi bi-box-seam',
        route: '/admin/products',
        bgClass: 'bg-success'
    },
    {
        id: 3,
        title: 'View Reports',
        description: 'Sales and analytics reports',
        icon: 'bi bi-graph-up',
        route: '/admin/reports',
        bgClass: 'bg-info'
    },
    {
        id: 4,
        title: 'Site Settings',
        description: 'Configure platform settings',
        icon: 'bi bi-gear',
        route: '/admin/settings',
        bgClass: 'bg-warning'
    }
])

// Recent activities
const recentActivities = ref([
    {
        id: 1,
        user: { name: 'John Seller', image: '/images/avatar1.jpg' },
        description: 'Added new product: iPhone 13',
        time: '2 hours ago',
        status: 'Approved',
        statusClass: 'bg-success'
    },
    {
        id: 2,
        user: { name: 'Jane Buyer', image: '/images/avatar2.jpg' },
        description: 'Registered new account',
        time: '5 hours ago',
        status: 'Active',
        statusClass: 'bg-primary'
    },
    {
        id: 3,
        user: { name: 'Mike Seller', image: '/images/avatar3.jpg' },
        description: 'Updated product listing',
        time: '1 day ago',
        status: 'Pending',
        statusClass: 'bg-warning'
    },
    {
        id: 4,
        user: { name: 'Sarah Admin', image: '/images/avatar4.jpg' },
        description: 'Deleted suspicious user',
        time: '2 days ago',
        status: 'Completed',
        statusClass: 'bg-danger'
    }
])

// Fetch dashboard stats
const fetchDashboardStats = async () => {
    try {
        // In production, you would fetch this from your API
        // const response = await axios.get('/api/admin/dashboard-stats')
        // stats.value = response.data
        
        // Mock data for now
        stats.value = {
            totalUsers: 156,
            totalProducts: 423,
            activeSellers: 45,
            totalRevenue: '2,450,000',
            availableProducts: 389,
            newUsers: 12,
            newSellers: 3,
            sellerCount: 45,
            buyerCount: 111,
            activeUsers: 142
        }
    } catch (error) {
        console.error('Error fetching dashboard stats:', error)
    }
}

onMounted(() => {
    fetchDashboardStats()
})
</script>

<style scoped>
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #6610f2);
}

.bg-gradient-success {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.bg-gradient-info {
    background: linear-gradient(135deg, #17a2b8, #0dcaf0);
}

.bg-gradient-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14);
}

.quick-action-card {
    display: block;
    padding: 1.5rem;
    text-align: center;
    border-radius: 10px;
    background: #f8f9fa;
    text-decoration: none;
    color: inherit;
    transition: all 0.3s ease;
    height: 100%;
}

.quick-action-card:hover {
    background: white;
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.action-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.5rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.9rem;
}

.table td {
    vertical-align: middle;
}

.progress {
    background-color: #e9ecef;
    border-radius: 10px;
}

.progress-bar {
    border-radius: 10px;
}
</style>