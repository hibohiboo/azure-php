import { inject, InjectionKey, ref } from 'vue';

const modalStore = () => {
  const displayModal = ref(false);
  const openModal = () => {
    displayModal.value = true;
  };
  const closeModal = () => {
    displayModal.value = false;
  };

  return {
    displayModal,
    openModal,
    closeModal,
  };
};

export default modalStore;

type AuthStore = ReturnType<typeof modalStore>;

export const modalStoreKey: InjectionKey<AuthStore> = Symbol('modalStore');

export const useModalStore = () => {
  const store = inject(modalStoreKey);
  if (!store) {
    throw new Error(`${modalStoreKey} is not provided`);
  }
  return store;
};
