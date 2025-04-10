<template>
  <section class="add-note-section">
    <h2 class="user-notes">{{ $t("addNewNote") }}</h2>
    <form @submit.prevent="addNote">
      <label class="note-label" for="title">{{ $t("noteTitle") }}</label>
      <input
        type="text"
        name="title"
        class="note-title-input"
        required
        :placeholder="$t('noteTitlePlaceholder')"
        v-model="note.title"
      />

      <label class="note-label" for="content">{{ $t("noteContent") }}</label>
      <textarea
        name="content"
        class="note-content"
        required
        :placeholder="$t('noteContentPlaceholder')"
        v-model="note.content"
      ></textarea>

      <button type="submit" class="submit-btn">{{ $t("addNote") }}</button>
    </form>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
    <p v-if="successMessage" class="success">{{ successMessage }}</p>
  </section>
</template>

<script>
export default {
  name: "AddNote",
  data() {
    return {
      note: {
        title: "",
        content: "",
      },
      errorMessage: "",
      successMessage: "",
    };
  },
  methods: {
    async addNote() {
      try {
        const response = await fetch(
          "http://localhost/notatnik/backend/api/save_note.php",
          {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(this.note),
            credentials: "include",
          }
        );

        const textData = await response.text();
        console.log("Odpowiedź serwera:", textData);

        const data = JSON.parse(textData);
        if (data.success) {
          this.successMessage = data.message;
          this.errorMessage = "";
          this.note.title = "";
          this.note.content = "";
        } else {
          this.errorMessage = data.error;
          this.successMessage = "";
        }
      } catch (error) {
        console.error("Błąd podczas dodawania notatki:", error);
        this.errorMessage = "Wystąpił błąd podczas dodawania notatki.";
        this.successMessage = "";
      }
    },
  },
};
</script>
