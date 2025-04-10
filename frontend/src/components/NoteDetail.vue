<template>
  <section class="note-view">
    <h2>{{ note.title }}</h2>
    <p class="note-content">{{ note.content }}</p>
    <div class="note-meta">
      <p>
        <strong>{{ $t("noteCreated") }}:</strong>
        {{ formatDate(note.created_at) }}
      </p>
    </div>
    <div class="actions">
      <router-link :to="`/edit/${note.id}`" class="edit-btn">
        {{ $t("edit") }}
      </router-link>
      <button @click="confirmDelete(note.id)" class="delete-btn">
        {{ $t("delete") }}
      </button>
    </div>
    <router-link to="/notes" class="link">
      {{ $t("backToList") }}
    </router-link>

    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </section>
</template>

<script>
export default {
  name: "NoteDetail",
  data() {
    return {
      note: {
        title: "",
        content: "",
        created_at: "",
      },
      errorMessage: "",
    };
  },
  async mounted() {
    const noteId = this.$route.params.id;

    try {
      const response = await fetch(
        `http://localhost/notatnik/backend/api/get_note.php?id=${noteId}`,
        {
          credentials: "include",
        }
      );

      const responseText = await response.text();
      console.log("Odpowiedź z serwera:", responseText);

      const data = JSON.parse(responseText);

      if (data.error) {
        this.errorMessage = data.error;
      } else {
        this.note = data;
      }
    } catch (err) {
      console.error(err);
      this.errorMessage = "Nie udało się pobrać notatki.";
    }
  },
  methods: {
    formatDate(dateStr) {
      return new Date(dateStr).toLocaleString("pl-PL");
    },

    confirmDelete(noteId) {
      const confirmDelete = confirm("Czy na pewno chcesz usunąć tę notatkę?");
      if (confirmDelete) {
        this.deleteNote(noteId);
      }
    },

    async deleteNote() {
      const noteId = this.note.id;
      try {
        const response = await fetch(
          `http://localhost/notatnik/backend/api/delete_note.php`,
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({ note_id: noteId }),
            credentials: "include",
          }
        );

        const result = await response.json();
        if (result.success) {
          this.$router.push("/notes");
        } else {
          this.errorMessage = "Błąd podczas usuwania notatki";
        }
      } catch (err) {
        console.error(err);
        this.errorMessage = "Nie udało się usunąć notatki.";
      }
    },
  },
};
</script>
