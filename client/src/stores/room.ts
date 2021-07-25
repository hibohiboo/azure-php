import { inject, InjectionKey, reactive } from 'vue';
import { useAuthStore } from './auth';
import { create, getRoomId } from '@/domain/room/repository';

const initRoomInputDialog = {
  title: '',
  roomId: '',
  displayModal: false,
  isUpdate: false,
};

const roomStore = () => {
  const room = reactive(initRoomInputDialog);

  const openCreateModal = async () => {
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
    await create(store.room.roomId, store.room, state.uid);
    store.closeModal();
  };

  return { ...store, createRoom, state };
};
