<template>
  <div>
    <nav>
      <router-link to="/">Home</router-link> |
      <router-link to="/checkout">Checkout</router-link>
    </nav>
    <router-view />
  </div>
</template>

<style>
nav { background: #222; color: white; padding: 1rem; }
nav a { color: white; margin: 0 10px; text-decoration: none; }
</style>
