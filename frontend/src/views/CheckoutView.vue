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


