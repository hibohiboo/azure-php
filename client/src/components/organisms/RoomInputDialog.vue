<template>
  <Dialog
    :header="title"
    v-model:visible="displayModal"
    :style="{ width: '50vw' }"
  >
    <div>
      <h5>シナリオタイトル</h5>
      <InputText type="text" v-model="room.title" />
      <span :style="{ marginLeft: '.5em' }">{{ room.title }}</span>
    </div>
    <template #footer>
      <Button
        label="No"
        icon="pi pi-times"
        @click="closeModal"
        class="p-button-text"
      />
      <Button label="登録" icon="pi pi-check" @click="create" autofocus />
    </template>
  </Dialog>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import roomStore from '@/stores/room';
import { useModalStore } from '@/stores/modal';

export default defineComponent({
  components: { Dialog, Button, InputText },
  name: 'RoomInputDialog',
  props: {
    roomId: {
      type: String,
      required: false,
      default: '',
    },
  },
  setup: (props) => {
    const title = props.roomId === '' ? '登録' : '編集';
    const count = ref(0);
    const { displayModal, closeModal } = useModalStore();
    const { room, state, createRoom } = roomStore();
    const create = async () => {
      await createRoom();
      closeModal();
    };

    return {
      count,
      displayModal,
      closeModal,
      title,
      room,
      state,
      create,
    };
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
