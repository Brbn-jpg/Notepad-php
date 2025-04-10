import { createRouter, createWebHistory } from "vue-router";
import HomePage from "../components/HomePage.vue";
import LoginPage from "../components/LoginPage.vue";
import RegisterPage from "../components/RegisterPage.vue";
import NotesList from "../components/NotesList.vue";
import AddNote from "@/components/AddNote.vue";
import EditNote from "@/components/EditNote.vue";
import NotesHistory from "@/components/NotesHistory.vue";
import NotesHistoryDetail from "@/components/NotesHistoryDetail.vue";
import NoteDetail from "@/components/NoteDetail.vue";

const routes = [
  { path: "/", component: HomePage },
  { path: "/login", component: LoginPage },
  { path: "/register", component: RegisterPage },
  { path: "/notes", component: NotesList },
  { path: "/notes/:id", component: NoteDetail },
  { path: "/history", component: NotesHistory },
  { path: "/history/:id", component: NotesHistoryDetail },
  { path: "/add", component: AddNote },
  { path: "/edit/:id", component: EditNote },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
