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
                            <i class="bi bi-plus-circle me-2"></i>
                            <span v-if="editMode">Edit</span>
                            <span v-else>Add</span> Product
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
                                <div class="card-header bg-white border-0 py-3">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-box-seam text-primary me-2"></i>
                                        Product Details
                                    </h5>
                                    <p class="text-muted mb-0 small">Fill in all required fields marked with *</p>
                                </div>

                                <div class="card-body">
                                    <form @submit.prevent="handleSave">
                                        <!-- Product Basic Info -->
                                        <div class="form-section mb-4">
                                            <h6 class="section-title">
                                                <i class="bi bi-info-circle me-2"></i>
                                                <span v-if="editMode">Edit</span>
                                                <span v-else>Create</span> Product
                                            </h6>
                                            <div class="row g-3">
                                                <!-- Item Name -->
                                                <div class="col-md-12">
                                                    <label class="form-label required">
                                                        Product Name
                                                    </label>
                                                    <input type="text" v-model="form.item_name"
                                                        class="form-control form-control-lg"
                                                        :class="{ 'is-invalid': errors.item_name }"
                                                        placeholder="Enter product name" required />
                                                    <div v-if="errors.item_name" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.item_name[0] }}
                                                    </div>
                                                    <div class="form-text">
                                                        Choose a clear, descriptive name for your product
                                                    </div>
                                                </div>
                                                <!-- Product Image -->
                                                <div class="form-section mb-4">
                                                    <h6 class="section-title">
                                                        <i class="bi bi-image me-2"></i>Product Image
                                                    </h6>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <!-- Image Preview -->
                                                            <div class="image-upload-area"
                                                                :class="{ 'has-image': showImage }"
                                                                @click="triggerFileInput">
                                                                <div v-if="!showImage" class="upload-placeholder">
                                                                    <i
                                                                        class="bi bi-cloud-arrow-up display-4 text-muted mb-3"></i>
                                                                    <h5>Upload Product Image</h5>
                                                                    <p class="text-muted">Click or drag & drop image
                                                                        here</p>
                                                                    <small class="text-muted">JPG, PNG, WEBP up to
                                                                        5MB</small>
                                                                </div>
                                                                <div v-else class="image-preview">
                                                                    <img :src="getImage()" alt="Product"
                                                                        class="preview-img">
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm remove-image"
                                                                        @click.stop="removeImage">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- Hidden File Input -->
                                                            <input type="file" ref="fileInput"
                                                                @change="handleFileChange" class="d-none"
                                                                accept="image/*" :disabled="loading" />

                                                            <div v-if="errors.photo"
                                                                class="invalid-feedback d-block mt-2">
                                                                <i class="bi bi-exclamation-triangle me-1"></i>
                                                                {{ errors.photo[0] }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- CATEGORY -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Category</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select form-contro"
                                                            v-model="form.category_id">
                                                            <option value="">Select Category</option>
                                                            <option v-for="cat in categories" :key="cat.id"
                                                                :value="cat.id">
                                                                {{ cat.category }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.category_id" class="text-danger">
                                                        {{ errors.category_id[0] }}
                                                    </small>
                                                </div>
                                                <!-- TYPE -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Type</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.type_id">
                                                            <option value="">Select Type</option>
                                                            <option v-for="type in types" :key="type.id"
                                                                :value="type.id">
                                                                {{ type.type }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.type_id" class="text-danger">
                                                        {{ errors.type_id[0] }}
                                                    </small>
                                                </div>

                                                <!-- COLOR -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Color</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.color_id">
                                                            <option value="">Select Color</option>
                                                            <option v-for="color in colors" :key="color.id"
                                                                :value="color.id">
                                                                {{ color.color }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.color_id" class="text-danger">
                                                        {{ errors.color_id[0] }}
                                                    </small>
                                                </div>

                                                <!-- LOCATION -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Location</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.location_id">
                                                            <option value="">Select Location</option>
                                                            <option v-for="location in locations" :key="location.id"
                                                                :value="location.id">
                                                                {{ location.location }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.location_id" class="text-danger">
                                                        {{ errors.location_id[0] }}
                                                    </small>
                                                </div>
                                                <!-- Price & Discount -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">
                                                        Price (UGX)
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text bg-light">UGX</span>
                                                        <input type="number" v-model="form.sales_price"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.sales_price }"
                                                            placeholder="0.00" min="0" step="0.01" required />
                                                    </div>
                                                    <div v-if="errors.sales_price" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.sales_price[0] }}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">
                                                        Discount (%)
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <input type="number" v-model="form.discount"
                                                            class="form-control"
                                                            :class="{ 'is-invalid': errors.discount }"
                                                            placeholder="0-100" min="0" max="100" />
                                                        <span class="input-group-text bg-light">%</span>
                                                    </div>
                                                    <div v-if="errors.discount" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.discount[0] }}
                                                    </div>
                                                    <div class="form-text" v-if="form.discount">
                                                        Final Price: UGX {{ calculateFinalPrice }}
                                                    </div>
                                                </div>

                                                <!-- Condition -->
                                                <!-- <div class="col-md-6">
                                                    <label class="form-label required">
                                                        Condition
                                                    </label>
                                                    <div class="row g-2">
                                                        <div class="col-4" v-for="cond in conditions" :key="cond.value">
                                                            <input type="radio" class="btn-check"
                                                                :id="`condition-${cond.value}`" v-model="form.condition"
                                                                :value="cond.value" required>
                                                            <label class="btn btn-outline-secondary w-100"
                                                                :for="`condition-${cond.value}`">
                                                                <i :class="cond.icon"></i>
                                                                <span class="d-block mt-1">{{ cond.label }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div v-if="errors.condition" class="invalid-feedback d-block mt-2">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.condition[0] }}
                                                    </div>
                                                </div> -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Condition</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.condition">
                                                            <option value="">Select Condition</option>
                                                            <option v-bind:new="new">
                                                                New
                                                            </option>
                                                            <option v-bind:used="used">
                                                                Used
                                                            </option>
                                                            <option v-bind:refurbished="refurbished">
                                                                Refurbished
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.condition" class="text-danger">
                                                        {{ errors.condition[0] }}
                                                    </small>
                                                </div>
                                                <!-- GENDER -->
                                                <div class="col-md-6">
                                                    <label class="form-label">Gender</label>
                                                    <div class="input-group input-group-lg">
                                                        <select class="form-select" v-model="form.gender">
                                                            <option value="">Select Gender</option>
                                                            <option v-bind:unisex="unisex">
                                                                Unisex
                                                            </option>
                                                            <option v-bind:women="women">
                                                                Women
                                                            </option>
                                                            <option v-bind:men="men">
                                                                Men
                                                            </option>
                                                            <option v-bind:children="children">
                                                                Children
                                                            </option>
                                                            <option v-bind:babies="babies">
                                                                Babies
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <small v-if="errors.gender" class="text-danger">
                                                        {{ errors.gender[0] }}
                                                    </small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="form-section mb-4">
                                            <h6 class="section-title">
                                                <i class="bi bi-card-text me-2"></i>Description
                                            </h6>
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label required">
                                                        Product Description
                                                    </label>
                                                    <textarea v-model="form.description" class="form-control"
                                                        :class="{ 'is-invalid': errors.description }" rows="5"
                                                        placeholder="Describe your product in detail..."
                                                        required></textarea>
                                                    <div v-if="errors.description" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.description[0] }}
                                                    </div>
                                                    <div class="form-text">
                                                        <span :class="{ 'text-danger': descriptionLength > 500 }">
                                                            {{ descriptionLength }}/500 characters
                                                        </span>
                                                        <span class="ms-3">
                                                            <i class="bi bi-lightbulb me-1"></i>
                                                            Include features, specifications, and condition details
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Form Actions -->
                                        <div class="form-section">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <router-link to="/my-products" class="btn btn-outline-secondary">
                                                        <i class="bi bi-x-circle me-2"></i>Cancel
                                                    </router-link>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        @click="saveAsDraft" :disabled="loading">
                                                        <i class="bi bi-save me-2"></i>Save as Draft
                                                    </button>
                                                    <button type="submit" class="btn btn-primary btn-lg px-4"
                                                        :disabled="loading || !isFormValid">
                                                        <span v-if="loading">
                                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                                            Saving...
                                                        </span>
                                                        <span v-else>
                                                            <i class="bi bi-check-circle me-2"></i>Publish Product
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
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

