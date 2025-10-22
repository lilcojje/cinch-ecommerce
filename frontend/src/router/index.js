import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import ProductView from '../views/ProductView.vue'
import CheckoutView from '../views/CheckoutView.vue'

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/product/:id', name: 'Product', component: ProductView },
  { path: '/checkout', name: 'Checkout', component: CheckoutView },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
