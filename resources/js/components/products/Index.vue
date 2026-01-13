<script setup>
    import { useRouter } from "vue-router"
    import { onMounted, ref, watch } from "vue"
    import axios from 'axios'
    import Navbar from '../layouts/Navbar.vue'
    import HeroSlider from '../layouts/HeroSlider.vue'
    import AppFooter from '../layouts/AppFooter.vue' 
    
    const router = useRouter()
    const products = ref([])
    const currentPage = ref(1)
    const lastPage = ref(1)
    const loading = ref(false)
    const searchQuery = ref('')
    const searchLoading = ref(false)
    const searchTimeout = ref(null)
    
    // Enhanced debounce function
    const debounce = (func, wait) => {
        let timeout
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout)
                func(...args)
            }
            clearTimeout(timeout)
            timeout = setTimeout(later, wait)
        }
    }
    
    // Create debounced search function
    const debouncedSearch = debounce(async () => {
        if (searchQuery.value.trim()) {
            await performSearch(1)
        } else {
            // If search is empty, load first page without search
            await getProducts(1, false)
        }
    }, 300) // Reduced debounce time for better UX
    
    // Watch for search query changes
    watch(searchQuery, (newQuery) => {
        if (newQuery.trim()) {
            searchLoading.value = true
        }
        debouncedSearch()
    })
    
    onMounted(() => {
        getProducts(1, false)
    })
    
    // Modified getProducts function
    const getProducts = async (page = 1, isSearching = false) => {
        loading.value = true
        
        try {
            let url = `/api/products?page=${page}`
            
            // Always include search parameter if we have a query
            if (searchQuery.value.trim()) {
                url += `&search=${encodeURIComponent(searchQuery.value.trim())}`
            }
            
            const response = await axios.get(url)
            
            products.value = response.data.products.data || []
            currentPage.value = response.data.products.current_page || 1
            lastPage.value = response.data.products.last_page || 1
            
        } catch (error) {
            console.error('Error fetching products:', error)
            products.value = []
            currentPage.value = 1
            lastPage.value = 1
        } finally {
            loading.value = false
            searchLoading.value = false
        }
    }
    
    // Search function - just calls getProducts with search parameter
    const performSearch = async (page = 1) => {
        await getProducts(page, true)
    }
    
    // Manual search trigger
    const triggerSearch = () => {
        searchLoading.value = true
        if (searchQuery.value.trim()) {
            performSearch(1)
        } else {
            getProducts(1, false)
        }
    }
    
    const clearSearch = () => {
        searchQuery.value = ''
        getProducts(1, false)
    }
    
    const OurImage = (img) => {
        if (!img || img === 'no-image.png') return '/upload/no-image.png'
        return "/upload/" + img
    }
    
    const calculateDiscountedPrice = (price, discount) => {
        if (!discount || discount <= 0) return parseFloat(price).toFixed(2)
        return (price - (price * discount / 100)).toFixed(2)
    }
    
    const newProduct = () => router.push('/products/create')
    const categoryPage =() => router.push('/categories')
    const typePage = () => router.push('/types')
    const viewProduct = (id) => router.push(`/products/${id}`)
    </script>
    
    <template>
        <!-- Navbar Component -->
        <Navbar />
        
        <!-- Hero Slider Component -->
        <HeroSlider />
    
        <div class="container my-5">
            <!-- Page Header -->
            <div class="page-header mb-4">
                <h1 class="text-center mb-3">Our Products</h1>
                <p class="text-center text-muted mb-4">
                    Browse through our wide collection of quality products at the best prices
                </p>
            </div>
            
            <!-- Admin Controls (only show if user is admin) -->
            <div class="admin-controls mb-4">
                <div class="text-center">
                    <button 
                        @click="newProduct" 
                        class="btn btn-primary btn-sm me-2"
                        :disabled="loading"
                    >
                        <i class="bi bi-plus-circle me-2"></i>Add New Product
                    </button>
                    <button 
                        @click="categoryPage" 
                        class="btn btn-primary btn-sm me-2"
                        :disabled="loading"
                    >
                        <i class="bi bi-tags me-2"></i>Categories
                    </button>
                    <button 
                        @click="typePage" 
                        class="btn btn-primary btn-sm"
                        :disabled="loading"
                    >
                        <i class="bi bi-grid-3x3 me-2"></i>Types
                    </button>
                </div>
            </div>
            
            <!-- Enhanced Search Section -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card search-card shadow-sm">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-10 col-md-9 col-sm-8">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-transparent border-end-0">
                                            <i class="bi bi-search text-muted"></i>
                                        </span>
                                        <input 
                                            type="search" 
                                            class="form-control form-control-lg border-start-0" 
                                            v-model="searchQuery"
                                            placeholder="Start typing to search products..."
                                            :disabled="loading"
                                            @keyup.enter="triggerSearch"
                                        />
                                        <button 
                                            v-if="searchQuery" 
                                            class="btn btn-outline-secondary" 
                                            type="button"
                                            @click="clearSearch"
                                            title="Clear search"
                                            :disabled="loading"
                                        >
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </div>
                                    <div v-if="searchQuery" class="form-text mt-2">
                                        <small>
                                            <i class="bi bi-lightning me-1"></i>
                                            Real-time search across all products
                                        </small>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4 mt-3 mt-sm-0">
                                    <button 
                                        class="btn btn-primary w-100 h-100"
                                        @click="triggerSearch"
                                        :disabled="loading"
                                    >
                                        <span v-if="searchLoading">
                                            <span class="spinner-border spinner-border-sm me-2"></span>
                                            Searching...
                                        </span>
                                        <span v-else>
                                            <i class="bi bi-search me-2"></i>Search
                                        </span>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Search Stats -->
                            <div v-if="searchQuery || searchLoading" class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span v-if="searchLoading" class="badge bg-warning-subtle text-warning">
                                                <span class="spinner-border spinner-border-sm me-2"></span>
                                                Searching...
                                            </span>
                                            <span v-else-if="products.length > 0" class="badge bg-success-subtle text-success">
                                                <i class="bi bi-check-circle me-1"></i>
                                                Found {{ products.length }} product{{ products.length !== 1 ? 's' : '' }}
                                                <span v-if="lastPage > 1" class="ms-2">
                                                    (Page {{ currentPage }} of {{ lastPage }})
                                                </span>
                                            </span>
                                            <span v-else-if="searchQuery" class="badge bg-danger-subtle text-danger">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                No results found
                                            </span>
                                        </div>
                                        <button 
                                            v-if="searchQuery && !searchLoading"
                                            class="btn btn-sm btn-outline-secondary"
                                            @click="clearSearch"
                                            :disabled="loading"
                                        >
                                            <i class="bi bi-x-circle me-1"></i>Clear Search
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
            <!-- Loading Indicator -->
            <div v-if="loading && !searchLoading" class="text-center py-5">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading products...</span>
                </div>
                <p class="mt-3 text-muted">
                    {{ searchQuery ? 'Loading search results...' : 'Loading products...' }}
                </p>
            </div>
    
            <!-- Products Grid -->
            <div v-else>
                <div v-if="products.length === 0 && !loading" class="text-center py-5">
                    <div class="empty-state">
                        <i class="bi bi-search display-1 text-muted mb-3"></i>
                        <h3 v-if="searchQuery">No matching products found</h3>
                        <h3 v-else>No products available</h3>
                        <p class="text-muted mb-4" v-if="searchQuery">
                            No products found for "{{ searchQuery }}"
                        </p>
                        <p class="text-muted mb-4" v-else>
                            There are currently no products in the catalog.
                        </p>
                        <button v-if="searchQuery" @click="clearSearch" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-2"></i>View All Products
                        </button>
                        <button v-else @click="getProducts(1)" class="btn btn-primary">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                    </div>
                </div>
                
                <div v-else-if="products.length > 0" class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-4" 
                         v-for="product in products" 
                         :key="product.id">
                        <div class="card product-card h-100">
                            <div class="product-image-container p-2">
                                <img :src="OurImage(product.image)" 
                                     class="card-img-top product-image" 
                                     :alt="product.item_name"
                                     @error="(e) => e.target.src = '/upload/no-image.png'"/>
                                <span class="discount-badge" v-if="product.discount && product.discount > 0">
                                    -{{ product.discount }}%
                                </span>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ product.item_name }}</h5>
                                <p class="card-text text-muted small">
                                    {{ product.description?.substring(0, 80) }}...
                                </p>
                                <div class="mt-auto">
                                    <div class="mb-2">
                                        <span class="h5 text-primary">
                                            UGX : {{ calculateDiscountedPrice(product.price, product.discount) }}
                                        </span>
                                        <span v-if="product.discount" 
                                              class="text-muted text-decoration-line-through ms-2">
                                            UGX : {{ product.price }}
                                        </span>
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-primary btn-sm" @click="viewProduct(product.id)">
                                            View Details
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
                <!-- Pagination -->
                <div v-if="lastPage > 1 && !loading" class="d-flex justify-content-center mt-4">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                                <button 
                                    class="page-link" 
                                    @click="getProducts(currentPage - 1)"
                                    :disabled="currentPage === 1 || loading"
                                >
                                    <i class="bi bi-chevron-left"></i> Previous
                                </button>
                            </li>
                            
                            <!-- Dynamic page numbers -->
                            <template v-for="pageNumber in Math.min(5, lastPage)" :key="pageNumber">
                                <li 
                                    v-if="shouldShowPage(pageNumber)"
                                    class="page-item"
                                    :class="{ active: pageNumber === currentPage }"
                                >
                                    <button 
                                        class="page-link" 
                                        @click="getProducts(pageNumber)"
                                        :disabled="loading"
                                    >
                                        {{ pageNumber }}
                                    </button>
                                </li>
                            </template>
                            
                            <li v-if="lastPage > 5 && currentPage < lastPage - 2" class="page-item disabled">
                                <span class="page-link">...</span>
                            </li>
                            
                            <li v-if="lastPage > 5" class="page-item" :class="{ active: lastPage === currentPage }">
                                <button 
                                    class="page-link" 
                                    @click="getProducts(lastPage)"
                                    :disabled="loading"
                                >
                                    {{ lastPage }}
                                </button>
                            </li>
                            
                            <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                                <button 
                                    class="page-link" 
                                    @click="getProducts(currentPage + 1)"
                                    :disabled="currentPage === lastPage || loading"
                                >
                                    Next <i class="bi bi-chevron-right"></i>
                                </button>
                            </li>
                        </ul>
                    </nav>
                </div>
                
                <!-- Search Results Info -->
                <div v-if="searchQuery && products.length > 0 && !loading" class="text-center mt-4">
                    <p class="text-muted">
                        <i class="bi bi-search text-primary me-2"></i>
                        Showing results for "{{ searchQuery }}" 
                        <span v-if="lastPage > 1">(Page {{ currentPage }} of {{ lastPage }})</span>
                        <button @click="clearSearch" class="btn btn-link p-0 ms-2">
                            <i class="bi bi-x-circle"></i> Clear search
                        </button>
                    </p>
                </div>
            </div>
        </div>
    
        <!-- Footer Component -->
        <AppFooter />
    </template>
    
    <style scoped>
    /* Keep all your existing styles from the original file */
    /* ... (all your existing styles remain the same) ... */
    
    /* Additional styles for the updated layout */
    .page-header {
        margin-top: 2rem;
    }
    
    .admin-controls {
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        padding: 1rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        border: 1px solid #dee2e6;
    }
    
    .product-card {
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
        border-radius: 12px;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        border-color: #007bff;
    }
    
    .product-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
        border-radius: 8px;
        transition: transform 0.3s ease;
    }
    
    .product-image:hover {
        transform: scale(1.05);
    }
    
    .discount-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff4444, #ff6b6b);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        z-index: 1;
    }
    
    /* Responsive adjustments for the new layout */
    @media (max-width: 768px) {
        .page-header h1 {
            font-size: 2rem;
        }
        
        .admin-controls .btn {
            margin-bottom: 0.5rem;
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .page-header h1 {
            font-size: 1.8rem;
        }
        
        .product-image {
            height: 180px;
        }
    }
    </style>
    
    <script>
    // Helper function for pagination display
    export default {
        methods: {
            shouldShowPage(pageNumber) {
                const { currentPage, lastPage } = this
                
                // Always show first 3 pages
                if (pageNumber <= 3) return true
                
                // Show pages around current page
                if (pageNumber >= currentPage - 1 && pageNumber <= currentPage + 1) return true
                
                // Show last 3 pages
                if (pageNumber >= lastPage - 2) return true
                
                return false
            }
        }
    }
    </script>