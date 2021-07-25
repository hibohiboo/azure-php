<template>
  <Main msg="Hello Vue 3 + TypeScript + Vite" />
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Main from '@/components/pages/Main.vue';

export default defineComponent({
  name: 'App',
  components: {
    Main,
  },
});
</script>

<style></style>
