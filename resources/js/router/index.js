import { createRouter, createWebHistory } from "vue-router";

import ProductIndex from '../components/products/Index.vue'

import notFound from '../components/notFound.vue'

import ProductForm from '../components/products/Form.vue'

const routes =[ 
{
    path:'/',
    name: 'products.index',
    component: ProductIndex,
},
{
    path:'/products/create',
    name: 'products.create',
    component: ProductForm,
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

export default router