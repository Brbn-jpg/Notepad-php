<template>
  <article>
    <h2>{{ $t("login") }}</h2>
    <form @submit.prevent="login">
      <label for="text">{{ $t("login") }}</label>
      <input
        type="text"
        name="login"
        class="username"
        required
        :placeholder="$t('loginPlaceholder')"
        v-model="loginData.login"
      />
      <p v-if="errorMessage.includes('login')" class="error">
        {{ $t("loginError") }}
      </p>

      <label for="password">{{ $t("password") }}</label>
      <input
        type="password"
        name="password"
        class="password"
        required
        :placeholder="$t('passwordPlaceholder')"
        v-model="loginData.password"
      />
      <p v-if="errorMessage.includes('hasło')" class="error">
        {{ $t("loginError") }}
      </p>

      <p v-if="errorMessage.includes('wszystkie pola')" class="error">
        {{ $t("missingFields") }}
      </p>

      <button type="submit" class="submit-btn">{{ $t("login") }}</button>
    </form>
  </article>
</template>

<script>
export default {
  name: "LoginPage",
  data() {
    return {
      loginData: {
        login: "",
        password: "",
      },
      errorMessage: "",
    };
  },
  methods: {
    async login() {
      try {
        const response = await fetch(
          "http://localhost/notatnik/backend/api/login.php",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.loginData),
            credentials: "include",
          }
        );

        const data = await response.json();

        if (data.success) {
          localStorage.setItem("user", JSON.stringify(this.loginData));
          window.dispatchEvent(new Event("login-status-changed"));
          this.$router.push("/notes");
        }

        const textData = await response.text().then((text) => {
          try {
            return JSON.parse(`${text}`);
          } catch (error) {
            console.error(error);
            return text;
          }
        });

        console.log("Serwer zwrócił:", textData);

        if (textData.success) {
          localStorage.setItem("user", JSON.stringify(this.loginData));
          this.$router.push("/notes");
        } else {
          this.errorMessage = textData.error;
        }
      } catch (error) {
        console.error(error);
        this.errorMessage = "Wystąpił błąd podczas logowania.";
      }
    },
  },
};
</script>
