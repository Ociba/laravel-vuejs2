<script setup>
    import { useRouter } from "vue-router"
    import { onMounted, ref, watch } from "vue"
    import axios from 'axios'
    
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
        <div class="container my-5">
            <div class="text-center mt-4">
                <button 
                    @click="newProduct" 
                    class="btn btn-primary btn-sm mr-1"
                    :disabled="loading"
                >
                    <i class="bi bi-plus-circle me-2"></i>Add New Product
                </button>
                <button 
                    @click="categoryPage" 
                    class="btn btn-primary btn-sm mr-1"
                    :disabled="loading"
                >
                    <i class="bi bi-plus-circle me-2"></i>Categories
                </button>
                <button 
                    @click="typePage" 
                    class="btn btn-primary btn-sm mr-1"
                    :disabled="loading"
                >
                    <i class="bi bi-plus-circle me-2"></i>Types
                </button>
            </div>
            <h1 class="text-center mb-4">Our Products</h1>
            
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
    
            <!-- Add Product Button -->
        </div>
    </template>
    
    <style scoped>
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
    
    .search-card {
        border: none;
        border-radius: 15px;
        background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        transition: all 0.3s ease;
    }
    
    .search-card:focus-within {
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.25);
    }
    
    .search-card .input-group-text {
        background: transparent;
        border-right: none;
        padding-left: 20px;
    }
    
    .search-card .form-control {
        border-left: none;
        padding-left: 0;
        background: transparent;
        transition: all 0.3s ease;
    }
    
    .search-card .form-control:focus {
        box-shadow: none;
        background: transparent;
    }
    
    .search-card .input-group:focus-within {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        border-radius: 8px;
    }
    
    .empty-state {
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 15px;
        border: 2px dashed #dee2e6;
        animation: fadeIn 0.5s ease;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border: none;
        padding: 12px 24px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .btn-primary:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.3);
    }
    
    .btn-primary:disabled {
        opacity: 0.65;
        cursor: not-allowed;
        transform: none !important;
        box-shadow: none !important;
    }
     .mr-1{
        white-space: 4px;
     }
    .btn-primary::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 5px;
        height: 5px;
        background: rgba(255, 255, 255, 0.5);
        opacity: 0;
        border-radius: 100%;
        transform: scale(1, 1) translate(-50%);
        transform-origin: 50% 50%;
    }
    
    .btn-primary:focus:not(:active)::after {
        animation: ripple 1s ease-out;
    }
    
    .page-link {
        padding: 10px 18px;
        margin: 0 5px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        color: #495057;
        transition: all 0.2s ease;
        font-weight: 500;
    }
    
    .page-link:hover:not(:disabled) {
        background-color: #007bff;
        color: white;
        border-color: #007bff;
        transform: translateY(-2px);
    }
    
    .page-link:disabled {
        opacity: 0.65;
        cursor: not-allowed;
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #007bff, #0056b3);
        border-color: #007bff;
        color: white;
        box-shadow: 0 2px 8px rgba(0,123,255,0.3);
    }
    
    .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
    
    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }
    
    .card-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        line-height: 1.4;
    }
    
    .card-text {
        line-height: 1.6;
        color: #6c757d;
        flex-grow: 1;
    }
    
    .text-primary {
        color: #007bff !important;
        font-weight: 700;
    }
    
    .text-decoration-line-through {
        color: #95a5a6;
        font-size: 0.9em;
    }
    
    .form-control-lg {
        font-size: 1.1rem;
        padding: 15px;
    }
    
    .bi {
        font-size: 1.1em;
    }
    
    .spinner-border {
        vertical-align: middle;
    }
    
    .badge {
        padding: 8px 12px;
        font-weight: 500;
        border-radius: 10px;
    }
    
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes ripple {
        0% {
            transform: scale(0, 0);
            opacity: 1;
        }
        20% {
            transform: scale(25, 25);
            opacity: 1;
        }
        100% {
            opacity: 0;
            transform: scale(40, 40);
        }
    }
    
    @media (max-width: 768px) {
        .search-card .card-body .row > div {
            width: 100%;
        }
        
        .search-card .btn {
            height: auto;
            padding: 12px;
        }
        
        .product-image {
            height: 180px;
        }
        
        .pagination {
            flex-wrap: wrap;
        }
        
        .page-link {
            padding: 8px 14px;
            margin: 2px;
            font-size: 0.9rem;
        }
    }
    
    @media (max-width: 576px) {
        .product-image {
            height: 160px;
        }
        
        .card-title {
            font-size: 1.1rem;
        }
        
        .btn-sm {
            padding: 10px 20px;
            font-size: 1rem;
        }
        
        h1 {
            font-size: 1.8rem;
        }
    }
    
    /* Add smooth transitions for search results */
    .row {
        animation: fadeIn 0.3s ease;
    }
    
    /* Loading animation */
    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.5;
        }
    }
    
    .loading-pulse {
        animation: pulse 1.5s ease-in-out infinite;
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