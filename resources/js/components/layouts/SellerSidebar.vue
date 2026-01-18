<template>
    <div class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="user-profile">
                <div class="profile-avatar">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="profile-info">
                    <h6>Seller Dashboard</h6>
                    <span class="badge seller-badge">
                        <i class="bi bi-shop me-1"></i>Professional Seller
                    </span>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <!-- Dashboard -->
            <router-link to="/dashboard/seller" class="menu-item">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </router-link>

            <!-- Management Items -->
            <router-link to="/categories" class="menu-item">
                <i class="bi bi-tags"></i>
                <span>Categories</span>
            </router-link>

            <router-link to="/types" class="menu-item">
                <i class="bi bi-grid-3x3-gap"></i>
                <span>Types</span>
            </router-link>

            <router-link to="/colors" class="menu-item">
                <i class="bi bi-palette"></i>
                <span>Colors</span>
            </router-link>

            <router-link to="/measures" class="menu-item">
                <i class="bi bi-rulers"></i>
                <span>Measures</span>
            </router-link>

            <router-link to="/locations" class="menu-item">
                <i class="bi bi-geo-alt"></i>
                <span>Location</span>
            </router-link>

            <router-link to="/adcharges" class="menu-item">
                <i class="bi bi-currency-dollar"></i>
                <span>AdCharges</span>
            </router-link>

            <router-link to="/news-subscription" class="menu-item">
                <i class="bi bi-envelope"></i>
                <span>News Subscriptions</span>
            </router-link>

            <!-- Products & Communication -->
            <router-link to="/my-products" class="menu-item">
                <i class="bi bi-box-seam"></i>
                <span>My Products</span>
                <span class="badge count-badge">{{ productCount }}</span>
            </router-link>

            <router-link to="/messages" class="menu-item">
                <i class="bi bi-chat-left-text"></i>
                <span>Messages</span>
                <span class="badge count-badge">3</span>
            </router-link>

            <router-link to="/profile" class="menu-item">
                <i class="bi bi-person-circle"></i>
                <span>Profile</span>
            </router-link>

            <div class="menu-divider"></div>

            <!-- Support -->
            <router-link to="/help" class="menu-item">
                <i class="bi bi-headset"></i>
                <span>Help & Support</span>
            </router-link>
        </div>

        <div class="sidebar-footer">
            <button class="btn btn-outline-danger w-100" @click="logout">
                <i class="bi bi-box-arrow-right me-2"></i>Logout
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'

const productCount = ref(12) // Replace with your actual product count

const logout = () => {
    // Your logout logic here
    console.log('Logging out...')
}
</script>

<style scoped>
/* Keep your existing structure, just enhance styling */
.dashboard-sidebar {
    width: 260px;
    background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
    color: white;
    display: flex;
    flex-direction: column;
    height: 100vh;
    position: sticky;
    top: 0;
    box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
}

/* Enhanced Header */
.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.2);
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.profile-avatar {
    width: 50px;
    height: 50px;
    background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    color: white;
    box-shadow: 0 4px 15px rgba(106, 17, 203, 0.3);
}

.profile-info h6 {
    margin: 0;
    font-weight: 600;
    color: white;
    font-size: 0.95rem;
    margin-bottom: 0.25rem;
}

.seller-badge {
    background: linear-gradient(135deg, #00b09b, #96c93d);
    color: white;
    padding: 0.3rem 0.6rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    border: none;
    display: inline-flex;
    align-items: center;
}

/* Scrollable Menu */
.sidebar-menu {
    flex: 1;
    padding: 1rem 0;
    overflow-y: auto;
    overflow-x: hidden;
}

.sidebar-menu::-webkit-scrollbar {
    width: 5px;
}

.sidebar-menu::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.05);
}

.sidebar-menu::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 3px;
}

/* Enhanced Menu Items */
.menu-item {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    color: rgba(255, 255, 255, 0.85);
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    border-left: 3px solid transparent;
    margin: 0.25rem 0.75rem;
    border-radius: 8px;
}

.menu-item:hover {
    background: rgba(255, 255, 255, 0.08);
    color: white;
    transform: translateX(5px);
}

.menu-item.active {
    background: linear-gradient(135deg, #3a7bd5, #00d2ff);
    color: white;
    border-left-color: #00d2ff;
    box-shadow: 0 4px 15px rgba(58, 123, 213, 0.3);
}

.menu-item i {
    width: 24px;
    font-size: 1.1rem;
    margin-right: 0.75rem;
    color: #6a89cc;
}

.menu-item.active i {
    color: white;
}

.menu-item:hover i {
    color: white;
}

.count-badge {
    margin-left: auto;
    background: linear-gradient(135deg, #ff9a00, #ff6a00);
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    min-width: 24px;
    border-radius: 12px;
    font-weight: 600;
    border: none;
}

.menu-divider {
    height: 1px;
    background: rgba(255, 255, 255, 0.1);
    margin: 1rem 1.5rem;
}

/* Enhanced Footer */
.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    background: rgba(0, 0, 0, 0.2);
}

.btn-outline-danger {
    border-color: rgba(255, 107, 107, 0.4);
    color: #ff6b6b;
    background: rgba(255, 107, 107, 0.1);
    border-radius: 8px;
    padding: 0.75rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-outline-danger:hover {
    background: rgba(255, 107, 107, 0.2);
    border-color: #ff6b6b;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 107, 107, 0.2);
}

/* Responsive Design */
@media (max-width: 1199.98px) {
    .dashboard-sidebar {
        width: 240px;
    }
}

@media (max-width: 991.98px) {
    .dashboard-sidebar {
        width: 100%;
        height: auto;
        position: static;
    }
    
    .sidebar-menu {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        padding: 1rem;
        overflow-x: auto;
    }
    
    .menu-item {
        flex: 0 0 auto;
        min-width: 120px;
        flex-direction: column;
        text-align: center;
        padding: 1rem 0.75rem;
        border-left: none;
        border-bottom: 3px solid transparent;
    }
    
    .menu-item:hover,
    .menu-item.active {
        border-left: none;
        border-bottom-color: #00d2ff;
        transform: translateY(-3px);
    }
    
    .menu-item i {
        margin-right: 0;
        margin-bottom: 0.5rem;
        font-size: 1.25rem;
    }
    
    .count-badge {
        position: absolute;
        top: 8px;
        right: 8px;
    }
    
    .user-profile {
        justify-content: center;
        text-align: center;
    }
    
    .profile-info {
        text-align: center;
    }
}

@media (max-width: 767.98px) {
    .sidebar-menu {
        justify-content: center;
    }
    
    .menu-item {
        min-width: 100px;
        padding: 0.75rem 0.5rem;
    }
    
    .menu-item span {
        font-size: 0.85rem;
    }
}
</style>