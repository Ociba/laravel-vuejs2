<template>
    <!-- Seller Dashboard Layout -->
    <div class="seller-dashboard-layout">
        <!-- Dashboard Navbar -->
        <Navbar />

        <!-- Dashboard Layout -->
        <div class="dashboard-container">
            <!-- Sidebar -->
            <SellerSidebar />


            <!-- Main Content -->
            <div class="dashboard-main">
                <!-- Dashboard Header -->
                <div class="dashboard-header mt-5">
                    <div class="header-content">
                        <h1 class="page-title">
                            <i class="bi bi-plus-circle me-2"></i>All My Product
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    <router-link to="/my-products">My Products</router-link>
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

                                    <!-- Enhanced Search Section -->
                                    <div class="row mb-4">
                                        <div class="col-lg-12">
                                            <div class="card card-table">
                                                <div class="card-body">

                                                    <!-- HEADER -->
                                                    <div
                                                        class="title-header option-title mb-3  d-flex align-items-center">
                                                        <!-- LEFT -->
                                                        <h5 class="mb-0"></h5>

                                                        <!-- RIGHT -->
                                                        <div class="ms-auto d-flex gap-2">
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
                                                                    <th>Price</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                <tr v-for="product in products" :key="product.id">
                                                                    <td>{{ product.item_name }}</td>
                                                                    <td><img :src="ourImage(product.photo)" style="width:100px; height:80px;"/></td>
                                                                    <td>{{ product.condition }}</td>
                                                                    <td>UGX : {{ product.sales_price }}</td>
                                                                    <td>
                                                                        <button class="btn btn-sm btn-primary me-1 mb-1"
                                                                            @click="onEdit(product.id)"
                                                                            :disabled="loading">
                                                                            Edit
                                                                        </button>

                                                                        <button class="btn btn-sm btn-success me-1 mb-1"
                                                                            @click="onView(product.id)"
                                                                            :disabled="loading">
                                                                            View
                                                                        </button>

                                                                        <button class="btn btn-sm btn-danger mb-1"
                                                                            @click="deleteProduct(product.id)"
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
import SellerSidebar from "../layouts/SellerSidebar.vue"
import AppFooter from '../layouts/AppFooter.vue'


const router =useRouter()

let products = ref([])

let links = ref([])

let searchQuery = ref('')

const loading = ref(false)


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

 /**
     * Redirect EDIT Product
     */
     const onEdit = (id) => {
        router.push(`/products/${id}/edit`)
    }

/**
 * /**
     * Redirect View Product
     */
     const onView = (id) => {
        router.push(`/products/${id}/view`)
    }

/**
 * 
     * DELETE Product
     */
     const deleteProduct = (id) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won’t be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                loading.value = true
    
                axios.delete(`/api/products/${id}`)
                    .then(() => {
                        Swal.fire(
                            "Deleted!",
                            "Product deleted successfully.",
                            "success"
                        )
                        getMyProducts()
                    })
                    .finally(() => {
                        loading.value = false
                    })
            }
        })
    }

</script>

