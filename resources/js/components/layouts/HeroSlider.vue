<template>
    <div class="hero-slider">
        <!-- Main Slider -->
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" v-for="(slide, index) in slides" :key="index" 
                        data-bs-target="#heroCarousel" :data-bs-slide-to="index" 
                        :class="{ active: index === 0 }" :aria-label="`Slide ${index + 1}`"></button>
            </div>
            
            <!-- Slides -->
            <div class="carousel-inner">
                <div v-for="(slide, index) in slides" :key="index" 
                     class="carousel-item" :class="{ active: index === 0 }"
                     :style="{ backgroundImage: `url(${slide.image})` }">
                    <div class="carousel-overlay"></div>
                    <div class="container">
                        <div class="carousel-caption">
                            <h1 class="display-4 fw-bold mb-3">{{ slide.title }}</h1>
                            <p class="lead mb-4">{{ slide.description }}</p>
                            <router-link :to="slide.link" class="btn btn-primary btn-lg px-5">
                                {{ slide.buttonText }}
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        
        <!-- Featured Categories -->
        <div class="featured-categories py-4 bg-light">
            <div class="container">
                <h3 class="text-center mb-4">Shop by Category</h3>
                <div class="row g-3">
                    <div v-for="category in featuredCategories" :key="category.id" 
                         class="col-6 col-md-2 col-lg-2">
                        <router-link :to="category.link" class="category-card">
                            <div class="category-icon mb-2">
                                <i :class="category.icon"></i>
                            </div>
                            <span class="category-name">{{ category.name }}</span>
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'

const slides = ref([
    {
        image: 'https://images.unsplash.com/photo-1607082348824-0a96f2a4b9da?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80',
        title: 'Latest Smartphones',
        description: 'Get the newest smartphones with amazing discounts up to 30% off',
        buttonText: 'Shop Now',
        link: '/phones/smartphones'
    },
    {
        image: 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80',
        title: 'Premium Laptops',
        description: 'High-performance laptops for work, gaming, and creativity',
        buttonText: 'Explore Laptops',
        link: '/computing/laptops'
    },
    {
        image: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80',
        title: 'Home Entertainment',
        description: 'Transform your home with our latest audio and video systems',
        buttonText: 'Discover More',
        link: '/electronics/tvs'
    },
    {
        image: 'https://images.unsplash.com/photo-1556656793-08538906a9f8?ixlib=rb-1.2.1&auto=format&fit=crop&w=1600&q=80',
        title: 'Gaming Gear',
        description: 'Level up your gaming experience with our premium gaming equipment',
        buttonText: 'View Collection',
        link: '/others/gaming'
    }
])

const featuredCategories = ref([
    { id: 1, name: 'Phones', icon: 'bi bi-phone', link: '/phones' },
    { id: 2, name: 'Laptops', icon: 'bi bi-laptop', link: '/computing/laptops' },
    { id: 3, name: 'TVs', icon: 'bi bi-tv', link: '/electronics/tvs' },
    { id: 4, name: 'Audio', icon: 'bi bi-headphones', link: '/electronics/audio' },
    { id: 5, name: 'Gaming', icon: 'bi bi-controller', link: '/others/gaming' },
    { id: 6, name: 'Cameras', icon: 'bi bi-camera', link: '/electronics/cameras' },
    { id: 7, name: 'Wearables', icon: 'bi bi-smartwatch', link: '/phones/wearables' },
    { id: 8, name: 'Appliances', icon: 'bi bi-house-gear', link: '/others/appliances' },
    { id: 9, name: 'Accessories', icon: 'bi bi-plug', link: '/phones/accessories' },
    { id: 10, name: 'Components', icon: 'bi bi-cpu', link: '/computing/components' },
    { id: 11, name: 'Tablets', icon: 'bi bi-tablet', link: '/phones/tablets' },
    { id: 12, name: 'All Products', icon: 'bi bi-grid-3x3-gap', link: '/products' }
])

// Initialize carousel when component mounts
onMounted(() => {
    // Bootstrap carousel is initialized automatically with data-bs-ride
})
</script>

<style scoped>
.hero-slider {
    margin-top: 76px; /* Account for fixed navbar */
}

.carousel-item {
    height: 500px;
    background-size: cover;
    background-position: center;
    position: relative;
}

.carousel-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to right, rgba(0,0,0,0.7), rgba(0,0,0,0.3));
}

.carousel-caption {
    position: relative;
    z-index: 1;
    text-align: left;
    margin-top: 20%;
    transform: translateY(-50%);
    max-width: 600px;
    padding: 2rem;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.carousel-caption h1 {
    font-size: 3.5rem;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
    color: white;
}

.carousel-caption p {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 0.9);
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.carousel-caption .btn {
    padding: 1rem 2.5rem;
    font-size: 1.2rem;
    font-weight: 600;
    border-radius: 50px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
}

.carousel-caption .btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.4);
}

.carousel-indicators {
    bottom: 30px;
}

.carousel-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin: 0 8px;
    border: 2px solid white;
    background-color: transparent;
}

.carousel-indicators button.active {
    background-color: white;
}

.carousel-control-prev,
.carousel-control-next {
    width: 50px;
    height: 50px;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    margin: 0 20px;
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
}

.carousel-control-prev:hover,
.carousel-control-next:hover {
    background-color: rgba(255, 255, 255, 0.3);
}

.featured-categories {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

.category-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 1.5rem 0.5rem;
    background: white;
    border-radius: 10px;
    text-decoration: none;
    color: #333;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    height: 100%;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    border-color: #007bff;
    color: #007bff;
}

.category-icon {
    width: 60px;
    height: 60px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 50%;
    color: white;
    font-size: 1.5rem;
    transition: all 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1);
    background: linear-gradient(135deg, #0056b3, #004085);
}

.category-name {
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
    margin-top: 0.5rem;
}

/* Responsive styles */
@media (max-width: 768px) {
    .carousel-item {
        height: 400px;
    }
    
    .carousel-caption {
        padding: 1rem;
        text-align: center;
    }
    
    .carousel-caption h1 {
        font-size: 2rem;
    }
    
    .carousel-caption p {
        font-size: 1rem;
    }
    
    .carousel-caption .btn {
        padding: 0.8rem 2rem;
        font-size: 1rem;
    }
    
    .featured-categories .row {
        justify-content: center;
    }
    
    .category-card {
        padding: 1rem 0.5rem;
    }
    
    .category-icon {
        width: 50px;
        height: 50px;
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .carousel-item {
        height: 350px;
    }
    
    .carousel-caption h1 {
        font-size: 1.8rem;
    }
    
    .carousel-caption {
        padding: 0.8rem;
    }
    
    .featured-categories .col-6 {
        flex: 0 0 auto;
        width: 33.333%;
    }
}
</style>