<template>
    <!-- Seller Dashboard Layout -->
    <div class="seller-dashboard-layout">
        <!-- Dashboard Navbar -->
        <Navbar />

        <!-- Dashboard Layout -->
        <div class="dashboard-container">
            <!-- Sidebar -->
            <div class="dashboard-sidebar">
                <div class="sidebar-header">
                    <div class="user-profile">
                        <img :src="authStore.user?.profile_image || '/images/default-avatar.png'" 
                             alt="Profile" class="profile-img">
                        <div class="profile-info">
                            <h6>{{ authStore.user?.name || 'Seller' }}</h6>
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
                    
                    <router-link to="/products/create" class="menu-item active">
                        <i class="bi bi-plus-circle"></i>
                        <span>Add Product</span>
                    </router-link>
                    
                    <router-link to="/my-products" class="menu-item">
                        <i class="bi bi-grid"></i>
                        <span>My Products</span>
                        <span class="badge count-badge">{{ productCount }}</span>
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

<style scoped>
/* All CSS styles remain the same as in your code */
.seller-dashboard-layout {
    min-height: 100vh;
    background: #f8f9fa;
}

/* Dashboard Layout */
.dashboard-container {
    display: flex;
    min-height: calc(100vh - 76px); /* Subtract navbar height */
}

/* Sidebar Styles */
.dashboard-sidebar {
    width: 260px;
    background: white;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
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
    border-bottom: 1px solid rgba(0,0,0,0.1);
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

.form-control, .form-control-lg {
    border-radius: 8px;
    border: 1px solid #dee2e6;
    transition: all 0.3s ease;
}

.form-control:focus, .form-control-lg:focus {
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
.tips-card, .stats-card {
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
.btn-check:checked + .btn-outline-secondary {
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
</style>