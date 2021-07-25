import { createApp } from 'vue';
import App from './App.vue';
import PrimeVue from 'primevue/config';
import authStore, { authStoreKey } from '@/stores/auth';

createApp(App).use(PrimeVue).provide(authStoreKey, authStore()).mount('#app');
