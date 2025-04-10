<template>
  <section class="edit-note-section">
    <h2 class="user-notes">{{ $t("editNote") }}</h2>
    <form @submit.prevent="updateNote">
      <label for="title" class="note-label">{{ $t("noteTitle") }}</label>
      <input
        type="text"
        id="title"
        v-model="note.title"
        class="note-title-input"
        required
        :placeholder="$t('noteTitlePlaceholder')"
      />

      <label for="content" class="note-label">{{ $t("noteContent") }}</label>
      <textarea
        id="content"
        v-model="note.content"
        class="note-content"
        required
        :placeholder="$t('noteContentPlaceholder')"
      ></textarea>

      <button type="submit" class="submit-btn">{{ $t("saveChanges") }}</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    <p v-if="successMessage" class="success">{{ $t("success") }}</p>
  </section>
</template>

<script>
export default {
  name: "EditNote",
  data() {
    return {
      note: {
        id: null,
        title: "",
        content: "",
      },
      errorMessage: "",
      successMessage: "",
    };
  },
  async mounted() {
    const noteId = this.$route.params.id;
    if (!noteId) {
      this.errorMessage = "Nie podano ID notatki";
      return;
    }

    try {
      const response = await fetch(
        `http://localhost/notatnik/backend/api/get_note.php?id=${noteId}`,
        { credentials: "include" }
      );

      if (!response.ok) {
        const errorText = await response.text();
        console.error("Odpowiedź serwera (error):", errorText);
        throw new Error("Nie udało się pobrać notatki");
      }

      const responseText = await response.text();
      console.log("Odpowiedź serwera (get_note):", responseText);

      try {
        const data = JSON.parse(responseText);
        this.note = {
          id: data.id,
          title: data.title,
          content: data.content,
        };
      } catch (error) {
        console.error("Błąd parsowania JSON:", error);
        throw new Error("Nieprawidłowy format danych");
      }
    } catch (error) {
      this.errorMessage = error.message;
    }
  },
  methods: {
    async updateNote() {
      try {
        console.log("Wysyłam dane notatki:", this.note);

        const response = await fetch(
          "http://localhost/notatnik/backend/api/update_note.php",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.note),
            credentials: "include",
          }
        );

        const responseText = await response.text();
        console.log("Odpowiedź serwera (update_note):", responseText);

        try {
          const data = JSON.parse(responseText);
          if (data.success) {
            this.successMessage =
              data.message || "Notatka została zaktualizowana";
            this.errorMessage = "";
          } else {
            this.errorMessage =
              data.error || "Wystąpił błąd podczas aktualizacji notatki";
            this.successMessage = "";
          }
        } catch (error) {
          console.error("Błąd parsowania JSON:", error);
          this.errorMessage = "Nieprawidłowy format odpowiedzi z serwera";
        }
      } catch (error) {
        console.error("Błąd podczas aktualizacji notatki:", error);
        this.errorMessage = "Wystąpił błąd podczas aktualizacji notatki.";
      }
    },
  },
};
</script>
