<template>
  <div>
    <nav class="navbar">
      <div class="nav-links">
        <router-link to="/">Home</router-link>
        <router-link to="/checkout">Checkout</router-link>
      </div>
    </nav>
    <router-view />
  </div>
</template>

<style scoped>
.navbar {
  background: #222;
  padding: 1rem 0;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.nav-links {
  display: flex;
  gap: 2rem;
}

.nav-links a {
  color: white;
  text-decoration: none;
  font-weight: 500;
  letter-spacing: 0.5px;
  position: relative;
  transition: color 0.3s ease;
}

.nav-links a::after {
  content: '';
  position: absolute;
  left: 0;
  bottom: -4px;
  width: 0%;
  height: 2px;
  background: #6366f1; /* elegant violet accent */
  transition: width 0.3s ease;
}

.nav-links a:hover {
  color: #a5b4fc; /* lighter accent */
}

.nav-links a:hover::after {
  width: 100%;
}
</style>
