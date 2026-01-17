<template>
    <footer class="footer bg-dark text-white">
        <!-- Main Footer -->
        <div class="footer-main py-5">
            <div class="container">
                <div class="row">
                    <!-- Company Info -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-brand mb-3">
                            <router-link to="/" class="navbar-brand text-white">
                                <i class="bi bi-shop me-2"></i> Ugatrade Online Shop
                            </router-link>
                        </div>
                        <p class="text-light mb-4">
                            Your one-stop destination for all electronics, gadgets, and tech products. 
                            We deliver quality products with the best customer service.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link me-3">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="social-link me-3">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="social-link me-3">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="social-link">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <h5 class="footer-title mb-4">Quick Links</h5>
                        <ul class="footer-links list-unstyled">
                            <li class="mb-2">
                                <router-link to="/" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>Home
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/products" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>All Products
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/about" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>About Us
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/contact" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>Contact Us
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/faq" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>FAQ
                                </router-link>
                            </li>
                        </ul>
                    </div>

                    <!-- Categories -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="footer-title mb-4">Categories</h5>
                        <ul class="footer-links list-unstyled">
                            <li class="mb-2">
                                <router-link to="/phones" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>Smartphones
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/computing/laptops" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>Laptops
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/electronics" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>Electronics
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/others/gaming" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>Gaming
                                </router-link>
                            </li>
                            <li class="mb-2">
                                <router-link to="/phones/accessories" class="footer-link">
                                    <i class="bi bi-chevron-right me-2"></i>Accessories
                                </router-link>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact & Newsletter -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h5 class="footer-title mb-4">Contact Us</h5>
                        <ul class="footer-contact list-unstyled mb-4">
                            <li class="mb-3">
                                <i class="bi bi-geo-alt me-3"></i>
                                <span>123 Tech Street, Digital City</span>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-telephone me-3"></i>
                                <span>+1 234 567 8900</span>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-envelope me-3"></i>
                                <span>support@eshop.com</span>
                            </li>
                        </ul>
                        
                        <h5 class="footer-title mb-3">Newsletter</h5>
                        <p class="text-light small mb-3">Subscribe to get updates on new products and offers</p>
                        <div class="newsletter-form">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email" v-model="form.email">
                                <button class="btn btn-primary"  @click="handleSave">
                                    <i class="bi bi-send"></i> Submit
                                </button>
                                <small style="color:red;" v-if="errors.email">{{ errors.email }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom py-3 bg-black">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="mb-0 text-center text-md-start">
                            &copy; {{ currentYear }} Ugatrade Online Shop. All rights reserved.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="payment-methods text-center text-md-end">
                            <i class="bi bi-credit-card me-2" title="Visa"></i>
                            <i class="bi bi-credit-card me-2" title="MasterCard"></i>
                            <i class="bi bi-paypal me-2" title="PayPal"></i>
                            <i class="bi bi-cash-coin" title="Cash on Delivery"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <button class="btn btn-primary back-to-top" @click="scrollToTop" 
                :class="{ show: showBackToTop }">
            <i class="bi bi-arrow-up"></i>
        </button>
    </footer>
</template>

<script setup>
import { ref, onMounted, reactive, onUnmounted } from 'vue'
import { useRouter } from "vue-router"
import axios from "axios"

const currentYear = ref(new Date().getFullYear())
const errors = ref({})
const showBackToTop = ref(false)

const router = useRouter()

/**
 * FORM STATE
 */
 const form = reactive({
    email: "",
})

// Subscribe to newsletter
const handleSave = () => {
    
    axios.post("/api/subscribe", form)
    .then((response) => {

        toast.fire({
            icon: "success",
            title: "Email Added Successfully",
        })

         // Reset form
         Object.keys(form).forEach(key => {
                if (key !== 'status') {
                    form[key] = ""
                }
            })
            
        router.push("/")

    }).catch((error) => {
        if(error.response.status === 422){
            errors.value = error.response.data.errors
        }
    })
}

// Scroll to top function
const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    })
}

// Show/hide back to top button based on scroll position
const handleScroll = () => {
    showBackToTop.value = window.scrollY > 300
}

// Add scroll event listener
onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

// Clean up event listener
onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll)
})
</script>

<style scoped>
.footer {
    position: relative;
    background: linear-gradient(135deg, #2c3e50, #1a1a2e);
}

.footer-brand {
    font-size: 1.8rem;
    font-weight: 700;
}

.footer-brand a {
    color: white;
    text-decoration: none;
}

.footer-brand a:hover {
    color: #007bff;
}

.footer-title {
    font-size: 1.2rem;
    font-weight: 600;
    color: white;
    position: relative;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.footer-title::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, #007bff, #00bfff);
    border-radius: 2px;
}

.footer-links li {
    transition: all 0.3s ease;
}

.footer-links li:hover {
    transform: translateX(5px);
}

.footer-link {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: all 0.3s ease;
    display: block;
    padding: 5px 0;
}

.footer-link:hover {
    color: #007bff;
    transform: translateX(5px);
}

.footer-contact li {
    display: flex;
    align-items: center;
    color: rgba(255, 255, 255, 0.8);
    margin-bottom: 10px;
}

.footer-contact i {
    color: #007bff;
    font-size: 1.2rem;
    width: 24px;
}

.social-links {
    display: flex;
    gap: 15px;
}

.social-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 1.2rem;
}

.social-link:hover {
    background: #007bff;
    color: white;
    transform: translateY(-3px);
}

.newsletter-form .form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    border-radius: 5px 0 0 5px;
}

.newsletter-form .form-control::placeholder {
    color: rgba(255, 255, 255, 0.6);
}

.newsletter-form .form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: #007bff;
    box-shadow: none;
    color: white;
}

.newsletter-form .btn {
    border-radius: 0 5px 5px 0;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border: none;
}

.payment-methods i {
    font-size: 1.5rem;
    color: rgba(255, 255, 255, 0.7);
    margin: 0 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.payment-methods i:hover {
    color: #007bff;
    transform: translateY(-2px);
}

.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 123, 255, 0.4);
}

/* Responsive styles */
@media (max-width: 768px) {
    .footer-main {
        padding: 3rem 0;
    }
    
    .footer-title {
        font-size: 1.1rem;
    }
    
    .social-links {
        justify-content: center;
    }
    
    .payment-methods {
        margin-top: 1rem;
    }
    
    .back-to-top {
        bottom: 20px;
        right: 20px;
        width: 45px;
        height: 45px;
    }
}

@media (max-width: 576px) {
    .footer-main {
        padding: 2rem 0;
    }
    
    .footer-brand {
        text-align: center;
    }
    
    .footer-title {
        text-align: center;
    }
    
    .footer-title::after {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .footer-links {
        text-align: center;
    }
    
    .footer-contact li {
        justify-content: center;
    }
}
</style>