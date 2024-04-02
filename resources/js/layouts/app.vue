<template>
  <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <router-link class="text-white" :to="{ name: 'Home' }"
          >Home</router-link
        >
      </li>
      <li class="nav-item">
        <router-link class="text-white ml-4" :to="{ name: 'Login' }"
          >Login</router-link
        >
      </li>
      <li class="nav-item">
        <router-link class="text-white ml-4" :to="{ name: 'Register' }"
          >Register</router-link
        >
      </li>
      <li class="nav-item">
        <router-link class="text-white ml-4" :to="{ name: 'Dashboard' }"
          >Dashboard</router-link
        >
      </li>
    </ul>
  </nav>
  <router-view></router-view>
</template>

<style scoped>
    ul li{
        font-size: 28px;
    }
</style>
