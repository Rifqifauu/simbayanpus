<template>
  <h3 class="text-center text-2xl md:text-3xl lg:text-3xl font-bold mt-5 text-red-600 mb-6">Daftar Penugasan Magang</h3>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2 p-8">
    <div v-for="(item, index) in divisi" :key="index" @click="openModal(item)" class="bg-red-700 text-white p-6 rounded-lg shadow-lg cursor-pointer hover:bg-red-800">
      <h4 class="text-xl text-white font-bold mb-4">{{ item.nama_divisi }}</h4>
    </div>
  </div>

  <!-- Modal -->
<div v-if="isModalOpen" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
  <div class="bg-white mx-6 p-6 rounded-lg max-w-lg w-full max-h-96 overflow-y-auto">
    <h2 class="text-xl font-semibold"> Jobdesk     <span class="text-md font-semibold text-red-600">
    {{ selectedDivisi.nama_divisi }}</span></h2>
    <p class="mb-4 text-sm" v-html="formattedKeterangan"></p>
    <button @click="closeModal" class="mt-4 bg-red-500 text-white px-4 py-2 rounded">Tutup</button>
  </div>
</div>

</template>

<script>
import AppLayout from '../layouts/AppLayout.vue';


export default {
  computed: {
  formattedKeterangan() {
    return this.selectedDivisi?.keterangan
      ? this.selectedDivisi.keterangan
          .replace(/(\d+)\./g, '<br><strong>$1.</strong> ') // Menambahkan line break & bold di angka
          .replace(/\n/g, '<br>') // Mengubah newline menjadi `<br>`
      : ''; // Jika tidak ada keterangan, kosongkan
  }
},
mounted (){
  document.title = this.title;

},

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