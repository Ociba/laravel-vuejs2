<template>
    <!-- Seller Dashboard Layout -->
    <div class="seller-dashboard-layout">
        <!-- Dashboard Navbar -->
        <Navbar />

        <!-- Dashboard Layout -->
        <div class="dashboard-container mt-2">
            <!-- Sidebar -->
            <SellerSidebar />
            <!-- Main Content -->
            <div class="dashboard-main">
                <!-- Dashboard Header -->
                <div class="dashboard-header mt-5">
                    <div class="header-content">
                        <h1 class="page-title">
                            <i class="bi bi-plus-circle me-2"></i>Adcharge
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    Adcharges
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
                                        <h5 class="mb-0">All Adcharge</h5>

                                        <!-- RIGHT -->
                                        <div class="ms-auto d-flex gap-2">

                                            <button @click="AdchargeForm" class="btn btn-success" :disabled="loading">
                                                Add New Ad Charge
                                            </button>
                                        </div>
                                    </div>


                                    <!-- SEARCH -->
                                    <div class="mb-3">
                                        <input type="search" class="form-control" placeholder="Search category..."
                                            v-model="searchQuery" :disabled="loading" />
                                    </div>

                                    <!-- LOADING STATE -->
                                    <div v-if="loading" class="text-center py-5">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2">Loading Ads Charges...</p>
                                    </div>

                                    <!-- TABLE -->
                                    <div v-else class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Offer</th>
                                                    <th>Charge</th>
                                                    <th>Trial Eligibility</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <tr v-for="adcharge in adcharges" :key="adcharge.id">
                                                    <td>{{ adcharge.offer }}</td>
                                                    <td>{{ adcharge.charge }}</td>
                                                     <td>{{ adcharge.is_trial_eligible }}</td>
                                                     <td>{{ adcharge.status }}</td>
                                                    <td>
                                                        <button class="btn btn-sm btn-primary me-2"
                                                            @click="onEdit(adcharge.id)" :disabled="loading">
                                                            Edit
                                                        </button>

                                                        <button class="btn btn-sm btn-danger"
                                                            @click="deleteAdcharge(adcharge.id)" :disabled="loading">
                                                            Delete
                                                        </button>
                                                    </td>
                                                </tr>

                                                <tr v-if="adcharges.length === 0">
                                                    <td colspan="3" class="text-center">
                                                        No Adcharge Found
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
const adcharges = ref([])
const links = ref([])
const searchQuery = ref("")
const loading = ref(false)

/**
 * FETCH ADCHARGE ON LOAD
 */
onMounted(() => {
    getAdcharge()
})

/**
 * WATCH SEARCH INPUT
 */
watch(searchQuery, () => {
    getAdcharge()
})

/**
 * GO TO CREATE PAGE
 */
const AdchargeForm = () => {
    router.push("/adcharge/create")
}

/**
* GO TO HOME PAGE
*/
const Home = () => {
    router.push("/")
}

/**
 * GET ADCHARGE FROM API
 */
const getAdcharge = async () => {
    loading.value = true

    try {
        const response = await axios.get(
            `/api/adcharges?searchQuery=${searchQuery.value}`
        )

        adcharges.value = response.data.adcharges.data
        links.value = response.data.adcharges.links
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
            adcharges.value = response.data.adcharges.data
            links.value = response.data.adcharges.links
        })
        .finally(() => {
            loading.value = false
        })
}

/**
 * EDIT ADCHARGE
 */
const onEdit = (id) => {
    router.push(`/adcharge/${id}/edit`)
}

/**
 * DELETE ADCHARGE
 */
const deleteAdcharge = (id) => {
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

            axios.delete(`/api/adcharge/${id}`)
                .then(() => {
                    Swal.fire(
                        "Deleted!",
                        "Adcharge deleted successfully.",
                        "success"
                    )
                    getAdcharge()
                })
                .finally(() => {
                    loading.value = false
                })
        }
    })
}

</script>


