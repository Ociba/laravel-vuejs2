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
                            <i class="bi bi-plus-circle me-2"></i>Measure
                        </h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <router-link to="/dashboard/seller">Dashboard</router-link>
                                </li>
                                <li class="breadcrumb-item">
                                    Measures
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

                                    <!-- PAGE LOADING -->
                                    <div v-if="pageLoading" class="d-flex justify-content-center align-items-center"
                                        style="min-height: 200px">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </div>

                                    <!-- FORM -->
                                    <template v-else>
                                        <!-- HEADER -->
                                        <h5 class="mb-4">
                                            {{ editMode ? "Edit Measure" : "Create Measure" }}
                                        </h5>

                                        <!-- CATEGORY -->
                                        <div class="mb-4 row">
                                            <label class="col-form-label">
                                                Measure
                                            </label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" v-model="form.measure" />
                                                <small class="text-danger" v-if="errors.measure">
                                                    {{ errors.measure[0] }}
                                                </small>
                                            </div>
                                        </div>

                                        <!-- ACTIONS -->
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-secondary"
                                                @click="router.push('/measures')">
                                                Back
                                            </button>

                                            <button class="btn btn-dark" :disabled="loading" @click="handleSave">
                                                {{ loading ? "Saving..." : "Save" }}
                                            </button>
                                        </div>
                                    </template>
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
import { onMounted, reactive, ref } from "vue"
import { useRouter, useRoute } from "vue-router"
import axios from "axios"
import Navbar from '../layouts/Navbar.vue'
import SellerSidebar from "../layouts/SellerSidebar.vue" 
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()
const route = useRoute()

/**
 * FORM STATE
 */
const form = reactive({
    measure: "",
})

/**
 * UI STATE
 */
const errors = ref({})
const loading = ref(false)      // Save button loading
const pageLoading = ref(false)  // Page/form loading
const editMode = ref(false)

/**
 * DETECT EDIT MODE SAFELY
 */
onMounted(async () => {
    if (route.params.id) {
        editMode.value = true
        pageLoading.value = true   // 🔹 start page loading

        await fetchMeasure()

        pageLoading.value = false  // 🔹 stop after fetch
    }
})

/**
 * FETCH MEASURE FOR EDIT
 */
const fetchMeasure = async () => {
    try {
        const response = await axios.get(
            `/api/measure/${route.params.id}/edit`
        )

        form.measure = response.data.measure.measure
    } catch (error) {
        console.error("Failed to load measure", error)
    }
}

/**
 * SAVE HANDLER
 */
const handleSave = () => {
    editMode.value ? updateMeasure() : createMeasure()
}

/**
 * CREATE MEASURE
 */
const createMeasure = async () => {
    loading.value = true
    errors.value = {}

    try {
        await axios.post("/api/measure", form)

        toast.fire({
            icon: "success",
            title: "Measure Added Successfully",
        })

        router.push("/measures")
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        }
    } finally {
        loading.value = false
    }
}

/**
 * UPDATE MEASURE
 */
const updateMeasure = async () => {
    loading.value = true
    errors.value = {}

    try {
        await axios.put(
            `/api/measure/${route.params.id}`,
            form
        )

        toast.fire({
            icon: "success",
            title: "Measure Updated Successfully",
        })

        router.push("/measures")
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        }
    } finally {
        loading.value = false
    }
}
</script>