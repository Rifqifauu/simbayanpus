<template>
  <div class="p-8 bg-gray-50 min-h-screen">
    <!-- Main container -->
    <div class="max-w-4xl bg-red-600 rounded-xl mx-auto min-h-[calc(100vh-4rem)] flex flex-col">
      <!-- Title -->
      <h1 class="text-3xl font-bold text-red-200 text-center py-4">Notifikasi</h1>

      <!-- Messages container -->
      <div class="w-full space-y-4 p-6 bg-opacity-50 flex-grow">
        <!-- Loop through messages -->
        <div
          v-for="pesan in pesan"
          :key="pesan.id"
          :class="[
            'w-full p-4 rounded-xl shadow-lg border transition-all duration-300 relative',
            pesan.asal === 'admin'
              ? 'bg-blue-50 border-blue-200 hover:shadow-xl'
              : 'bg-green-50 border-green-200 hover:shadow-xl',
          ]"
        >
          <p class="font-semibold text-lg text-red-800">
            {{ pesan.asal === 'admin' ? 'Pesan Masuk' : 'Pesan Keluar' }}
          </p>
          <p class="text-sm text-gray-800 mt-1">{{ pesan.pesan }}</p>
          <p class="text-xs text-gray-400 mt-2">{{ formatDate(pesan.created_at) }}</p>

          <!-- Delete Button -->
          <button
            @click="hapusPesan(pesan.id)"
            class="absolute top-2 right-2 text-red-500 hover:text-red-700 transition-all"
          >
            ❌
          </button>
        </div>

        <!-- Show message if no data -->
        <div
          v-if="pesan.length === 0"
          class="w-full bg-white p-6 rounded-xl shadow-lg border border-gray-200 text-center"
        >
          <p class="text-gray-600">Tidak ada pesan</p>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import AppLayout from '../layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { defineProps, defineOptions } from 'vue';

defineOptions({
  layout: AppLayout,
});

const props = defineProps({
  title: String,
  pesan: Array,
});

// Function to format date
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

// Function to delete message
const hapusPesan = (id) => {
  if (confirm("Apakah Anda yakin ingin menghapus pesan ini?")) {
    router.delete(`/pesan/${id}`);
  }
};
</script>


<style scoped>
body {
  font-family: "Poppins", sans-serif;
}

.bg-gray-50 {
  background-color: #f9fafb;
}

.hover\:shadow-xl:hover {
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
}
</style>
