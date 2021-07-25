import { createApp } from 'vue';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import authStore, { authStoreKey } from '@/stores/auth';
import modalStore, { modalStoreKey } from './stores/modal';

createApp(App)
  .use(PrimeVue)
  .provide(authStoreKey, authStore())
  .provide(modalStoreKey, modalStore())
  .mount('#app');
