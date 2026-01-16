<template>
    <!-- Seller Dashboard Layout -->
    <div class="seller-dashboard-layout">
        <!-- Dashboard Navbar -->
        <Navbar />

        <!-- Dashboard Layout -->
        <div class="dashboard-container mt-2">
            <!-- Sidebar -->
            <div class="dashboard-sidebar">
                <div class="sidebar-header">
                    <div class="user-profile">
                        <div class="profile-info">
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

                    <router-link to="/my-products" class="menu-item">
                        <i class="bi bi-grid"></i>
                        <span>My Products</span>
                        <span class="badge count-badge"></span>
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

            <!-- Main Content -->
            <div class="dashboard-main">
                <!-- Dashboard Header -->
                <div class="dashboard-header mt-5">
                    <div class="header-content">
                        <h1 class="page-title">
                            <i class="bi bi-plus-circle me-2"></i>Categories
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    Categories
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="header-actions">
                        <router-link to="/dashboard/seller" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
                        </router-link>
                    </div>
                </div>

                <!-- Product Form -->
                <div class="dashboard-content">
                    <div class="row">
                        <!-- Form Column -->
                        <div class="col-lg-12">
                            <div class="card form-card shadow-sm border-0">

                                <div class="card-body">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <AppFooter />
    </div>
</template>