import { reactive } from 'vue';
import { useAuthStore } from './auth';
import { create } from '@/domain/room/repository';
const roomStore = () => {
  const { state } = useAuthStore();
  const room = reactive({ title: '' });
  const createRoom = async () => {
    create(room, state.uid);
  };

  return {
    room,
    state,
    createRoom,
  };
};

export default roomStore;
