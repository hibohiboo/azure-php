<template>
  <div>テスト</div>
  <Button
    v-if="state.isLoggedin"
    label="登録"
    icon="pi pi-external-link"
    @click="openModal"
  />
  <RoomInputDialog />

  <CardSample />
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import CardSample from '@/components/organisms/CardSample.vue';
import RoomInputDialog from '@/components/organisms/RoomInputDialog.vue';
import { useAuthStore } from '@/stores/auth';
import { useModalStore } from '@/stores/modal';
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
    const { openModal } = useModalStore();
    signin();
    return { count, openModal, state };
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
