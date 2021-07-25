<template>
  <Dialog
    :header="title"
    v-model:visible="room.displayModal"
    :style="{ width: '50vw' }"
  >
    <div>
      <h5>シナリオタイトル</h5>
      <InputText type="text" v-model="room.title" />
      <span :style="{ marginLeft: '.5em' }">{{ room.title }}</span>
      <h5>ルーム画像</h5>
      <FileUpload
        mode="basic"
        name="demo"
        :url="`http://localhost:8080/roomUpload/${state.uid}/${room.roomId}`"
        :auto="true"
      />
    </div>
    <template #footer>
      <Button
        label="No"
        icon="pi pi-times"
        @click="closeModal"
        class="p-button-text"
      />
      <Button label="登録" icon="pi pi-check" @click="createRoom" autofocus />
    </template>
  </Dialog>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Dialog from 'primevue/dialog';
import Button from 'primevue/button';
import InputText from 'primevue/inputtext';
import { useRoomStore } from '@/stores/room';
import FileUpload from 'primevue/fileupload';

export default defineComponent({
  components: { Dialog, Button, InputText, FileUpload },
  name: 'RoomInputDialog',

  setup: () => {
    const { room, state, createRoom, closeModal } = useRoomStore();
    const title = room.isUpdate ? '編集' : '登録';

    return {
      closeModal,
      title,
      room,
      state,
      createRoom,
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
