<script setup>
    import { useRouter } from "vue-router"
    import { onMounted, ref } from "vue"
    import axios from 'axios'
    
    const router = useRouter()
    const products = ref([])
    const currentPage = ref(1)
    const lastPage = ref(1)
    const loading = ref(false)
    
    onMounted(() => {
        getProducts()
    })
    
    const getProducts = async (page = 1) => {
        loading.value = true
        try {
            const response = await axios.get(`/api/products?page=${page}`)
            products.value = response.data.products.data || []
            currentPage.value = response.data.products.current_page || 1
            lastPage.value = response.data.products.last_page || 1
        } catch (error) {
            console.error('Error:', error)
        } finally {
            loading.value = false
        }
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
    const viewProduct = (id) => router.push(`/products/${id}`)
    </script>
    
    <template>
        <div class="container my-5">
            <h1 class="text-center mb-4">Our Products</h1>
    
            <!-- Products Grid -->
            <div class="row">
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
    
            <!-- Simple Pagination at Bottom -->
            <div v-if="lastPage > 1" class="d-flex justify-content-center mt-4">
                <nav>
                    <ul class="pagination">
                        <li class="page-item" :class="{ disabled: currentPage === 1 }">
                            <button class="page-link" @click="getProducts(currentPage - 1)">Previous</button>
                        </li>
                        
                        <!-- Show first, current, and last pages -->
                        <li v-if="currentPage > 2" class="page-item">
                            <button class="page-link" @click="getProducts(1)">1</button>
                        </li>
                        <li v-if="currentPage > 3" class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        
                        <li v-if="currentPage > 1" class="page-item">
                            <button class="page-link" @click="getProducts(currentPage - 1)">
                                {{ currentPage - 1 }}
                            </button>
                        </li>
                        
                        <li class="page-item active">
                            <span class="page-link">{{ currentPage }}</span>
                        </li>
                        
                        <li v-if="currentPage < lastPage" class="page-item">
                            <button class="page-link" @click="getProducts(currentPage + 1)">
                                {{ currentPage + 1 }}
                            </button>
                        </li>
                        
                        <li v-if="currentPage < lastPage - 2" class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                        <li v-if="currentPage < lastPage - 1" class="page-item">
                            <button class="page-link" @click="getProducts(lastPage)">{{ lastPage }}</button>
                        </li>
                        
                        <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                            <button class="page-link" @click="getProducts(currentPage + 1)">Next</button>
                        </li>
                    </ul>
                </nav>
            </div>
    
            <!-- Add Product Button -->
            <div class="text-center mt-4">
                <button @click="newProduct" class="btn btn-primary">
                    Add New Product
                </button>
            </div>
        </div>
    </template>
    
    <style scoped>
    .product-image {
        height: 200px;
        object-fit: cover;
        width: 100%;
    }
    
    .discount-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #ff4444;
        color: white;
        padding: 3px 8px;
        border-radius: 3px;
        font-size: 12px;
        font-weight: bold;
    }
    
    .product-card {
        transition: transform 0.2s;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    </style>