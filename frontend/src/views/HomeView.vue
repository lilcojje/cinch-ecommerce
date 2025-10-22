<template>
  <div class="container">
    <h1>Product Catalog</h1>
    <div class="grid">
      <div v-for="p in products" :key="p.id" class="card">
        <img :src="p.image_url" alt="" class="image"/>
        <h2>{{ p.name }}</h2>
        <p>₱{{ p.price }}</p>
        <router-link :to="`/product/${p.id}`">View Details</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const products = ref([])

onMounted(async () => {
  const { data } = await axios.get('http://localhost:8000/api/products')
  products.value = data.data ?? data
})
</script>

<style>
.container { padding: 2rem; }
.grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
.card { padding: 1rem; border: 1px solid #ddd; border-radius: 10px; text-align: center; }
.image { width: 100%; height: 150px; object-fit: cover; }
</style>
