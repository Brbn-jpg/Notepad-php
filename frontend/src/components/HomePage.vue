<template>
  <article>
    <h2>{{ $t("welcome") }}</h2>
    <p v-if="loggedIn">{{ $t("loggedIn", { userName }) }}</p>
    <p v-else>
      {{ $t("notLoggedIn") }}
      <router-link to="/login">{{ $t("loginLink") }}</router-link>
    </p>
    <p>{{ $t("notebookDescription") }}</p>
    <p v-if="!loggedIn">{{ $t("loginRequired") }}</p>
    <img src="../assets/illustration.svg" alt="Notebook illustration" />
  </article>
</template>

<script>
export default {
  name: "HomePage",
  data() {
    return {
      loggedIn: false,
      userName: "",
    };
  },
  mounted() {
    this.checkLoginStatus();
  },
  methods: {
    checkLoginStatus() {
      const user = localStorage.getItem("user");
      if (user) {
        this.loggedIn = true;
        const userData = JSON.parse(user);
        this.userName = userData.login;
      } else {
        this.loggedIn = false;
      }
    },
  },
};
</script>
