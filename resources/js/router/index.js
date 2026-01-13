import { createRouter, createWebHistory } from "vue-router";

import ProductIndex from '../components/products/Index.vue'

import notFound from '../components/notFound.vue'

import ProductForm from '../components/products/Form.vue'

import CategoryIndex from '../components/categories/Index.vue'

import CategoryForm from '../components/categories/CategoryForm.vue'

import TypeIndex from '../components/types/Index.vue'

import TypeForm from "../components/types/TypeForm.vue";

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