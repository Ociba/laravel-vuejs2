<template>
    <div class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="user-profile">
                 <!--<img :src="authStore.user?.profile_image || '../images/logo.png'"
                        alt="Profile" class="profile-img">-->
                <div class="profile-info">
                    <!-- <h6>{{ authStore.user?.name || 'Seller' }}</h6> -->
                    <span class="badge seller-badge">
                        <i class="bi bi-shop me-1"></i>Seller
                    </span>
                </div>
            </div>
        </div>

        <div class="sidebar-menu">
            <router-link to="/dashboard/seller" class="menu-item">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </router-link>

            <router-link to="/categories" class="menu-item">
                <i class="bi bi-plus-circle"></i>
                <span>Categories</span>
            </router-link>

            <router-link to="/types" class="menu-item">
                <i class="bi bi-plus-circle"></i>
                <span>Types</span>
            </router-link>

            <router-link to="/colors" class="menu-item">
                <i class="bi bi-plus-circle"></i>
                <span>Colors</span>
            </router-link>

            <router-link to="/measures" class="menu-item">
                <i class="bi bi-plus-circle"></i>
                <span>Measures</span>
            </router-link>

            <router-link to="/locations" class="menu-item">
                <i class="bi bi-plus-circle"></i>
                <span>Location</span>
            </router-link> 

            <router-link to="/adcharges" class="menu-item">
                <i class="bi bi-plus-circle"></i>
                <span>AdCharges</span>
            </router-link>

            <router-link to="/news-subscription" class="menu-item">
                <i class="bi bi-plus-circle"></i>
                <span>News Subscriptions</span>
            </router-link>

            <router-link to="/my-products" class="menu-item">
                <i class="bi bi-grid"></i>
                <span>My Products</span>
                <span class="badge count-badge">{{ productCount }}</span>
            </router-link>

            <router-link to="/messages" class="menu-item">
                <i class="bi bi-chat-dots"></i>
                <span>Messages</span>
                <span class="badge count-badge">3</span>
            </router-link>

            <router-link to="/profile" class="menu-item">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </router-link>

            <div class="menu-divider"></div>

            <router-link to="/help" class="menu-item">
                <i class="bi bi-question-circle"></i>
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