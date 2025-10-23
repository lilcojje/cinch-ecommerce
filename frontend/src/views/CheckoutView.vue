<template>
  <div class="checkout-container">
    <div class="header">
      <h1>🛒 Checkout</h1>
      <button class="back-btn" @click="goBack">← Back to Products</button>
    </div>

    <div v-if="cart.length === 0" class="empty-cart">
      <p>Your cart is empty.</p>
      <button class="back-btn" @click="goBack">Go Shopping</button>
    </div>

    <div v-else class="checkout-content">
      <table class="cart-table">
        <thead>
          <tr>
            <th>Product</th>
            <th>Unit Price</th>
            <th>Qty</th>
            <th>Subtotal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in cart" :key="item.id">
            <td>{{ item.name }}</td>
            <td>${{ Number(item.price).toFixed(2) }}</td>
            <td>
              <input
                type="number"
                v-model.number="item.quantity"
                min="1"
                @change="updateCart"
              />
            </td>
            <td>${{ (item.price * item.quantity).toFixed(2) }}</td>
            <td>
              <button class="remove-btn" @click="confirmRemove(item.id)">🗑</button>
            </td>
          </tr>
        </tbody>
      </table>

      <div class="summary-card">
        <div class="totals">
          <p><strong>Total Quantity:</strong> {{ totalQuantity }}</p>
          <p><strong>Total Amount:</strong> ${{ totalAmount.toFixed(2) }}</p>
        </div>

        <div class="customer-info">
          <label>
            Name
            <input v-model="customerName" type="text" placeholder="Enter your name" />
          </label>
          <label>
            Email
            <input v-model="customerEmail" type="email" placeholder="Enter your email" />
          </label>
        </div>

        <div class="buttons">
          <button class="back-btn" @click="goBack">← Add More Products</button>
          <button class="checkout-btn" @click="placeOrder">Place Order</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import api from "@/static/config.json";
import { ref, onMounted, computed } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import Swal from "sweetalert2";

const cart = ref([]);
const customerName = ref("");
const customerEmail = ref("");
const router = useRouter();

onMounted(() => {
  const items = localStorage.getItem("cart");
  cart.value = items ? JSON.parse(items) : [];
  updateCart();
});

function updateCart() {
  cart.value = cart.value.map((item) => ({
    ...item,
    quantity: Number(item.quantity) || 1,
    price: Number(item.price),
  }));
  localStorage.setItem("cart", JSON.stringify(cart.value));
}

function confirmRemove(id) {
  Swal.fire({
    title: "Remove this item?",
    text: "This product will be deleted from your cart.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc2626",
    cancelButtonColor: "#6b7280",
    confirmButtonText: "Yes, remove it",
  }).then((result) => {
    if (result.isConfirmed) {
      removeItem(id);
      Swal.fire("Removed!", "The product has been removed.", "success");
    }
  });
}

function removeItem(id) {
  cart.value = cart.value.filter((item) => item.id !== id);
  localStorage.setItem("cart", JSON.stringify(cart.value));
}

function goBack() {
  router.push("/");
}

const totalAmount = computed(() =>
  cart.value.reduce((sum, item) => sum + item.price * item.quantity, 0)
);

const totalQuantity = computed(() =>
  cart.value.reduce((sum, item) => sum + item.quantity, 0)
);

