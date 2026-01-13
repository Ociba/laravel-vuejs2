<template>
    <div class="buyer-dashboard">
        <!-- Welcome Banner -->
        <div class="welcome-banner bg-gradient-info text-white rounded-3 p-4 mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h3 class="mb-2">Welcome to Buyer Center!</h3>
                    <p class="mb-0">Find amazing products, track your interests, and connect with sellers.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <router-link to="/products" class="btn btn-light btn-lg">
                        <i class="bi bi-search me-2"></i>Browse Products
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
                                <h6 class="text-muted mb-1">Viewed Products</h6>
                                <h2 class="mb-0 text-primary">{{ stats.viewedProducts || 0 }}</h2>
                            </div>
                            <i class="bi bi-eye fs-1 text-primary opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                Recently viewed items
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
                                <h6 class="text-muted mb-1">Saved Items</h6>
                                <h2 class="mb-0 text-success">{{ stats.savedItems || 0 }}</h2>
                            </div>
                            <i class="bi bi-bookmark-heart fs-1 text-success opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                Items in your wishlist
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
                                <h6 class="text-muted mb-1">Messages</h6>
                                <h2 class="mb-0 text-warning">{{ stats.totalMessages || 0 }}</h2>
                            </div>
                            <i class="bi bi-chat-dots fs-1 text-warning opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                {{ stats.unreadMessages || 0 }} unread
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
                                <h6 class="text-muted mb-1">Sellers Contacted</h6>
                                <h2 class="mb-0 text-info">{{ stats.sellersContacted || 0 }}</h2>
                            </div>
                            <i class="bi bi-people fs-1 text-info opacity-50"></i>
                        </div>
                        <div class="mt-3">
                            <small class="text-muted">
                                Active conversations
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

        <!-- Recent Activity & Recommended Products -->
        <div class="row g-4">
            <!-- Recent Activity -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Activity</h5>
                        <button class="btn btn-sm btn-outline-primary">View All</button>
                    </div>
                    <div class="card-body">
                        <div class="timeline">
                            <div v-for="activity in recentActivities" :key="activity.id" 
                                 class="timeline-item">
                                <div class="timeline-marker" :class="activity.markerClass">
                                    <i :class="activity.icon"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">{{ activity.title }}</h6>
                                    <p class="text-muted small mb-0">{{ activity.description }}</p>
                                    <small class="text-muted">{{ activity.time }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended Products -->
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recommended for You</h5>
                        <router-link to="/products" class="btn btn-sm btn-outline-primary">
                            Browse All
                        </router-link>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-6" v-for="product in recommendedProducts" :key="product.id">
                                <div class="product-card">
                                    <router-link :to="`/products/${product.id}`" class="product-link">
                                        <img :src="product.image" 
                                             class="product-image rounded" 
                                             alt="Product">
                                        <div class="product-info mt-2">
                                            <h6 class="product-title mb-1">{{ product.name }}</h6>
                                            <div class="product-price">UGX {{ product.price }}</div>
                                            <div class="product-seller small text-muted">
                                                <i class="bi bi-shop me-1"></i>{{ product.seller }}
                                            </div>
                                        </div>
                                    </router-link>
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
    viewedProducts: 0,
    savedItems: 0,
    totalMessages: 0,
    unreadMessages: 0,
    sellersContacted: 0
})

// Quick actions for buyer
const quickActions = ref([
    {
        id: 1,
        title: 'Browse Products',
        description: 'Find items to buy',
        icon: 'bi bi-search',
        route: '/products',
        bgClass: 'bg-primary'
    },
    {
        id: 2,
        title: 'Saved Items',
        description: 'View your wishlist',
        icon: 'bi bi-bookmark-heart',
        route: '/saved',
        bgClass: 'bg-success'
    },
    {
        id: 3,
        title: 'Messages',
        description: 'Chat with sellers',
        icon: 'bi bi-chat-dots',
        route: '/messages',
        bgClass: 'bg-info'
    },
    {
        id: 4,
        title: 'Profile',
        description: 'Update your profile',
        icon: 'bi bi-person',
        route: '/profile',
        bgClass: 'bg-warning'
    }
])

// Recent activities
const recentActivities = ref([
    {
        id: 1,
        title: 'Viewed Product',
        description: 'iPhone 13 Pro Max - UGX 2,500,000',
        time: '2 hours ago',
        icon: 'bi bi-eye',
        markerClass: 'bg-primary'
    },
    {
        id: 2,
        title: 'Saved Item',
        description: 'MacBook Pro M1 added to wishlist',
        time: '1 day ago',
        icon: 'bi bi-bookmark-heart',
        markerClass: 'bg-success'
    },
    {
        id: 3,
        title: 'Message Sent',
        description: 'Contacted seller about Samsung TV',
        time: '2 days ago',
        icon: 'bi bi-chat-dots',
        markerClass: 'bg-info'
    },
    {
        id: 4,
        title: 'Profile Updated',
        description: 'Updated phone number',
        time: '3 days ago',
        icon: 'bi bi-person',
        markerClass: 'bg-warning'
    }
])

// Recommended products
const recommendedProducts = ref([
    {
        id: 1,
        name: 'Wireless Headphones',
        image: '/upload/products/headphones.jpg',
        price: '150,000',
        seller: 'Tech Gadgets'
    },
    {
        id: 2,
        name: 'Smart Watch',
        image: '/upload/products/smartwatch.jpg',
        price: '350,000',
        seller: 'Wearable Tech'
    },
    {
        id: 3,
        name: 'Gaming Console',
        image: '/upload/products/console.jpg',
        price: '1,200,000',
        seller: 'Game World'
    },
    {
        id: 4,
        name: 'Digital Camera',
        image: '/upload/products/camera.jpg',
        price: '850,000',
        seller: 'Photo Store'
    }
])

// Fetch buyer dashboard stats
const fetchBuyerStats = async () => {
    try {
        // In production, fetch from API
        // const response = await axios.get('/api/buyer/dashboard-stats')
        // stats.value = response.data
        
        // Mock data for now
        stats.value = {
            viewedProducts: 24,
            savedItems: 8,
            totalMessages: 12,
            unreadMessages: 3,
            sellersContacted: 5
        }
    } catch (error) {
        console.error('Error fetching buyer stats:', error)
    }
}

onMounted(() => {
    fetchBuyerStats()
})
</script>

<style scoped>
.welcome-banner {
    background: linear-gradient(135deg, #17a2b8, #0dcaf0);
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

/* Timeline */
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 1.5rem;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.75rem;
}

.timeline-content {
    padding-left: 1rem;
    border-left: 2px solid #dee2e6;
    padding-bottom: 1rem;
}

.timeline-item:last-child .timeline-content {
    border-left-color: transparent;
    padding-bottom: 0;
}

/* Product Card */
.product-card {
    transition: all 0.3s ease;
}

.product-link {
    display: block;
    text-decoration: none;
    color: inherit;
}

.product-image {
    width: 100%;
    height: 120px;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-info {
    padding: 0.5rem 0;
}

.product-title {
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.3;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.product-price {
    font-weight: 700;
    color: #28a745;
    font-size: 0.9rem;
}

.product-seller {
    font-size: 0.8rem;
}
</style>