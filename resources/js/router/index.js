import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from '../stores/auth'

// Public components
import Login from '../components/auth/Login.vue'
import Register from '../components/auth/Register.vue'
import ProductIndex from '../components/products/Index.vue'
import notFound from '../components/notFound.vue'
import ProductForm from '../components/products/Form.vue'
import SellerView from '../components/sellers/View.vue'
import CategoryIndex from '../components/categories/Index.vue'
import CategoryForm from '../components/categories/CategoryForm.vue'
import ColorForm from '../components/colors/ColorForm.vue'
import ColorIndex from '../components/colors/Index.vue'
import MeasureIndex from '../components/measures/Index.vue'
import MeasureForm from '../components/measures/MeasureForm.vue'
import LocationIndex from '../components/locations/Index.vue'
import LocationForm from '../components/locations/LocationForm.vue'
import AdchargesIndex from '../components/adcharges/Index.vue'
import AdchargesForm from '../components/adcharges/AdchargesForm.vue'
import TypeIndex from '../components/types/Index.vue'
import TypeForm from "../components/types/TypeForm.vue"
import NewsSubscription from "../components/layouts/AppFooter.vue"
import NewsIndex from "../components/subscriptions/News.vue"

// Protected components
import Dashboard from '../components/dashboard/Index.vue'
import AdminDashboard from '../components/dashboard/AdminDashboard.vue'
import SellerDashboard from '../components/dashboard/SellerDashboard.vue'
import BuyerDashboard from '../components/dashboard/BuyerDashboard.vue'
import SellerIndex from '../components/sellers/Index.vue'

const routes = [
    {
        path: '/',
        name: 'products.index',
        component: ProductIndex,
    },
    {
        path: '/subscribe',
        name: 'layouts.subscribe',
        component: NewsSubscription
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: { guestOnly: true }
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: { guestOnly: true }
    },
    // Protected routes - Dashboard
    {
        path: '/dashboard',
        name: 'dashboard',
        component: Dashboard,
        meta: { requiresAuth: true },
        // REMOVED the slow redirect function - handled in Login.vue
        children: [
            {
                path: 'admin',
                name: 'admin-dashboard',
                component: AdminDashboard,
                meta: { requiresAdmin: true }
            },
            {
                path: 'seller',
                name: 'seller-dashboard',
                component: SellerDashboard,
                meta: { requiresSeller: true }
            },
            {
                path: 'buyer',
                name: 'buyer-dashboard',
                component: BuyerDashboard,
                meta: { requiresBuyer: true }
            }
        ]
    },
    {
        path: '/my-products',
        name: 'sellers.index',
        component: SellerIndex,
    },
    {
        path: '/products/create',
        name: 'products.create',
        component: ProductForm,
    },
    {
        path: '/products/:id/edit',
        name: 'products.edit',
        component: ProductForm,
    },
    {
        path: '/products/:id/view',
        name: 'products.view',
        component: SellerView,
    },
    {
        path: '/categories',
        name: 'categories.index',
        component: CategoryIndex,
    },
    {
        path: '/categories/create',
        name: 'categories.create',
        component: CategoryForm,
    },
    {
        path: '/categories/:id/edit',
        name: 'categories.edit',
        component: CategoryForm,
    },
    {
        path: '/types',
        name: 'types.index',
        component: TypeIndex,
    },
    {
        path: '/types/create',
        name: 'types.create',
        component: TypeForm,
    },
    {
        path: '/types/:id/edit',
        name: 'types.edit',
        component: TypeForm
    },
    {
        path: '/colors',
        name: 'colors.index',
        component: ColorIndex,
    },
    {
        path: '/color/create',
        name: 'colors.create',
        component: ColorForm,
    },
    {
        path: '/color/:id/edit',
        name: 'colors.edit',
        component: ColorForm
    },
    {
        path: '/measures',
        name: 'measures.index',
        component: MeasureIndex,
    },
    {
        path: '/measure/create',
        name: 'measures.create',
        component: MeasureForm,
    },
    {
        path: '/measure/:id/edit',
        name: 'measures.edit',
        component: MeasureForm
    },
    {
        path: '/locations',
        name: 'locations.index',
        component: LocationIndex,
    },
    {
        path: '/location/create',
        name: 'locations.create',
        component: LocationForm,
    },
    {
        path: '/location/:id/edit',
        name: 'locations.edit',
        component: LocationForm
    },
    {
        path: '/adcharges',
        name: 'adcharges.index',
        component: AdchargesIndex,
    },
    {
        path: '/adcharge/create',
        name: 'adcharges.create',
        component: AdchargesForm,
    },
    {
        path: '/adcharge/:id/edit',
        name: 'adcharges.edit',
        component: AdchargesForm
    },
    {
        path: '/news-subscription',
        name: 'subscriptions.news',
        component: NewsIndex,
    },
    {
        path: '/:pathMatch(.*)*',
        name: 'notfound',
        component: notFound
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Navigation guards - OPTIMIZED FOR SPEED
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore()
    
    // FAST authentication check - synchronous
    const token = localStorage.getItem('auth_token')
    const isAuthenticated = !!token
    
    // Check if route requires authentication
    if (to.meta.requiresAuth) {
        if (!isAuthenticated) {
            next({ name: 'login', query: { redirect: to.fullPath } })
            return
        }

        // Check for specific role requirements - using current user data
        if (to.meta.requiresAdmin && authStore.user?.user_type !== 'admin') {
            next('/dashboard')
            return
        }

        if (to.meta.requiresSeller && authStore.user?.user_type !== 'seller') {
            next('/dashboard')
            return
        }

        if (to.meta.requiresBuyer && authStore.user?.user_type !== 'buyer') {
            next('/dashboard')
            return
        }
    }

    // Redirect authenticated users away from guest-only pages
    if (to.meta.guestOnly && isAuthenticated) {
        next('/dashboard')
        return
    }

    next()
})

export default router