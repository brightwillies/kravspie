<template>
  <div>
    <router-view :key="$route.fullPath"></router-view>
  </div>
</template>

<script>
import axios from "axios";
import store from "./../store/index";
export default {
  mounted() {
    if (store.getters.isLoggedIn && this.$route.path == "/admin-login") {
      this.$router.push("/admin-dashboard"); // redirect to home, for example
    }
  },
};
</script>
