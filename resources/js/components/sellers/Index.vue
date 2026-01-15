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
                <div class="dashboard-header">
                    <div class="header-content">
                        <h1 class="page-title">
                            <i class="bi bi-plus-circle me-2"></i>Add New Product
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    <router-link to="/my-products">My Products</router-link>
                                </li>
                                <li class="breadcrumb-item active">Add New</li>
                            </ol>
                        </nav>
                    </div>

                    <div class="header-actions">
                        <router-link to="/my-products" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-left me-2"></i>Back to Products
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

                                    <!-- Enhanced Search Section -->
                                    <div class="row mb-4">
                                        <div class="col-lg-12">
                                            <div class="card card-table">
                                                <div class="card-body">

                                                    <!-- HEADER -->
                                                    <div
                                                        class="title-header option-title mb-3 d-flex align-items-center">
                                                        <!-- LEFT -->
                                                        <h5 class="mb-0">All Products</h5>

                                                        <!-- RIGHT -->
                                                        <div class="ms-auto d-flex gap-2">
                                                            <button @click="Home" class="btn btn-primary"
                                                                :disabled="loading">
                                                                Dashboard
                                                            </button>

                                                            <button @click="newProduct" class="btn btn-success"
                                                                :disabled="loading">
                                                                Add New Product
                                                            </button>
                                                        </div>
                                                    </div>


                                                    <!-- SEARCH -->
                                                    <div class="mb-3">
                                                        <input type="search" class="form-control"
                                                            placeholder="Search category..." v-model="searchQuery"
                                                            :disabled="loading" />
                                                    </div>

                                                    <!-- LOADING STATE -->
                                                    <div v-if="loading" class="text-center py-5">
                                                        <div class="spinner-border text-primary" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                        <p class="mt-2">Loading categories...</p>
                                                    </div>

                                                    <!-- TABLE -->
                                                    <div v-else class="table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <tr>
                                                                    <th>Product</th>
                                                                    <th>Image</th>
                                                                    <th>Condition</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr v-for="product in products" :key="product.id">
                                                                    <td>{{ product.item_name }}</td>
                                                                    <td><img :src="ourImage(product.image)"/></td>
                                                                    <td>{{ product.condition }}</td>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-primary me-1"
                                                                            @click="onEdit(product.id)"
                                                                            :disabled="loading">
                                                                            Edit
                                                                        </button>

                                                                        <button class="btn btn-sm btn-danger"
                                                                            @click="deleteCategory(product.id)"
                                                                            :disabled="loading">
                                                                            Delete
                                                                        </button>
                                                                    </td>
                                                                </tr>

                                                                <tr v-if="products.length === 0">
                                                                    <td colspan="3" class="text-center">
                                                                        No categories found
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    <!-- PAGINATION -->
                                                    <div class="pagination mt-3">
                                                        <button v-for="(link, index) in links" :key="index"
                                                            class="btn btn-sm me-1" :class="{
                                                                'btn-primary': link.active,
                                                                'btn-outline-secondary': !link.active,
                                                            }" v-html="link.label" :disabled="loading || !link.url"
                                                            @click="changePage(link)" />
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
        </div>

        <!-- Footer -->
        <AppFooter />
    </div>
</template>

<script setup>
import { useRouter } from "vue-router"
import { onMounted, ref, watch } from "vue"
import axios from 'axios'
import Navbar from '../layouts/Navbar.vue'
import AppFooter from '../layouts/AppFooter.vue'


const router =useRouter()

let products = ref([])

let links = ref([])

let searchQuery = ref('')


onMounted(async () => {
    getMyProducts()
})

watch(searchQuery, () => {
    getMyProducts()
})
const newProduct = () => {
    router.push('products/create')
}

const ourImage = (img) => {
    return "/upload/"+img
}

const getMyProducts = async () => {
    let response = await axios.get ('api/my-products?&searchQuery='+searchQuery.value)
    .then((response) => {
        products.value = response.data.products.data
        links.value = response.data.products.links
    })
}

const changePage = (link) => {
    if(!link.url || link.active ){
        return
    }

    axios.get(link.url)
    .then((response) => {
        products.value = response.data.products.data
        links.value = response.data.products.links
    })
}

</script>


<style scoped>
/* All CSS styles remain the same as in your code */
.seller-dashboard-layout {
    min-height: 100vh;
    background: #f8f9fa;
}

/* Dashboard Layout */
.dashboard-container {
    display: flex;
    min-height: calc(100vh - 76px);
    /* Subtract navbar height */
}

/* Sidebar Styles */
.dashboard-sidebar {
    width: 260px;
    background: white;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    z-index: 100;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e9ecef;
}

.user-profile {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.profile-img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #007bff;
}

.profile-info h6 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
}

.seller-badge {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.sidebar-menu {
    flex: 1;
    padding: 1rem 0;
}

.menu-item {
    display: flex;
    align-items: center;
    padding: 0.75rem 1.5rem;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    border-left: 3px solid transparent;
}

.menu-item:hover {
    background: rgba(0, 123, 255, 0.1);
    color: #007bff;
    border-left-color: #007bff;
}

.menu-item.active {
    background: rgba(0, 123, 255, 0.15);
    color: #007bff;
    border-left-color: #007bff;
    font-weight: 500;
}

.menu-item i {
    width: 24px;
    font-size: 1.1rem;
    margin-right: 0.75rem;
}

.count-badge {
    margin-left: auto;
    background: #007bff;
    color: white;
    font-size: 0.7rem;
    padding: 0.2rem 0.5rem;
    min-width: 24px;
}

.menu-divider {
    height: 1px;
    background: #e9ecef;
    margin: 1rem 1.5rem;
}

.sidebar-footer {
    padding: 1.5rem;
    border-top: 1px solid #e9ecef;
}

/* Main Content */
.dashboard-main {
    flex: 1;
    overflow-y: auto;
}

.dashboard-header {
    background: white;
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.header-content {
    flex: 1;
}

.page-title {
    font-size: 1.75rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.5rem;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #6c757d;
    text-decoration: none;
}

.breadcrumb-item.active {
    color: #007bff;
    font-weight: 500;
}

.header-actions .btn {
    padding: 0.5rem 1.5rem;
}

/* Dashboard Content */
.dashboard-content {
    padding: 2rem;
}

/* Form Styles */
.form-card {
    border-radius: 15px;
    overflow: hidden;
}

.card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}

.form-section {
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    border: 1px solid #e9ecef;
}

.section-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #007bff;
}

