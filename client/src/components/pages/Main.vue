<template>
  <div>テスト</div>
  <Button
    v-if="state.isLoggedin"
    label="登録"
    icon="pi pi-external-link"
    @click="openCreateModal"
  />
  <RoomInputDialog />

  <CardSample />
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import CardSample from '@/components/organisms/CardSample.vue';
import RoomInputDialog from '@/components/organisms/RoomInputDialog.vue';
import { useAuthStore } from '@/stores/auth';
import { useRoomStore } from '@/stores/room';
import Button from 'primevue/button';

export default defineComponent({
  components: { RoomInputDialog, CardSample, Button },
  name: 'Main',
  props: {
    msg: {
      type: String,
      required: true,
    },
  },
  setup: () => {
    const count = ref(0);

    const { signin, state } = useAuthStore();
    const { openCreateModal } = useRoomStore();
    signin();
    return { count, openCreateModal, state };
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
