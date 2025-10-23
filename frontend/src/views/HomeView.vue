<template>
  <div class="catalog-container">
    <h1 class="catalog-title">Product Catalog</h1>

    <div class="catalog-grid">
      <div 
        v-for="p in products" 
        :key="p.id" 
        class="product-card"
      >
        <div class="image-wrapper">
          <img :src="p.image_url" alt="" class="product-image"/>
        </div>

        <div class="product-info">
          <h2 class="product-name">{{ p.name }}</h2>
          <p class="product-price">${{ p.price }}</p>
          <router-link 
            :to="`/product/${p.id}`" 
            class="details-btn"
          >
            View Details
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import api from "@/static/config.json";
import { ref, onMounted } from 'vue'
import axios from 'axios'

const products = ref([])

onMounted(async () => {
  const { data } = await axios.get(api.API_URL_CATALOG + '/products')
  products.value = data.data ?? data
})
</script>

<style scoped>
/* Layout */
.catalog-container {
  padding: 3rem 2rem;
  max-width: 1200px;
  margin: auto;
  background-color: #fafafa;
  min-height: 100vh;
}

.catalog-title {
  text-align: center;
  font-size: 2.5rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 2.5rem;
  letter-spacing: -0.5px;
}

/* Grid */
.catalog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
  gap: 2rem;
}

/* Card */
.product-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  overflow: hidden;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  display: flex;
  flex-direction: column;
}

.product-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 8px 28px rgba(0,0,0,0.12);
}

/* Image */
.image-wrapper {
  width: 100%;
  aspect-ratio: 4 / 3;
  overflow: hidden;
  border-bottom: 1px solid #eee;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.05);
}

/* Text */
.product-info {
  padding: 1.25rem;
  text-align: center;
}

.product-name {
  font-size: 1.2rem;
  font-weight: 600;
  color: #333;
  margin-bottom: 0.5rem;
}

.product-price {
  color: #666;
  font-size: 1rem;
  margin-bottom: 1.2rem;
}

/* Button */
.details-btn {
  display: inline-block;
  padding: 0.6rem 1.2rem;
  border-radius: 50px;
  background: linear-gradient(135deg, #4f46e5, #6d28d9);
  color: #fff;
  text-decoration: none;
  font-weight: 500;
  transition: background 0.3s ease, transform 0.2s ease;
}

.details-btn:hover {
  background: linear-gradient(135deg, #4338ca, #5b21b6);
  transform: translateY(-2px);
}
</style>
