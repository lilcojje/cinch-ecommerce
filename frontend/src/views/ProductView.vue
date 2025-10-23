<template>
  <div class="product-container" v-if="product">
    <div class="product-card">
      <div class="image-wrapper">
        <img :src="product.image_url" alt="" class="product-image" />
      </div>

      <div class="product-info">
        <h1 class="product-name">{{ product.name }}</h1>
        <p class="product-description">{{ product.description }}</p>
        <p class="product-price">${{ Number(product.price).toFixed(2) }}</p>

        <div class="quantity">
          <label for="qty">Quantity</label>
          <input id="qty" type="number" v-model.number="quantity" min="1" />
        </div>

        <button class="add-btn" @click="addToCart">Add to Cart</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import api from "@/static/config.json";
import { ref, onMounted } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";

const route = useRoute();
const router = useRouter();
const product = ref(null);
const quantity = ref(1);

onMounted(async () => {
  const { data } = await axios.get(`${api.API_URL_CATALOG}/products/${route.params.id}`);
  product.value = data;
});

function addToCart() {
  let cart = JSON.parse(localStorage.getItem("cart")) || [];
  const existing = cart.find((item) => item.id === product.value.id);

  if (existing) {
    existing.quantity += quantity.value;
  } else {
    cart.push({ ...product.value, quantity: quantity.value });
  }

  localStorage.setItem("cart", JSON.stringify(cart));
  router.push("/checkout");
}
</script>

