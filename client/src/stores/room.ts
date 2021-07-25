import { inject, InjectionKey, reactive } from 'vue';
import { useAuthStore } from './auth';
import { create, getRoomId } from '@/domain/room/repository';

const initRoomInputDialog = {
  title: '',
  roomId: '',
  tags: '',
  scenarioTitle: '',
  scenarioUrl: '',
  materials: [
    { name: '', url: '' },
    { name: '', url: '' },
    { name: '', url: '' },
    { name: '', url: '' },
    { name: '', url: '' },
  ],
  displayModal: false,
  isUpdate: false,
};

const roomStore = () => {
  const room = reactive(initRoomInputDialog);

  const openCreateModal = async () => {
    room.title = '';
    room.roomId = '';
    room.scenarioTitle = '';
    room.scenarioUrl = '';
    room.displayModal = true;
    room.isUpdate = false;
    room.roomId = await getRoomId();
  };
  const closeModal = () => {
    room.displayModal = false;
  };

  return {
    room,
    openCreateModal,
    closeModal,
  };
};

export default roomStore;
type RoomStore = ReturnType<typeof roomStore>;

export const roomStoreKey: InjectionKey<RoomStore> = Symbol('roomStore');

export const useRoomStore = () => {
  const store = inject(roomStoreKey);
  if (!store) {
    throw new Error(`${roomStoreKey} is not provided`);
  }
  const { state } = useAuthStore();
  const createRoom = async () => {
    const { roomId, title, tags, scenarioTitle, scenarioUrl } = store.room;
    if (!title) {
      alert('タイトルは必須です');
      return;
    }
    await create(
      roomId,
      { roomId, title, tags, scenarioTitle, scenarioUrl },
      state.uid,
    );
    store.closeModal();
  };

  return { ...store, createRoom, state };
};
