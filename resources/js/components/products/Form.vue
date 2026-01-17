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
                        <div class="col-lg-8">
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
                                                    <input 
                                                        type="text" 
                                                        v-model="form.item_name" 
                                                        class="form-control form-control-lg" 
                                                        :class="{ 'is-invalid': errors.item_name }"
                                                        placeholder="Enter product name"
                                                        required
                                                    />
                                                    <div v-if="errors.item_name" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.item_name[0] }}
                                                    </div>
                                                    <div class="form-text">
                                                        Choose a clear, descriptive name for your product
                                                    </div>
                                                </div>

                                                <!-- Price & Discount -->
                                                <div class="col-md-6">
                                                    <label class="form-label required">
                                                        Price (UGX)
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <span class="input-group-text bg-light">UGX</span>
                                                        <input 
                                                            type="number" 
                                                            v-model="form.price" 
                                                            class="form-control" 
                                                            :class="{ 'is-invalid': errors.price }"
                                                            placeholder="0.00"
                                                            min="0"
                                                            step="0.01"
                                                            required
                                                        />
                                                    </div>
                                                    <div v-if="errors.price" class="invalid-feedback d-block">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.price[0] }}
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">
                                                        Discount (%)
                                                    </label>
                                                    <div class="input-group input-group-lg">
                                                        <input 
                                                            type="number" 
                                                            v-model="form.discount" 
                                                            class="form-control" 
                                                            :class="{ 'is-invalid': errors.discount }"
                                                            placeholder="0-100"
                                                            min="0"
                                                            max="100"
                                                        />
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
                                                <div class="col-md-12">
                                                    <label class="form-label required">
                                                        Condition
                                                    </label>
                                                    <div class="row g-2">
                                                        <div class="col-4" v-for="cond in conditions" :key="cond.value">
                                                            <input 
                                                                type="radio" 
                                                                class="btn-check" 
                                                                :id="`condition-${cond.value}`"
                                                                v-model="form.condition" 
                                                                :value="cond.value"
                                                                required
                                                            >
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
                                                    <textarea 
                                                        v-model="form.description" 
                                                        class="form-control" 
                                                        :class="{ 'is-invalid': errors.description }"
                                                        rows="5" 
                                                        placeholder="Describe your product in detail..."
                                                        required
                                                    ></textarea>
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
                                                            <i class="bi bi-cloud-arrow-up display-4 text-muted mb-3"></i>
                                                            <h5>Upload Product Image</h5>
                                                            <p class="text-muted">Click or drag & drop image here</p>
                                                            <small class="text-muted">JPG, PNG, WEBP up to 5MB</small>
                                                        </div>
                                                        <div v-else class="image-preview">
                                                            <img :src="getImage()" alt="Product" class="preview-img">
                                                            <button type="button" 
                                                                    class="btn btn-danger btn-sm remove-image"
                                                                    @click.stop="removeImage">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Hidden File Input -->
                                                    <input 
                                                        type="file" 
                                                        ref="fileInput"
                                                        @change="handleFileChange"  
                                                        class="d-none"
                                                        accept="image/*"
                                                        :disabled="loading"
                                                    />
                                                    
                                                    <div v-if="errors.image" class="invalid-feedback d-block mt-2">
                                                        <i class="bi bi-exclamation-triangle me-1"></i>
                                                        {{ errors.image[0] }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Actions -->
                                        <div class="form-section">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <router-link to="/my-products" 
                                                                 class="btn btn-outline-secondary">
                                                        <i class="bi bi-x-circle me-2"></i>Cancel
                                                    </router-link>
                                                </div>
                                                <div class="d-flex gap-2">
                                                    <button type="button" 
                                                            class="btn btn-outline-primary"
                                                            @click="saveAsDraft"
                                                            :disabled="loading">
                                                        <i class="bi bi-save me-2"></i>Save as Draft
                                                    </button>
                                                    <button type="submit" 
                                                            class="btn btn-primary btn-lg px-4"
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

                        <!-- Help Column -->
                        <div class="col-lg-4">
                            <!-- Tips Card -->
                            <div class="card tips-card shadow-sm border-0 mb-4">
                                <div class="card-header bg-white border-0">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-lightbulb text-warning me-2"></i>Selling Tips
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="tip-item mb-3">
                                        <div class="tip-icon">
                                            <i class="bi bi-camera"></i>
                                        </div>
                                        <div>
                                            <h6 class="tip-title">Use Clear Photos</h6>
                                            <p class="tip-text small">Take photos in good lighting from multiple angles</p>
                                        </div>
                                    </div>
                                    <div class="tip-item mb-3">
                                        <div class="tip-icon">
                                            <i class="bi bi-card-text"></i>
                                        </div>
                                        <div>
                                            <h6 class="tip-title">Be Descriptive</h6>
                                            <p class="tip-text small">Include all important details and specifications</p>
                                        </div>
                                    </div>
                                    <div class="tip-item">
                                        <div class="tip-icon">
                                            <i class="bi bi-tag"></i>
                                        </div>
                                        <div>
                                            <h6 class="tip-title">Fair Pricing</h6>
                                            <p class="tip-text small">Research similar products for competitive pricing</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="card stats-card shadow-sm border-0">
                                <div class="card-header bg-white border-0">
                                    <h5 class="card-title mb-0">
                                        <i class="bi bi-graph-up text-success me-2"></i>Quick Stats
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="stat-item mb-3">
                                        <div class="stat-label">Your Products</div>
                                        <div class="stat-value">{{ productCount }}</div>
                                    </div>
                                    <div class="stat-item mb-3">
                                        <div class="stat-label">Avg. Response Time</div>
                                        <div class="stat-value">2.5 hours</div>
                                    </div>
                                    <div class="stat-item">
                                        <div class="stat-label">Conversion Rate</div>
                                        <div class="stat-value">15%</div>
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
    item_name: "",
    discount: "",
    description: "",
    price: "",
    condition: "",
    image: "",
    status: "available" // default status
})