.form-label.required::after {
    content: " *";
    color: #dc3545;
}

.form-control,
.form-control-lg {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-control:focus,
.form-control-lg:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.invalid-feedback {
    display: block !important;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-text {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.5rem;
}

/* Image Upload Area */
.image-upload-area {
    border: 2px dashed #dee2e6;
    border-radius: 12px;
    padding: 3rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
    background: #f8f9fa;
    position: relative;
}

.image-upload-area:hover {
    border-color: #007bff;
    background: rgba(0, 123, 255, 0.05);
}

.image-upload-area.has-image {
    border-color: #28a745;
    background: rgba(40, 167, 69, 0.05);
    padding: 1rem;
}

.upload-placeholder i {
    color: #adb5bd;
}

.preview-img {
    max-width: 100%;
    max-height: 300px;
    border-radius: 8px;
    object-fit: contain;
}

.remove-image {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Tips Card */
.tips-card,
.stats-card {
    border-radius: 12px;
    overflow: hidden;
}

.tip-item {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.tip-icon {
    width: 40px;
    height: 40px;
    background: rgba(255, 193, 7, 0.1);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffc107;
    font-size: 1.2rem;
}

.tip-title {
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 0.25rem;
    color: #2c3e50;
}

.tip-text {
    color: #6c757d;
    line-height: 1.4;
}

/* Stats Card */
.stat-item {
    padding: 0.75rem;
    border-radius: 8px;
    background: #f8f9fa;
    margin-bottom: 0.75rem;
}

.stat-item:last-child {
    margin-bottom: 0;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
}

/* Button Styles */
.btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
}

.btn-primary:hover:not(:disabled) {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.btn-lg {
    padding: 0.75rem 2rem;
}

.btn-outline-primary:hover {
    transform: translateY(-2px);
}

/* Radio Button Styles */
.btn-check:checked+.btn-outline-secondary {
    background: linear-gradient(135deg, #6c757d, #495057);
    border-color: #6c757d;
    color: white;
    transform: translateY(-2px);
}

.btn-outline-secondary:hover {
    border-color: #6c757d;
}

/* Responsive Design */
@media (max-width: 1199.98px) {
    .dashboard-sidebar {
        width: 220px;
    }
}

@media (max-width: 991.98px) {
    .dashboard-container {
        flex-direction: column;
    }

    .dashboard-sidebar {
        width: 100%;
        position: static;
    }

    .sidebar-menu {
        display: flex;
        overflow-x: auto;
        padding: 0.5rem;
    }

    .menu-item {
        flex-direction: column;
        padding: 0.75rem;
        min-width: 80px;
        text-align: center;
        border-left: none;
        border-bottom: 3px solid transparent;
    }

    .menu-item:hover,
    .menu-item.active {
        border-left: none;
        border-bottom-color: #007bff;
    }

    .menu-item i {
        margin-right: 0;
        margin-bottom: 0.25rem;
        font-size: 1.2rem;
    }

    .menu-item span {
        font-size: 0.8rem;
    }

    .count-badge {
        position: absolute;
        top: 5px;
        right: 5px;
    }

    .user-profile {
        justify-content: center;
        text-align: center;
    }
}

@media (max-width: 767.98px) {
    .dashboard-content {
        padding: 1rem;
    }

    .dashboard-header {
        padding: 1rem;
        flex-direction: column;
        align-items: stretch;
    }

    .header-actions {
        margin-top: 1rem;
    }

    .form-section {
        padding: 1rem;
    }

    .image-upload-area {
        padding: 2rem;
    }

    .image-upload-area.has-image {
        padding: 1rem;
    }
}

@media (max-width: 575.98px) {
    .page-title {
        font-size: 1.5rem;
    }

    .btn-lg {
        padding: 0.5rem 1.5rem;
        font-size: 1rem;
    }

    .form-control-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }

    .d-flex.gap-2 {
        justify-content: stretch;
    }

    .d-flex.gap-2 .btn {
        flex: 1;
    }
}

.page-header {
    margin-top: 2rem;
}

.admin-controls {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 2rem;
    border: 1px solid #dee2e6;
}

.product-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.product-image {
    height: 200px;
    object-fit: cover;
    width: 100%;
    border-radius: 8px;
    transition: transform 0.3s ease;
}

.product-image:hover {
    transform: scale(1.05);
}

.discount-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #ff4444, #ff6b6b);
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 14px;
    font-weight: bold;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

/* Responsive adjustments for the new layout */
@media (max-width: 768px) {
    .page-header h1 {
        font-size: 2rem;
    }

    .admin-controls .btn {
        margin-bottom: 0.5rem;
        width: 100%;
    }
}

@media (max-width: 576px) {
    .page-header h1 {
        font-size: 1.8rem;
    }

    .product-image {
        height: 180px;
    }
}
</style>