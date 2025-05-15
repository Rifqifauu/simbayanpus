<template>
  <div class="min-h-screen bg-gradient-to-br from-red-900 via-red-700 to-red-800 py-10 px-4">
    <h3 class="text-center text-white text-3xl md:text-4xl font-extrabold mb-10 drop-shadow-lg">
      Daftar Divisi Magang
    </h3>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
      <div 
        v-for="(item, index) in divisi" 
        :key="index"
        class="relative bg-white p-6 rounded-2xl shadow-lg hover:shadow-red-400 transition-transform hover:-translate-y-1 cursor-pointer flex flex-col gap-4"
      >
        <!-- Kuota Badge -->
        <span class="absolute top-4 right-4 bg-yellow-400 text-black text-xs font-bold px-3 py-1 rounded-full shadow">
          Kuota: {{ item.kuota }}
        </span>

        <h4 class="text-red-700 text-xl font-bold">{{ item.nama_divisi }}</h4>
        <p class="text-sm text-gray-700 flex-grow">{{ item.keterangan }}</p>

        <button 
          @click="daftarMagang(item)"
          class="mt-4 bg-yellow-400 hover:bg-yellow-500 text-black text-sm font-semibold px-4 py-2 rounded-full shadow transition duration-300 self-start"
        >
          Daftar
        </button>
      </div>
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
        return Array.isArray(value) &&
          value.every(item => item.nama_divisi && item.keterangan && item.kuota);
      },
    },
  },
  layout: AppLayout,
  mounted() {
    document.title = this.title;
  },
  methods: {
    daftarMagang(item) {
      const params = new URLSearchParams({ divisi: item.nama_divisi });
      window.location.href = `/permohonan/create?${params.toString()}`;
    }
  },
};
</script>
