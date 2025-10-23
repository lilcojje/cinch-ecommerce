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

<style scoped>
/* Layout */
.product-container {
  display: flex;
  justify-content: center;
  padding: 3rem 1.5rem;
  background: #fafafa;
  min-height: 100vh;
}

.product-card {
  display: flex;
  flex-direction: row;
  gap: 2.5rem;
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 6px 30px rgba(0, 0, 0, 0.08);
  max-width: 900px;
  padding: 2rem;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.product-card:hover {
  transform: translateY(-4px);
  box-shadow: 0 10px 35px rgba(0, 0, 0, 0.1);
}

/* Image */
.image-wrapper {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
}

.product-image {
  width: 100%;
  max-width: 400px;
  border-radius: 16px;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.product-card:hover .product-image {
  transform: scale(1.03);
}

/* Info */
.product-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.product-name {
  font-size: 2rem;
  font-weight: 700;
  color: #222;
  margin-bottom: 0.8rem;
}

.product-description {
  color: #555;
  line-height: 1.6;
  font-size: 1rem;
  margin-bottom: 1.2rem;
}

.product-price {
  font-size: 1.4rem;
  font-weight: 600;
  color: #4f46e5;
  margin-bottom: 1.5rem;
}

/* Quantity */
.quantity {
  display: flex;
  align-items: center;
  gap: 0.8rem;
  margin-bottom: 1.5rem;
}

.quantity label {
  font-weight: 500;
  color: #333;
}

.quantity input {
  width: 70px;
  padding: 0.5rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  text-align: center;
  transition: border 0.2s ease;
}

.quantity input:focus {
  outline: none;
  border-color: #6366f1;
}

/* Button */
.add-btn {
  align-self: flex-start;
  background: linear-gradient(135deg, #4f46e5, #6d28d9);
  color: #fff;
  border: none;
  border-radius: 10px;
  padding: 0.8rem 1.6rem;
  font-weight: 500;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
}

.add-btn:hover {
  background: linear-gradient(135deg, #4338ca, #5b21b6);
  transform: translateY(-2px);
}

/* Responsive */
@media (max-width: 768px) {
  .product-card {
    flex-direction: column;
    text-align: center;
    padding: 1.5rem;
  }

  .image-wrapper {
    margin-bottom: 1.5rem;
  }

  .product-info {
    align-items: center;
  }

  .add-btn {
    align-self: center;
  }
}
</style>
