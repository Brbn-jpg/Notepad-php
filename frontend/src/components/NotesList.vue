<template>
  <section class="notes-section">
    <h2 class="user-notes">{{ $t("userNotes") }}</h2>
    <div v-for="note in notes" v-bind:key="note.id" class="note">
      <router-link :to="`/notes/${note.id}`" class="note-link">
        <h3 class="note-title">{{ note.title }}</h3>
      </router-link>
      <div class="edit-delete">
        <div class="container">
          <button @click="editNote(note.id)" class="edit">
            {{ $t("edit") }}
          </button>
          <button @click="deleteNote(note.id)" class="delete">
            {{ $t("delete") }}
          </button>
        </div>
      </div>
    </div>
    <p v-if="notes.length == 0">{{ $t("noNotes") }}</p>
    <div class="add-note">
      <router-link to="/add" class="add">&#10010;</router-link>
    </div>
  </section>
</template>

<script>
export default {
  name: "NotesList",
  data() {
    return {
      notes: [],
    };
  },
  async mounted() {
    try {
      const response = await fetch(
        "http://localhost/notatnik/backend/api/get_notes.php",
        {
          credentials: "include",
        }
      );
      if (!response.ok) {
        console.error("Błąd serwera:", response.status, response.statusText);
        this.notes = [];
        return;
      }
      const textData = await response.text();
      console.log("Odpowiedź serwera:", textData);
      try {
        const data = JSON.parse(textData);
        console.log("Dane z serwera:", data);

        if (data.logged_in !== undefined) {
          console.log(
            "Otrzymano informacje o logowaniu zamiast notatek:",
            data
          );
          this.notes = [];
        } else if (Array.isArray(data)) {
          this.notes = data;
          console.log("Notatki przypisane do this.notes:", this.notes);
        } else if (data.notes && Array.isArray(data.notes)) {
          this.notes = data.notes;
          console.log("Notatki przypisane do this.notes:", this.notes);
        } else {
          console.error("Nieoczekiwana struktura danych:", data);
          this.notes = [];
        }
      } catch (error) {
        console.error("Błąd parsowania JSON:", error);
      }
    } catch (error) {
      console.error("Błąd podczas komunikacji z serwerem:", error);
    }
  },
  methods: {
    editNote(id) {
      this.$router.push(`/edit/${id}`);
    },
    async deleteNote(id) {
      if (confirm("Czy na pewno chcesz usunąć tę notatkę?")) {
        await fetch("http://localhost/notatnik/backend/api/delete_note.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify({ note_id: id }),
          credentials: "include",
        });
        this.notes = this.notes.filter((note) => note.id !== id);
      }
    },
  },
};
</script>
