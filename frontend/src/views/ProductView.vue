<template>
  <div class="container" v-if="product">
    <img :src="product.image_url" alt="" class="image"/>
    <h1>{{ product.name }}</h1>
    <p>{{ product.description }}</p>
    <p>₱{{ product.price }}</p>
    <button @click="addToCart">Add to Cart</button>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()
const product = ref(null)

onMounted(async () => {
  const { data } = await axios.get(`http://localhost:8000/api/products/${route.params.id}`)
  product.value = data
})

function addToCart() {
  localStorage.setItem('cart', JSON.stringify([product.value]))
  router.push('/checkout')
}
</script>

<style>
.container { padding: 2rem; }
.image { width: 100%; max-width: 400px; border-radius: 10px; }
</style>
