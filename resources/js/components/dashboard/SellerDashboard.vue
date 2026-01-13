<template>
    <div class="seller-dashboard">
        <!-- Welcome Banner -->
        <div class="welcome-banner bg-gradient-success text-white rounded-3 p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">Welcome to Seller Center!</h3>
                    <p class="mb-0">Manage your products, track sales, and grow your business.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <router-link to="/products/create" class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                    </router-link>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Products</h6>
                                <h2 class="mb-0 text-primary">{{ stats.totalProducts || 0 }}</h2>
                            </div>
                            <i class="bi bi-box-seam fs-1 text-primary opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                {{ stats.availableProducts || 0 }} available
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Views</h6>
                                <h2 class="mb-0 text-info">{{ stats.totalViews || 0 }}</h2>
                            </div>
                            <i class="bi bi-eye fs-1 text-info opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                {{ stats.todayViews || 0 }} today
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Inquiries</h6>
                                <h2 class="mb-0 text-warning">{{ stats.totalInquiries || 0 }}</h2>
                            </div>
                            <i class="bi bi-chat-dots fs-1 text-warning opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                {{ stats.newInquiries || 0 }} new
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="text-muted mb-1">Total Revenue</h6>
                                <h2 class="mb-0 text-success">UGX {{ stats.totalRevenue || 0 }}</h2>
                            </div>
                            <i class="bi bi-cash-coin fs-1 text-success opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
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
                            <div class="col-md-4" v-for="action in quickActions" :key="action.id">
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

        <!-- Recent Products & Recent Inquiries -->
        <div class="row g-4">
            <!-- Recent Products -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Products</h5>
                        <router-link to="/my-products" class="btn btn-sm btn-outline-primary">
                            View All
                        </router-link>
                    </div>
                    <div class="card-body">
                        <div v-if="recentProducts.length === 0" class="text-center py-5">
                            <i class="bi bi-box-seam display-4 text-muted mb-3"></i>
                            <h5>No products yet</h5>
                            <p class="text-muted mb-4">Start selling by adding your first product</p>
                            <router-link to="/products/create" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Add First Product
                            </router-link>
                        </div>
                        
                        <div v-else class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Views</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in recentProducts" :key="product.id">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img :src="product.image" 
                                                     class="rounded me-2" 
                                                     width="40" 
                                                     height="40"
                                                     alt="Product">
                                                <div>
                                                    <div class="fw-semibold">{{ product.name }}</div>
                                                    <small class="text-muted">{{ product.created_at }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>UGX {{ product.price }}</td>
                                        <td>
                                            <span class="badge" :class="product.statusClass">
                                                {{ product.status }}
                                            </span>
                                        </td>
                                        <td>{{ product.views }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-outline-primary">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <button class="btn btn-outline-success">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Inquiries -->
            <div class="col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Inquiries</h5>
                        <router-link to="/messages" class="btn btn-sm btn-outline-primary">
                            View All
                        </router-link>
                    </div>
                    <div class="card-body">
                        <div v-if="recentInquiries.length === 0" class="text-center py-4">
                            <i class="bi bi-chat-dots display-4 text-muted mb-3"></i>
                            <p class="text-muted">No inquiries yet</p>
                        </div>
                        
                        <div v-else>
                            <div class="list-group list-group-flush">
                                <div v-for="inquiry in recentInquiries" :key="inquiry.id" 
                                     class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <img :src="inquiry.buyer.image" 
                                                 class="rounded-circle" 
                                                 width="40" 
                                                 height="40"
                                                 alt="Buyer">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <h6 class="mb-1">{{ inquiry.buyer.name }}</h6>
                                                <small class="text-muted">{{ inquiry.time }}</small>
                                            </div>
                                            <p class="mb-1 small text-truncate">{{ inquiry.message }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <small class="text-primary">
                                                    <i class="bi bi-phone me-1"></i>
                                                    {{ inquiry.buyer.phone }}
                                                </small>
                                                <button class="btn btn-sm btn-outline-success">
                                                    <i class="bi bi-reply"></i> Reply
                                                </button>
                                            </div>
                                        </div>
                                    </div>
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

// Stats data
const stats = ref({
    totalProducts: 0,
    availableProducts: 0,
    totalViews: 0,
    todayViews: 0,
    totalInquiries: 0,
    newInquiries: 0,
    totalRevenue: 0
})

// Quick actions for seller
const quickActions = ref([
    {
        id: 1,
        title: 'Add Product',
        description: 'List new product for sale',
        icon: 'bi bi-plus-circle',
        route: '/products/create',
        bgClass: 'bg-primary'
    },
    {
        id: 2,
        title: 'My Products',
        description: 'Manage your product listings',
        icon: 'bi bi-grid',
        route: '/my-products',
        bgClass: 'bg-success'
    },
    {
        id: 3,
        title: 'View Messages',
        description: 'Check buyer inquiries',
        icon: 'bi bi-chat-dots',
        route: '/messages',
        bgClass: 'bg-info'
    },
    {
        id: 4,
        title: 'Sales Report',
        description: 'View sales analytics',
        icon: 'bi bi-graph-up',
        route: '/seller/reports',
        bgClass: 'bg-warning'
    },
    {
        id: 5,
        title: 'Profile',
        description: 'Update your seller profile',
        icon: 'bi bi-person',
        route: '/profile',
        bgClass: 'bg-purple'
    },
    {
        id: 6,
        title: 'Help & Support',
        description: 'Get help and support',
        icon: 'bi bi-question-circle',
        route: '/help',
        bgClass: 'bg-secondary'
    }
])

// Recent products
const recentProducts = ref([
    {
        id: 1,
        name: 'iPhone 13 Pro Max',
        image: '/upload/products/iphone.jpg',
        price: '2,500,000',
        status: 'Available',
        statusClass: 'bg-success',
        views: 156,
        created_at: '2 days ago'
    },
    {
        id: 2,
        name: 'Samsung Galaxy S22',
        image: '/upload/products/samsung.jpg',
        price: '1,800,000',
        status: 'Available',
        statusClass: 'bg-success',
        views: 89,
        created_at: '5 days ago'
    },
    {
        id: 3,
        name: 'MacBook Pro M1',
        image: '/upload/products/macbook.jpg',
        price: '4,200,000',
        status: 'Sold',
        statusClass: 'bg-danger',
        views: 234,
        created_at: '1 week ago'
    }
])

// Recent inquiries
const recentInquiries = ref([
    {
        id: 1,
        buyer: {
            name: 'John Doe',
            image: '/images/avatar1.jpg',
            phone: '+256 712 345 678'
        },
        message: 'Is the iPhone still available? What\'s the best price?',
        time: '2 hours ago'
    },
    {
        id: 2,
        buyer: {
            name: 'Jane Smith',
            image: '/images/avatar2.jpg',
            phone: '+256 777 888 999'
        },
        message: 'Can I come to see the laptop tomorrow?',
        time: '1 day ago'
    }
])

// Fetch seller dashboard stats
const fetchSellerStats = async () => {
    try {
        // In production, fetch from API
        // const response = await axios.get('/api/seller/dashboard-stats')
        // stats.value = response.data
        
        // Mock data for now
        stats.value = {
            totalProducts: 12,
            availableProducts: 8,
            totalViews: 1234,
            todayViews: 45,
            totalInquiries: 23,
            newInquiries: 2,
            totalRevenue: '8,500,000'
        }
    } catch (error) {
        console.error('Error fetching seller stats:', error)
    }
}

onMounted(() => {
    fetchSellerStats()
})
</script>

<style scoped>
.welcome-banner {
    background: linear-gradient(135deg, #28a745, #20c997);
}

.bg-purple {
    background-color: #6f42c1;
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

.badge {
    padding: 0.25em 0.6em;
    font-weight: 500;
    font-size: 0.75rem;
}

.text-truncate {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style>