const errors = ref({})
const loading = ref(false)
const fileInput = ref(null)
const productCount = ref(0)
const editMode = ref(false) //edit product using same form



/**
     * DETECT EDIT MODE SAFELY
     */
     onMounted(async () => {

        if (route.params.id) {
            editMode.value = true
    
            await getMyProducts()
        }

        fetchProductCount()
    
        // Check if user is seller
        if (!authStore.isSeller) {
            router.push('/dashboard')
        }
    })
    
    /**
     * FETCH CATEGORY FOR EDIT
     */
    const getMyProducts = async () => {
        try {
            const response = await axios.get(
                `/api/products/${route.params.id}/edit`
            )
    
            form.item_name = response.data.product.item_name
            form.price = response.data.product.price
            form.discount = response.data.product.discount
            form.status = response.data.product.status
            form.description = response.data.product.description
            form.image = response.data.product.image
        } catch (error) {
            console.error("Failed to load category", error)
        }
    }
    

// Condition options
const conditions = [
    { value: 'new', label: 'New', icon: 'bi bi-box-seam' },
    { value: 'used', label: 'Used', icon: 'bi bi-arrow-repeat' },
    { value: 'refurbished', label: 'Refurbished', icon: 'bi bi-tools' }
]

// Computed properties
const showImage = computed(() => {
    return form.image && form.image.length > 0
})

const descriptionLength = computed(() => {
    return form.description.length
})

const isFormValid = computed(() => {
    return form.item_name && form.description && form.price && form.condition
})

const calculateFinalPrice = computed(() => {
    if (!form.price) return '0.00'
    const price = parseFloat(form.price)
    const discount = form.discount ? parseFloat(form.discount) : 0
    if (discount > 0) {
        const discounted = price - (price * discount / 100)
        return discounted.toFixed(2)
    }
    return price.toFixed(2)
})

const getImage = () => {
    if (form.image) {
        if (form.image.indexOf("base64") !== -1) {
            return form.image
        } else if (form.image) {
            return "/upload/" + form.image
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
        if (!file.type.match('image.*')) {
            window.toast.fire({
                icon: 'error',
                title: 'Please select an image file!'
            })
            return
        }
        
        let reader = new FileReader()
        reader.onloadend = () => {
            form.image = reader.result
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
    form.image = ""
    if (fileInput.value) {
        fileInput.value.value = ""
    }
}

const fetchProductCount = async () => {
    try {
        // Fetch seller's product count
        const response = await axios.get('/api/seller/products/count')
        if (response.data.success) {
            productCount.value = response.data.count
        }
    } catch (error) {
        console.error('Error fetching product count:', error)
    }
}

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
