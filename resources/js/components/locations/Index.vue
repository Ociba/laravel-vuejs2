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
                            <i class="bi bi-plus-circle me-2"></i>Locations
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    Locations
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
                                        <h5 class="mb-0">All locations</h5>

                                        <!-- RIGHT -->
                                        <div class="ms-auto d-flex gap-2">

                                            <button @click="LocationForm" class="btn btn-success" :disabled="loading">
                                                Add New Location
                                            </button>
                                        </div>
                                    </div>


                                    <!-- SEARCH -->
                                    <div class="mb-3">
                                        <input type="search" class="form-control" placeholder="Search Location..."
                                            v-model="searchQuery" :disabled="loading" />
                                    </div>

                                    <!-- LOADING STATE -->
                                    <div v-if="loading" class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading Locations...</p>
                                    </div>

                                    <!-- TABLE -->
                                    <div v-else class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Location</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="location in locations" :key="location.id">
                                                    <td>{{ location.location }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary me-2"
                                                            @click="onEdit(location.id)" :disabled="loading">
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-sm btn-danger"
                                                            @click="deleteLocation(location.id)" :disabled="loading">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <tr v-if="locations.length === 0">
                                                    <td colspan="3" class="text-center">
                                                        No locations found
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
const locations = ref([])
const links = ref([])
const searchQuery = ref("")
const loading = ref(false)

/**
 * FETCH LOCATION ON LOAD
 */
onMounted(() => {
    getLocation()
})

/**
 * WATCH SEARCH INPUT
 */
watch(searchQuery, () => {
    getLocation()
})

/**
 * GO TO CREATE PAGE
 */
const LocationForm = () => {
    router.push("/location/create")
}

/**
* GO TO HOME PAGE
*/
const Home = () => {
    router.push("/")
}

/**
 * GET locations FROM API
 */
const getLocation = async () => {
    loading.value = true

    try {
        const response = await axios.get(
            `/api/locations?searchQuery=${searchQuery.value}`
        )

        locations.value = response.data.locations.data
        links.value = response.data.locations.links
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
            locations.value = response.data.locations.data
            links.value = response.data.locations.links
        })
        .finally(() => {
            loading.value = false
        })
}

/**
 * EDIT LOCATION
 */
const onEdit = (id) => {
    router.push(`/location/${id}/edit`)
}

/**
 * DELETE LOCATION
 */
const deleteLocation = (id) => {
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

            axios.delete(`/api/location/${id}`)
                .then(() => {
                    Swal.fire(
                        "Deleted!",
                        "Location deleted successfully.",
                        "success"
                    )
                    getLocation()
                })
                .finally(() => {
                    loading.value = false
                })
        }
    })
}

</script>


