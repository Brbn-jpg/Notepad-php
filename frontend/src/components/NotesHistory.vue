<template>
  <section class="notes-section">
    <h2 class="user-notes">{{ $t("deletedNotesHistory") }}</h2>
    <div v-if="deletedNotes.length > 0">
      <div v-for="note in deletedNotes" :key="note.id" class="note">
        <router-link :to="`/history/${note.id}`" class="note-link">
          <h2 class="note-title">{{ note.title }}</h2>
        </router-link>
        <div class="note-meta">
          <p>
            <strong>{{ $t("deletedOn") }}:</strong>
            {{ formatDate(note.changed_at) }}
          </p>
        </div>
      </div>
    </div>
    <p v-else>{{ $t("noDeletedNotes") }}</p>
  </section>
</template>

<script>
export default {
  name: "NotesHistory",
  data() {
    return {
      deletedNotes: [],
    };
  },
  async mounted() {
    try {
      const res = await fetch(
        "http://localhost/notatnik/backend/api/get_deleted_notes.php",
        {
          credentials: "include",
        }
      );
      const data = await res.json();
      if (Array.isArray(data)) {
        this.deletedNotes = data;
      } else {
        console.error("Błąd w danych:", data);
      }
    } catch (error) {
      console.error("Błąd podczas pobierania notatek:", error);
    }
  },
  methods: {
    formatDate(dateStr) {
      const date = new Date(dateStr);
      return date.toLocaleString("pl-PL");
    },
  },
};
</script>

<style scoped>
.note {
  margin-bottom: 1rem;
}
</style>