import { reactive, ref, computed, onMounted } from "vue"
import { useRouter, useRoute } from "vue-router"
import { useAuthStore } from '../../stores/auth'
import Navbar from '../layouts/Navbar.vue'
import SellerSidebar from '../layouts/SellerSidebar.vue'
import AppFooter from '../layouts/AppFooter.vue'

const router = useRouter()
const route = useRoute()
const authStore = useAuthStore()

const form = reactive({
    category_id: "",
    type_id: "",
    color_id: "",
    item_name: "",
    discount: "",
    description: "",
    sales_price: "",
    gender: "",
    condition: "",
    photo: "",
    status: "available" // default status
})

const categories = ref([])
const types = ref([])
const colors = ref([])
const locations = ref([])
const errors = ref({})
const loading = ref(false)
const pageLoading = ref(true)
const fileInput = ref(null)
const productCount = ref(0)
const editMode = ref(false) //edit product using same form



/**
 * LOAD DATA
 */
onMounted(async () => {
    pageLoading.value = true

    await fetchCategories()
    await fetchTypes()
    await fetchColors()
    await fetchLocations()
    await getMyProducts()


    // Detect edit mode
    if (route.params.id) {
        editMode.value = true
    }

    pageLoading.value = false
})

/**
 * FETCH CATEGORIES FOR SELECT
 */
const fetchCategories = async () => {
    try {
        const response = await axios.get("/api/categories")
        categories.value = response.data.categories.data || []
    } catch (error) {
        console.error("Failed to fetch categories", error)
    }
}

/**
 * FETCH TYPES FOR SELECT
 */
