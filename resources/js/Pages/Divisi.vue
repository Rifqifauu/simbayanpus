<template>
  <h3 class="text-center text-3xl font-bold mt-5 text-red-600 mb-6">Daftar Divisi Magang</h3>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2 p-8">
    <div v-for="(item, index) in divisi" :key="index" @click="openModal(item)" class="bg-red-700 text-white p-6 rounded-lg shadow-lg cursor-pointer hover:bg-red-800">
      <h4 class="text-xl text-white font-bold mb-4">{{ item.nama_divisi }}</h4>
      <p class="font-bold mb-4">Kuota tersedia: {{ item.kuota }}</p>
    </div>
  </div>

  <!-- Modal -->
  <div v-if="isModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-lg max-w-lg w-full">
      <h2 class="text-xl font-semibold mb-4">{{ selectedDivisi.nama_divisi }}</h2>
      <p class="mb-4">{{ selectedDivisi.keterangan }}</p>
      <p class="font-bold mb-4">Kuota tersedia: {{ selectedDivisi.kuota }}</p>
      <button @click="closeModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Tutup</button>
    </div>
  </div>
</template>

<script>
import AppLayout from '../layouts/AppLayout.vue';

export default {
  props: {
    title: String,
    divisi: {
      type: Array,
      required: true,
      validator(value) {
        return Array.isArray(value) && value.every(item => item.nama_divisi && item.keterangan && item.kuota);
      },
    },
  },
  layout: AppLayout,
  data() {
    return {
      isModalOpen: false,
      selectedDivisi: {},
    };
  },
  methods: {
    openModal(divisi) {
      this.selectedDivisi = divisi;
      this.isModalOpen = true;
    },
    closeModal() {
      this.isModalOpen = false;
      this.selectedDivisi = {};
    },
  },
};
</script>

<style scoped>
.cursor-pointer:hover {
  transform: translateY(-5px);
  transition: transform 0.3s ease-in-out;
}
</style>