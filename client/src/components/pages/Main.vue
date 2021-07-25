<template>
  <div>テスト</div>
  <Button
    v-if="state.isLoggedin"
    label="登録"
    icon="pi pi-external-link"
    @click="openCreateModal"
  />
  <RoomInputDialog />

  <Carousel
    :value="rooms.list"
    :num-visible="3"
    :num-scroll="3"
    :responsive-options="responsiveOptions"
  >
    <template #header>
      <h5>かっこいいルーム</h5>
    </template>
    <template #item="slotProps">
      <div class="product-item">
        <div class="product-item-content">
          <div class="p-mb-3">
            <img
              :src="`http://localhost:8080/uploads/${slotProps.data.uid}/${slotProps.data.roomId}.png`"
              :alt="slotProps.data.name"
              class="product-image"
            />
          </div>
          <div>
            <h4 class="p-mb-1">{{ slotProps.data.title }}</h4>

            <span :class="'product-badge status-'">{{
              slotProps.data.tags
            }}</span>
            <div class="car-buttons p-mt-5">
              <Button
                v-if="state.uid === slotProps.data.uid"
                icon="pi pi-cog"
                class="p-button-help p-button-rounded"
                label="編集"
                @click="() => openEditModal(slotProps.data)"
              />
            </div>
          </div>
        </div>
      </div>
    </template>
  </Carousel>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import RoomInputDialog from '@/components/organisms/RoomInputDialog.vue';
import { useAuthStore } from '@/stores/auth';
import { useRoomStore } from '@/stores/room';
import Button from 'primevue/button';
import Carousel from 'primevue/carousel';
import roomsStore from '@/stores/rooms';

export default defineComponent({
  components: { RoomInputDialog, Carousel, Button },
  name: 'Main',
  props: {
    msg: {
      type: String,
      required: true,
    },
  },
  setup: () => {
    const count = ref(0);

    const { signin, state } = useAuthStore();
    const { openCreateModal, openEditModal } = useRoomStore();
    signin();
    const { rooms } = roomsStore();
    const responsiveOptions = [
      {
        breakpoint: '1024px',
        numVisible: 3,
        numScroll: 3,
      },
      {
        breakpoint: '600px',
        numVisible: 2,
        numScroll: 2,
      },
      {
        breakpoint: '480px',
        numVisible: 1,
        numScroll: 1,
      },
    ];
    return {
      count,
      openCreateModal,
      openEditModal,
      state,
      responsiveOptions,
      rooms,
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
.product-item {
  .product-item-content {
    border: 1px solid var(--surface-d);
    border-radius: 3px;
    margin: 0.3rem;
    text-align: center;
    padding: 2rem 0;
  }

  .product-image {
    width: 50%;
    box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  }
}
</style>