const fetchTypes = async () => {
    try {
        const response = await axios.get("/api/types")
        types.value = response.data.types.data || []
    } catch (error) {
        console.error("Failed to fetch types", error)
    }
}


/**
 * FETCH COLOR FOR SELECT
 */
const fetchColors = async () => {
    try {
        const response = await axios.get("/api/colors")
        colors.value = response.data.colors.data || []
    } catch (error) {
        console.error("Failed to fetch colors", error)
    }
}

/**
 * FETCH Location FOR SELECT
 */
const fetchLocations = async () => {
    try {
        const response = await axios.get("/api/locations")
        locations.value = response.data.locations.data || []
    } catch (error) {
        console.error("Failed to fetch colors", error)
    }
}

/**
 * FETCH Product FOR EDIT
 */
const getMyProducts = async () => {
    try {
        const response = await axios.get(
            `/api/products/${route.params.id}/edit`
        )
        form.category_id = response.data.product.category_id
        form.type_id = response.data.product.type_id
        form.color_id = response.data.product.color_id
        form.location_id = response.data.product.location_id
        form.item_name = response.data.product.item_name
        form.sales_price = response.data.product.sales_price
        form.discount = response.data.product.discount
        form.status = response.data.product.status
        form.condition = response.data.product.condition
        form.gender = response.data.product.gender
        form.description = response.data.product.description
        form.photo = response.data.product.photo
    } catch (error) {
        console.error("Failed to load category", error)
    }
}



// Condition options
// const conditions = [
//     { value: 'new', label: 'New', icon: 'bi bi-box-seam' },
//     { value: 'used', label: 'Used', icon: 'bi bi-arrow-repeat' },
//     { value: 'refurbished', label: 'Refurbished', icon: 'bi bi-tools' }
// ]

// Computed properties
const showImage = computed(() => {
    return form.photo && form.photo.length > 0
})

const descriptionLength = computed(() => {
    return form.description.length
})

const isFormValid = computed(() => {
    return form.item_name && form.description && form.sales_price && form.condition && form.category_id
        && form.type_id && form.color_id && form.location_id && form.gender
})

const calculateFinalPrice = computed(() => {
    if (!form.sales_price) return '0.00'
    const sales_price = parseFloat(form.sales_price)
    const discount = form.discount ? parseFloat(form.discount) : 0
    if (discount > 0) {
        const discounted = sales_price - (sales_price * discount / 100)
        return discounted.toFixed(2)
    }
    return sales_price.toFixed(2)
})

const getImage = () => {
    if (form.photo) {
        if (form.photo.indexOf("base64") !== -1) {
            return form.photo
        } else if (form.photo) {
            return "/upload/" + form.photo
        }
    }
    return ""
}

// Methods
const triggerFileInput = () => {
    if (!loading.value) {
        fileInput.value.click()
    }
}

const handleFileChange = (e) => {
    const file = e.target.files[0]
    if (file) {
        // Check file size (5MB max)
        if (file.size > 5 * 1024 * 1024) {
            window.toast.fire({
                icon: 'error',
                title: 'File too large! Maximum size is 5MB.'
            })
            return
        }

        // Check file type
        if (!file.type.match('photo.*')) {
            window.toast.fire({
                icon: 'error',
                title: 'Please select an photo file!'
            })
            return
        }

        let reader = new FileReader()
        reader.onloadend = () => {
            form.photo = reader.result
        }
        reader.onerror = () => {
            window.toast.fire({
                icon: 'error',
                title: 'Error reading file!'
            })
        }
        reader.readAsDataURL(file)
    }
}

const removeImage = () => {
    form.photo = ""
    if (fileInput.value) {
        fileInput.value.value = ""
    }
}

// const fetchProductCount = async () => {
//     try {
//         // Fetch seller's product count
//         const response = await axios.get('/api/seller/products/count')
//         if (response.data.success) {
//             productCount.value = response.data.count
//         }
//     } catch (error) {
//         console.error('Error fetching product count:', error)
//     }
// }

const handleSave = async () => {
    loading.value = true
    errors.value = {}

    try {
        // Add seller ID to form
        const formData = {
            ...form,
            seller_id: authStore.user?.id
        }

        const response = await axios.post('/api/products', formData)

        if (response.data.success) {
            window.toast.fire({
                icon: "success",
                title: "Product Added Successfully!"
            })

            // Reset form
            Object.keys(form).forEach(key => {
                if (key !== 'status') {
                    form[key] = ""
                }
            })

            // Update product count
            productCount.value++

            // Redirect to seller's products page
            router.push("/my-products")
        }

    } catch (error) {
        if (error.response && error.response.status === 422) {
            errors.value = error.response.data.errors
            window.toast.fire({
                icon: 'error',
                title: 'Please fix the form errors!'
            })
        } else {
            window.toast.fire({
                icon: 'error',
                title: 'An error occurred. Please try again.'
            })
            console.error(error)
        }
    } finally {
        loading.value = false
    }
}



const saveAsDraft = async () => {
    form.status = "draft"
    await handleSave()
}

const logout = async () => {
    await authStore.logout()
    router.push('/login')
}

</script>
