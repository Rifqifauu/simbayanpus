<template>
    <div class="p-8 bg-gray-50 min-h-screen">
      <!-- Main container with fixed width and height -->
      <div class="max-w-4xl bg-red-600 rounded-xl mx-auto min-h-[calc(100vh-4rem)] flex flex-col">
        <!-- Title -->
        <h1 class="text-3xl font-bold text-red-200 text-center py-4">Notifikasi</h1>
  
        <!-- Messages container -->
        <div class="w-full space-y-4 p-6 bg-opacity-50 flex-grow">
          <!-- Loop through messages -->
          <div
            v-for="pesan in pesanMasuk"
            :key="pesan.id"
            :class="[
              'w-full p-4 rounded-xl shadow-lg border transition-all duration-300',
              pesan.tipe === 'masuk'
                ? 'bg-blue-50 border-blue-200 hover:shadow-xl'
                : 'bg-green-50 border-green-200 hover:shadow-xl',
            ]"
          >
            <p class="font-semibold text-lg text-red-800">
              {{ pesan.tipe === 'masuk' ? 'Pesan Masuk' : 'Pesan Keluar' }}
            </p>
            <p class="text-sm text-gray-800 mt-1">{{ pesan.pesan }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ formatDate(pesan.created_at) }}</p>
          </div>
  
          <!-- Show message if no data -->
          <div
            v-if="pesanMasuk.length === 0"
            class="w-full bg-white p-6 rounded-xl shadow-lg border border-gray-200 text-center"
          >
            <p class="text-gray-600">Tidak ada pesan</p>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import AppLayout from "../layouts/AppLayout.vue";
  
  export default {
    props: {
      title: {
        type: String,
        required: false,
      },
      pesanMasuk: {
        type: Array,
        required: false,
        default: () => [],
      },
    },
    layout: AppLayout,
    mounted() {
      console.log(this.pesanMasuk);
    },
    methods: {
      formatDate(date) {
        if (!date) return "";
        return new Date(date).toLocaleDateString("id-ID", {
          year: "numeric",
          month: "long",
          day: "numeric",
          hour: "2-digit",
          minute: "2-digit",
        });
      },
    },
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
  