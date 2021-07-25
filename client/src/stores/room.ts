import { reactive } from 'vue';
import { useAuthStore } from './auth';
const roomStore = () => {
  const { state } = useAuthStore();
  const room = reactive({ title: '' });

  return {
    room,
    state,
  };
};

export default roomStore;
