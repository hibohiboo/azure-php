<template>
  <Dialog
    :header="title"
    v-model:visible="room.displayModal"
    :style="{ width: '50vw' }"
  >
    <div>
      <h5>タイトル※必須</h5>
      <InputText type="text" v-model="room.title" />

      <h5>ルーム画像</h5>
      <FileUpload
        name="demo"
        :url="`http://localhost:8080/roomUpload/${state.uid}/${room.roomId}`"
        :auto="true"
        accept="image/*"
        :max-file-size="1000000"
        choose-label="画像を選択してください"
        :show-upload-button="false"
        :show-cancel-button="false"
      >
        <template #empty>
          <p>Drag and drop files to here to upload.</p>
        </template>
      </FileUpload>
      <h5>タグ</h5>
      <div>スペース区切りで複数入力</div>
      <InputText type="text" v-model="room.tags" />
      <h5>シナリオ名</h5>
      <InputText type="text" v-model="room.scenarioTitle" />
      <h5>シナリオURL</h5>
      <InputText type="text" v-model="room.scenarioUrl" />
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
