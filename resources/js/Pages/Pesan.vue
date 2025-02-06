<template>
  <div class="min-h-screen bg-gray-50 p-4 sm:p-6 md:p-8">
    <!-- Main container with responsive width -->
    <div class="mx-auto flex min-h-[calc(100vh-4rem)] flex-col rounded-xl bg-red-600 shadow-xl sm:max-w-xl md:max-w-2xl lg:max-w-4xl">
      <!-- Title with responsive text size -->
      <h1 class="py-4 text-center text-2xl font-extrabold tracking-wide text-red-200 sm:py-6 sm:text-3xl">
        Notifikasi
      </h1>

      <!-- Messages container with responsive padding -->
      <div class="flex-grow space-y-4 bg-opacity-50 p-4 sm:p-6">
        <!-- Loop through messages -->
        <div
          v-for="pesanItem in pesan"
          :key="pesanItem.id"
          :class="[
            'relative w-full rounded-xl border p-4 shadow-xl transition-all duration-300 sm:p-6',
            pesanItem.asal === 'admin'
              ? 'bg-red-100 border-red-300 hover:shadow-2xl hover:bg-red-200'
              : 'bg-red-100 border-red-300 hover:shadow-2xl hover:bg-red-200',
          ]"
        >
          <!-- Message header with responsive text -->
          <p class="text-base font-semibold text-red-800 sm:text-lg">
            {{ pesanItem.asal === 'admin' ? 'Pesan Masuk' : 'Pesan Keluar' }}
          </p>

          <!-- Message content with responsive text -->
          <p class="mt-1 text-sm text-gray-800 sm:text-base">{{ pesanItem.pesan }}</p>
          
          <!-- Date with responsive text -->
          <p class="mt-2 text-xs text-gray-500 sm:text-sm">
            {{ formatDate(pesanItem.created_at) }}
          </p>

          <!-- Delete Button - positioned responsively -->
          <button
            @click="showConfirmModal(pesanItem.id)"
            class="absolute right-2 top-2 rounded-full p-2 text-red transition-all hover:scale-110 hover:bg-red-600 focus:outline-none sm:right-3 sm:top-3"
          >
            ❌
          </button>
        </div>

        <!-- Empty state message -->
        <div
          v-if="pesan.length === 0"
          class="w-full rounded-xl border border-gray-200 bg-white p-4 text-center shadow-lg sm:p-6"
        >
          <p class="text-gray-600">Tidak ada pesan</p>
        </div>
      </div>
    </div>

    <!-- Confirm Modal -->
    <ConfirmModal
      v-if="modalVisible"
      title="Konfirmasi Hapus"
      :message="'Apakah Anda yakin ingin menghapus pesan ini?'"
      @close="modalVisible = false"
      @confirm="hapusPesan"
    />
  </div>
</template>

<script setup>
import AppLayout from "../layouts/AppLayout.vue";
import ConfirmModal from "../components/ConfirmModal.vue";
import { router } from "@inertiajs/vue3";
import { defineProps, defineOptions, ref, onMounted } from "vue";


onMounted(() => {
  document.title='Pesan'
});

defineOptions({
  layout: AppLayout,
});

const props = defineProps({
  title: String,
  pesan: Array,
});

const modalVisible = ref(false);
const selectedPesanId = ref(null);

const formatDate = (date) => {
  if (!date) return "";
  return new Date(date).toLocaleDateString("id-ID", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};

const showConfirmModal = (id) => {
  selectedPesanId.value = id;
  modalVisible.value = true;
};

const hapusPesan = () => {
  if (selectedPesanId.value) {
    router.delete(`/pesan/${selectedPesanId.value}`);
    modalVisible.value = false;
  }
};
</script>

<style scoped>
body {
  font-family: "Poppins", sans-serif;
}

/* Smooth transitions */
button {
  transition: all 0.3s ease;
}

.w-full {
  transition: box-shadow 0.3s ease, background-color 0.3s ease;
}

/* Mobile-first hover effects */
@media (hover: hover) {
  .hover\:shadow-xl:hover {
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
  }
}
</style>