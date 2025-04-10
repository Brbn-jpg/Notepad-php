<template>
  <Nav :isLoggedIn="isLoggedIn" @logout="logout" />
  <router-view />
  <Footer />
</template>

<script>
import Nav from "./components/Nav.vue";
import Footer from "./components/Footer.vue";

export default {
  name: "App",
  components: {
    Nav,
    Footer,
  },
  mounted() {
    this.isLoggedIn = localStorage.getItem("user") !== null;
  },
  methods: {
    logout() {
      localStorage.removeItem("user");
      this.isLoggedIn = false;
      this.$router.push("/login");
    },
  },
};
</script>
