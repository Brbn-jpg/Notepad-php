<template>
  <section class="deleted-note-view">
    <h2 class="user-note">{{ note.title }}</h2>
    <p class="note-content">{{ note.content }}</p>
    <div class="note-meta">
      <p>
        <strong>{{ $t("deletedOn") }}:</strong>
        {{ formatDate(note.changed_at) }}
      </p>
    </div>
    <router-link to="/history" class="link">
      {{ $t("backToHistory") }}
    </router-link>
    <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
  </section>
</template>

<script>
export default {
  name: "NotesHistoryDetail",
  data() {
    return {
      note: {
        title: "",
        content: "",
        changed_at: "",
      },
      errorMessage: "",
    };
  },
  async mounted() {
    const noteId = this.$route.params.id;

    try {
      const response = await fetch(
        `http://localhost/notatnik/backend/api/view_deleted_note.php?id=${noteId}`,
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
      this.errorMessage = "Nie udało się pobrać usuniętej notatki.";
    }
  },
  methods: {
    formatDate(dateStr) {
      return new Date(dateStr).toLocaleString("pl-PL");
    },
  },
};
</script>
