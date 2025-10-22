<template>
  <div class="container">
    <h1>Checkout</h1>
    <div v-if="cart.length === 0">
      <p>Your cart is empty.</p>
    </div>
    <div v-else>
      <div v-for="item in cart" :key="item.id" class="cart-item">
        <h3>{{ item.name }}</h3>
        <p>₱{{ item.price }}</p>
      </div>
      <button @click="placeOrder">Place Order</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const cart = ref([])

onMounted(() => {
  const items = localStorage.getItem('cart')
  cart.value = items ? JSON.parse(items) : []
})

async function placeOrder() {
  const payload = {
    user_id: 1,
    items: cart.value.map(p => ({
      product_id: p.id,
      quantity: 1,
      price: p.price
    }))
  }

  await axios.post('http://localhost:8001/api/orders', payload)
  alert('Order placed successfully!')
  localStorage.removeItem('cart')
}
</script>

<style>
.container { padding: 2rem; }
.cart-item { border-bottom: 1px solid #ddd; margin-bottom: 1rem; }
</style>
