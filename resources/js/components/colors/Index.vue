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
                            <i class="bi bi-plus-circle me-2"></i>Colors
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    Colors
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

                                    <!-- HEADER -->
                                    <div class="title-header option-title mb-3 d-flex align-items-center">
                                        <!-- LEFT -->
                                        <h5 class="mb-0">All Colors</h5>

                                        <!-- RIGHT -->
                                        <div class="ms-auto d-flex gap-2">

                                            <button @click="addColorForm" class="btn btn-success" :disabled="loading">
                                                Add New Color
                                            </button>
                                        </div>
                                    </div>


                                    <!-- SEARCH -->
                                    <div class="mb-3">
                                        <input type="search" class="form-control" placeholder="Search color..."
                                            v-model="searchQuery" :disabled="loading" />
                                    </div>

                                    <!-- LOADING STATE -->
                                    <div v-if="loading" class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading Colors...</p>
                                    </div>

                                    <!-- TABLE -->
                                    <div v-else class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Color</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="color in colors" :key="color.id">
                                                    <td>{{ color.color }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary me-2"
                                                            @click="onEdit(color.id)" :disabled="loading">
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-sm btn-danger"
                                                            @click="deleteColor(color.id)" :disabled="loading">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <tr v-if="colors.length === 0">
                                                    <td colspan="3" class="text-center">
                                                        No colors found
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- PAGINATION -->
                                    <div class="pagination mt-3">
                                        <button v-for="(link, index) in links" :key="index" class="btn btn-sm me-1"
                                            :class="{
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
        <!-- Footer -->
        <AppFooter />
    </div>
</template>

<script setup>
import { useRouter } from "vue-router"
import { onMounted, ref, watch } from "vue"
import axios from "axios"
import Navbar from '../layouts/Navbar.vue'
import SellerSidebar from "../layouts/SellerSidebar.vue"
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()

/**
 * STATE
 */
const colors = ref([])
const links = ref([])
const searchQuery = ref("")
const loading = ref(false)

/**
 * FETCH colors ON LOAD
 */
onMounted(() => {
    getColors()
})

/**
 * WATCH SEARCH INPUT
 */
watch(searchQuery, () => {
    getColors()
})

/**
 * GO TO CREATE PAGE
 */
const addColorForm = () => {
    router.push("/color/create")
}

/**
* GO TO HOME PAGE
*/
const Home = () => {
    router.push("/")
}

/**
 * GET colors FROM API
 */
const getColors = async () => {
    loading.value = true

    try {
        const response = await axios.get(
            `/api/colors?searchQuery=${searchQuery.value}`
        )

        colors.value = response.data.colors.data
        links.value = response.data.colors.links
    } catch (error) {
        console.error(error)
    } finally {
        loading.value = false
    }
}

/**
 * PAGINATION HANDLER
 */
const changePage = (link) => {
    if (!link.url || link.active) return

    loading.value = true

    axios.get(link.url)
        .then((response) => {
            colors.value = response.data.colors.data
            links.value = response.data.colors.links
        })
        .finally(() => {
            loading.value = false
        })
}

/**
 * EDIT color
 */
const onEdit = (id) => {
    router.push(`/color/${id}/edit`)
}

/**
 * DELETE color
 */
const deleteColor = (id) => {
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

            axios.delete(`/api/color/${id}`)
                .then(() => {
                    Swal.fire(
                        "Deleted!",
                        "color deleted successfully.",
                        "success"
                    )
                    getColors()
                })
                .finally(() => {
                    loading.value = false
                })
        }
    })
}

</script>
