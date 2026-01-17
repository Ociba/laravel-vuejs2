import { createRouter, createWebHistory } from "vue-router";

import { useAuthStore } from '../stores/auth'

// Public components (will create these)
import Login from '../components/auth/Login.vue'
import Register from '../components/auth/Register.vue'
// import Home from '../components/Home.vue'

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

import  NewsSubscription from "../components/layouts/AppFooter.vue"

import NewsIndex from "../components/subscriptions/News.vue"

// Protected components (will create these)
import Dashboard from '../components/dashboard/Index.vue'
import AdminDashboard from '../components/dashboard/AdminDashboard.vue'
import SellerDashboard from '../components/dashboard/SellerDashboard.vue'
import BuyerDashboard from '../components/dashboard/BuyerDashboard.vue'

import SellerIndex from '../components/sellers/Index.vue'


const routes =[ 
{
    path:'/',
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
    children: [
        {
            path: '',
            redirect: { name: 'role-dashboard' }
        },
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

// Protected routes - Profile
// {
//     path: '/profile',
//     name: 'profile',
//     component: () => import('../components/profile/Index.vue'),
//     meta: { requiresAuth: true }
// },
{
    path:'/my-products',
    name: 'sellers.index',
    component: SellerIndex,
},
{
    path:'/products/create',
    name: 'products.create',
    component: ProductForm,
},

{
    path:'/products/:id/edit',
    name: 'products.edit',
    component: ProductForm,
},
{
    path:'/products/:id/view',
    name: 'products.view',
    component: SellerView,
},
{
    path:'/categories',
    name: 'categories.index',
    component: CategoryIndex,
},
{
    path:'/categories/create',
    name: 'categories.create',
    component: CategoryForm,
},
{
    path:'/categories/:id/edit',
    name: 'categories.edit',
    component: CategoryForm,
},
{
    path:'/types',
    name: 'types.index',
    component: TypeIndex,
},
{
    path:'/types/create',
    name: 'types.create',
    component: TypeForm,
},
{
    path: '/types/:id/edit',
    name: 'types.edit',
    component: TypeForm
},
{
    path:'/colors',
    name: 'colors.index',
    component: ColorIndex,
},
{
    path:'/color/create',
    name: 'colors.create',
    component: ColorForm,
},
{
    path: '/color/:id/edit',
    name: 'colors.edit',
    component: ColorForm
},
{
    path:'/measures',
    name: 'measures.index',
    component: MeasureIndex,
},
{
    path:'/measure/create',
    name: 'measures.create',
    component: MeasureForm,
},
{
    path: '/measure/:id/edit',
    name: 'measures.edit',
    component: MeasureForm
},
{
    path:'/locations',
    name: 'locations.index',
    component: LocationIndex,
},
{
    path:'/location/create',
    name: 'locatios.create',
    component: LocationForm,
},
{
    path: '/location/:id/edit',
    name: 'locations.edit',
    component: LocationForm
},
{
    path:'/adcharges',
    name: 'adcharges.index',
    component: AdchargesIndex,
},
{
    path:'/adcharge/create',
    name: 'adcharges.create',
    component: AdchargesForm,
},
{
    path: '/adcharge/:id/edit',
    name: 'adcharges.edit',
    component: AdchargesForm
},

{
    path:'/news-subscription',
    name: 'subscriptions.news',
    component: NewsIndex,
},

{
    path:'/:pathMatch(.*)*',
    name:'notfound',
    component: notFound
}
]

const router =createRouter({
    history:createWebHistory(),
    routes
})

// Navigation guards
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()
    
    // Check if route requires authentication
    if (to.meta.requiresAuth) {
        const isAuthenticated = await authStore.checkAuth()
        
        if (!isAuthenticated) {
            next('/login')
            return
        }

        // Check for specific role requirements
        if (to.meta.requiresAdmin && !authStore.isAdmin) {
            next('/dashboard')
            return
        }

        if (to.meta.requiresSeller && !authStore.isSeller) {
            next('/dashboard')
            return
        }

        if (to.meta.requiresBuyer && !authStore.isBuyer) {
            next('/dashboard')
            return
        }
    }

    // Redirect authenticated users away from guest-only pages
    if (to.meta.guestOnly && authStore.isAuthenticated) {
        next('/dashboard')
        return
    }

    next()
})


export default router