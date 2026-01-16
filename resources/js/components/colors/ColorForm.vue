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
                            <i class="bi bi-plus-circle me-2"></i>Color Form
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
                                            {{ editMode ? "Edit Color" : "Create Color" }}
                                        </h5>

                                        <!-- Color -->
                                        <div class="mb-4 row">
                                            <label class="col-sm-3 col-form-label">
                                                Color
                                            </label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" v-model="form.color" />
                                                <small class="text-danger" v-if="errors.color">
                                                    {{ errors.color[0] }}
                                                </small>
                                            </div>
                                        </div>

                                        <!-- ACTIONS -->
                                        <div class="d-flex gap-2">
                                            <button class="btn btn-outline-secondary"
                                                @click="router.push('/colors')">
                                                Back
                                            </button>

                                            <button class="btn btn-dark" :disabled="loading" @click="handleSave">
                                                {{ loading ? "Saving..." : "Save Color" }}
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
    color: "",
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

        await fetchColor()

        pageLoading.value = false  // 🔹 stop after fetch
    }
})

/**
 * FETCH Color FOR EDIT
 */
const fetchColor = async () => {
    try {
        const response = await axios.get(
            `/api/color/${route.params.id}/edit`
        )

        form.color = response.data.color.color
    } catch (error) {
        console.error("Failed to load color", error)
    }
}

/**
 * SAVE HANDLER
 */
const handleSave = () => {
    editMode.value ? updateColor() : createColor()
}

/**
 * CREATE COLOR
 */
const createColor = async () => {
    loading.value = true
    errors.value = {}

    try {
        await axios.post("/api/color", form)

        toast.fire({
            icon: "success",
            title: "Color Added Successfully",
        })

        router.push("/colors")
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        }
    } finally {
        loading.value = false
    }
}

/**
 * UPDATE color
 */
const updateColor = async () => {
    loading.value = true
    errors.value = {}

    try {
        await axios.put(
            `/api/color/${route.params.id}`,
            form
        )

        toast.fire({
            icon: "success",
            title: "Color Updated Successfully",
        })

        router.push("/colors")
    } catch (error) {
        if (error.response?.status === 422) {
            errors.value = error.response.data.errors
        }
    } finally {
        loading.value = false
    }
}
</script>