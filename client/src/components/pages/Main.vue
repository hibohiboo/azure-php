<template>
  <div>テスト</div>
  <RoomInputDialog />

  <CardSample />
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import CardSample from '@/components/organisms/CardSample.vue';
import RoomInputDialog from '@/components/organisms/RoomInputDialog.vue';

export default defineComponent({
  components: { RoomInputDialog, CardSample },
  name: 'HelloWorld',
  props: {
    msg: {
      type: String,
      required: true,
    },
  },
  setup: () => {
    const count = ref(0);
    return { count };
  },
});
</script>

<style lang="scss" scoped>
.custom-skeleton {
  border: 1px solid var(--surface-d);
  border-radius: 4px;

  ul {
    list-style: none;
  }
}
</style>
