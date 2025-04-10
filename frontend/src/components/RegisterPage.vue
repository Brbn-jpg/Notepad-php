<template>
  <article>
    <h2>{{ $t("register") }}</h2>
    <form @submit.prevent="handleRegister">
      <label for="login">{{ $t("login") }}</label>
      <input
        type="text"
        name="login"
        class="username"
        required
        :placeholder="$t('loginPlaceholder')"
        v-model="registerData.login"
      />
      <p v-if="loginError" class="error">
        {{ $t("usernameExists") }}
      </p>

      <label for="password">{{ $t("password") }}</label>
      <input
        type="password"
        name="password"
        class="password"
        required
        :placeholder="$t('passwordPlaceholder')"
        v-model="registerData.password"
      />

      <label for="repeatedPassword">{{ $t("repeatPassword") }}</label>
      <input
        type="password"
        name="repeatedPassword"
        class="password"
        required
        :placeholder="$t('repeatPasswordPlaceholder')"
        v-model="registerData.repeatedPassword"
      />
      <p v-if="passwordMismatchError" class="error">
        {{ $t("passwordMismatch") }}
      </p>

      <p v-if="generalError" class="error">{{ $t("fieldsRequired") }}</p>
      <p v-if="registrationSuccess" class="success">
        {{ $t("registrationSuccess") }}
      </p>

      <button type="submit" class="submit-btn">{{ $t("register") }}</button>
    </form>
  </article>
</template>

<script>
export default {
  name: "RegisterPage",
  data() {
    return {
      registerData: {
        login: "",
        password: "",
        repeatedPassword: "",
      },
      loginError: false,
      passwordMismatchError: false,
      generalError: false,
      registrationSuccess: false,
    };
  },
  methods: {
    async handleRegister() {
      this.loginError = false;
      this.passwordMismatchError = false;
      this.generalError = false;
      this.registrationSuccess = false;

      if (
        !this.registerData.login ||
        !this.registerData.password ||
        !this.registerData.repeatedPassword
      ) {
        this.generalError = true;
        return;
      }

      if (this.registerData.password !== this.registerData.repeatedPassword) {
        this.passwordMismatchError = true;
        return;
      }

      try {
        const response = await fetch(
          "http://localhost/notatnik/backend/api/register.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              login: this.registerData.login,
              password: this.registerData.password,
              repeatedPassword: this.registerData.repeatedPassword,
            }),
          }
        );

        const data = await response.json();

        if (response.ok) {
          this.registrationSuccess = true;
        } else {
          if (data.error === "Użytkownik o takim loginie już istnieje.") {
            this.loginError = true;
          } else {
            this.generalError = true;
          }
        }
      } catch (error) {
        this.generalError = true;
        console.error("Wystąpił błąd podczas rejestracji:", error);
      }
    },
  },
};
</script>
