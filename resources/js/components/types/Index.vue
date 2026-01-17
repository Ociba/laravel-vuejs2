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
                            <i class="bi bi-plus-circle me-2"></i>Types
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    Types
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
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="mb-0">All Types</h5>
                                        <button class="btn btn-success ms-auto" @click="createType" :disabled="loading">
                                            Add Type
                                        </button>
                                    </div>

                                    <div v-if="loading" class="text-center py-5">
                                        <div class="spinner-border text-primary"></div>
                                    </div>

                                    <div v-else class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Category</th>
                                                    <th>Type</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="type in types" :key="type.id">
                                                    <td>{{ type.category.category }}</td>
                                                    <td>{{ type.type }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary me-2"
                                                            @click="editType(type.id)">
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-sm btn-danger"
                                                            @click="deleteType(type.id)">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <tr v-if="types.length === 0">
                                                    <td colspan="3" class="text-center">
                                                        No types found
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
import { onMounted, ref } from "vue"
import axios from "axios"
import Navbar from '../layouts/Navbar.vue'
import SellerSidebar from '../layouts/SellerSidebar.vue'
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()

const types = ref([])
const loading = ref(false)

onMounted(() => {
    getTypes()
})

const getTypes = async () => {
    loading.value = true
    try {
        const res = await axios.get("/api/types")
        types.value = res.data.types
    } finally {
        loading.value = false
    }
}

const createType = () => {
    router.push("/types/create")
}

/**
* GO TO HOME PAGE
*/
const Home = () => {
    router.push("/")
}

const editType = (id) => {
    router.push(`/types/${id}/edit`)
}

const deleteType = (id) => {
    Swal.fire({
        title: "Are you sure?",
        icon: "warning",
        showCancelButton: true,
    }).then(async (result) => {
        if (result.isConfirmed) {
            await axios.delete(`/api/types/${id}`)
            getTypes()
        }
    })
}
</script>