async function placeOrder() {
  if (!customerName.value || !customerEmail.value) {
    return Swal.fire("Missing Info", "Please enter your name and email.", "warning");
  }

  if (cart.value.length === 0) {
    return Swal.fire("Empty Cart", "Please add some products before checking out.", "info");
  }

  const items = cart.value.map((p) => ({
    product_id: p.id,
    quantity: p.quantity,
    unit_price: p.price,
    subtotal: p.price * p.quantity,
  }));

  const payload = {
    customer_name: customerName.value,
    customer_email: customerEmail.value,
    total_amount: totalAmount.value,
    items,
  };

  try {

    Swal.fire({
      title: "Placing your order...",
      text: "Please wait while we process your request.",
      allowOutsideClick: false,
      didOpen: () => {
        Swal.showLoading();
      },
    });

    await axios.post(api.API_URL_CHECKOUT + "/orders", payload);
    await axios.post(api.API_URL_EMAIL + "/email-user", {
      name: customerName.value,
      email: customerEmail.value,
      items: cart.value.map((p) => ({
        name: p.name,
        quantity: p.quantity,
        unit_price: p.price,
        subtotal: p.price * p.quantity,
      })),
      total_amount: totalAmount.value,
    });

    Swal.close();
    Swal.fire({
      icon: "success",
      title: "Order Placed!",
      text: "A confirmation email has been sent to you.",
      showConfirmButton: true,
      confirmButtonColor: "#4f46e5",
    });

    localStorage.removeItem("cart");
    cart.value = [];
    customerName.value = "";
    customerEmail.value = "";
  } catch (error) {
    console.error("Order error:", error.response?.data || error.message);

    if (error.response && error.response.status === 422) {
      const validationErrors = error.response.data.errors;
      const errorMessages = Object.values(validationErrors).flat().join("\n");
      Swal.fire("Validation Error", errorMessages, "error");
    } else {
      Swal.fire("Error", "Failed to place order. Please try again.", "error");
    }
  }
}
</script>



<style scoped>
.checkout-container {
  padding: 3rem 2rem;
  max-width: 900px;
  margin: 0 auto;
  background: #fafafa;
  border-radius: 16px;
  box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.header h1 {
  font-size: 2rem;
  font-weight: 700;
  color: #222;
}

.cart-table {
  width: 100%;
  border-collapse: collapse;
  background: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
}

.cart-table th {
  background: #f4f4f4;
  padding: 1rem;
  font-weight: 600;
  color: #333;
  text-align: center;
}

.cart-table td {
  padding: 0.75rem;
  text-align: center;
  border-bottom: 1px solid #eee;
  font-size: 0.95rem;
}

.cart-table input[type="number"] {
  width: 70px;
  padding: 0.4rem;
  text-align: center;
  border-radius: 6px;
  border: 1px solid #ccc;
  transition: border 0.2s ease;
}

.cart-table input[type="number"]:focus {
  outline: none;
  border-color: #6366f1;
}

button {
  cursor: pointer;
  border: none;
  border-radius: 8px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.checkout-btn {
  background: linear-gradient(135deg, #4f46e5, #6d28d9);
  color: #fff;
  padding: 0.75rem 1.5rem;
}

.checkout-btn:hover {
  background: linear-gradient(135deg, #4338ca, #5b21b6);
  transform: translateY(-2px);
}

.back-btn {
  background: #6c757d;
  color: #fff;
  padding: 0.6rem 1.2rem;
}

.back-btn:hover {
  background: #5a6268;
}

.remove-btn {
  background: transparent;
  color: #dc2626;
  font-size: 1.2rem;
}

.remove-btn:hover {
  transform: scale(1.2);
}

.summary-card {
  margin-top: 2rem;
  background: #fff;
  padding: 1.5rem;
  border-radius: 12px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
}

.totals {
  text-align: right;
  font-size: 1.05rem;
  color: #333;
  margin-bottom: 1.5rem;
}

.customer-info {
  display: grid;
  gap: 1rem;
  margin-bottom: 1.5rem;
}

.customer-info label {
  display: flex;
  flex-direction: column;
  font-weight: 500;
  color: #444;
}

.customer-info input {
  padding: 0.6rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  transition: border 0.2s ease;
}

.customer-info input:focus {
  border-color: #6366f1;
  outline: none;
}

.buttons {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
}

.empty-cart {
  text-align: center;
  padding: 3rem 0;
}

.empty-cart p {
  font-size: 1.2rem;
  color: #555;
  margin-bottom: 1rem;
}
</style>
