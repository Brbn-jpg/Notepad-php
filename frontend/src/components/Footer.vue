<template>
  <footer>
    <p>{{ $t("copyright") }}</p>
    <h3>{{ $t("authors") }}</h3>
    <ul class="authors">
      <li class="list-link">
        <a href="https://github.com/Brbn-jpg" class="link" target="_blank">
          {{ $t("author1") }}
        </a>
      </li>
      <li class="list-link">
        <a href="https://github.com/Geratis" class="link" target="_blank">
          {{ $t("author2") }}
        </a>
      </li>
    </ul>
  </footer>
</template>

<script>
export default {
  name: "FooterComponent",
};
</script>
