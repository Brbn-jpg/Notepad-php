<template>
  <nav class="nav nav-open" :key="navKey">
    <router-link to="/" class="main-page"
      ><h1>{{ $t("notebook") }}</h1></router-link
    >
    <ul class="login">
      <template v-if="loggedIn">
        <li class="list-link">
          <img
            src="..\assets\pl-flag.svg"
            alt="Polski"
            class="flag-icon"
            @click="changeLanguage('pl')"
          />
        </li>
        <li class="list-link">
          <img
            src="..\assets\us-flag.svg"
            alt="English"
            class="flag-icon"
            @click="changeLanguage('en')"
          />
        </li>
        <li class="list-link">
          <router-link to="/notes" class="link">{{ $t("notes") }}</router-link>
        </li>
        <li class="list-link">
          <router-link to="/history" class="link">{{
            $t("history")
          }}</router-link>
        </li>
        <li class="list-link">
          <router-link to="/" class="link" @click.prevent="logout">{{
            $t("logout")
          }}</router-link>
        </li>
      </template>
      <template v-else>
        <li class="list-link">
          <img
            src="..\assets\pl-flag.svg"
            alt="Polski"
            class="flag-icon"
            @click="changeLanguage('pl')"
          />
        </li>
        <li class="list-link">
          <img
            src="..\assets\us-flag.svg"
            alt="English"
            class="flag-icon"
            @click="changeLanguage('en')"
          />
        </li>
        <li class="list-link">
          <router-link to="/login" class="link">{{ $t("login") }}</router-link>
        </li>
        <li class="list-link">
          <router-link to="/register" class="link">{{
            $t("register")
          }}</router-link>
        </li>
      </template>
    </ul>
    <button class="btn-mobile-nav">
      <ion-icon class="icon-mobile-nav menu" name="menu-outline"></ion-icon>
      <ion-icon class="icon-mobile-nav close" name="close-outline"></ion-icon>
    </button>
  </nav>
</template>

<script>
export default {
  name: "NavBar",
  data() {
    return {
      loggedIn: false,
    };
  },
  watch: {
    $route() {
      this.checkLoginStatus();
    },
  },
  methods: {
    changeLanguage(language) {
      this.$i18n.locale = language;
      localStorage.setItem("userLanguage", language);
      window.location.reload();
      this.navKey++;
    },
    async checkLoginStatus() {
      try {
        const response = await fetch(
          "http://localhost/notatnik/backend/api/check_session.php",
          { method: "GET", credentials: "include" }
        );
        const data = await response.json();
        this.loggedIn = data.logged_in;
        this.navKey++;
      } catch (error) {
        console.error(error);
      }
    },
    async logout() {
      try {
        const response = await fetch(
          "http://localhost/notatnik/backend/api/logout.php",
          { method: "POST", credentials: "include" }
        );
        if (response.ok) {
          localStorage.removeItem("user");
          this.loggedIn = false;
          this.$router.push("/");
          window.location.reload();
        }
      } catch (error) {
        console.error("Błąd podczas wylogowywania:", error);
      }
    },
    mounted() {
      this.checkLoginStatus();
      window.addEventListener("login-status-changed", this.checkLoginStatus);
    },
    beforeUnmount() {
      window.removeEventListener("login-status-changed", this.checkLoginStatus);
    },
  },
};
</script>
