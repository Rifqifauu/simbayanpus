<template>
  <div class="min-h-screen bg-gray-100 p-4 md:p-8">
    <div class="mx-auto flex min-h-[calc(100vh-4rem)] flex-col rounded-xl bg-white shadow-xl sm:max-w-4xl">
      <!-- Header and Search -->
      <div class="border-b border-gray-200 bg-white px-6 py-4 rounded-t-xl">
        <div class="flex items-center justify-between">
          <h1 class="text-2xl font-bold text-gray-800 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 text-red-700" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
            Notifikasi
          </h1>
          
         <button
  @click="messageModal = true"
  class="text-sm bg-red-700 hover:bg-red-600 text-white py-1.5 px-3 rounded-md flex items-center transition"
>
 
  Pesan Baru
</button>

        </div>
        
        <!-- Filter Tabs -->
        <div class="mt-4 flex flex-wrap items-center justify-between gap-2">
          <!-- Filter Buttons -->
          <div class="flex space-x-2">
            <button
              @click="activeFilter = 'all'"
              :class="`rounded-full px-4 py-1 text-sm font-medium transition ${
                activeFilter === 'all'
                  ? 'bg-red-700 text-white'
                  : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
              }`"
            >
              Semua
            </button>

            <button
              @click="activeFilter = 'incoming'"
              :class="`rounded-full px-4 py-1 text-sm font-medium transition flex items-center ${
                activeFilter === 'incoming'
                  ? 'bg-red-700 text-white'
                  : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
              }`"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
              </svg>
              Masuk
            </button>

            <button
              @click="activeFilter = 'outgoing'"
              :class="`rounded-full px-4 py-1 text-sm font-medium transition flex items-center ${
                activeFilter === 'outgoing'
                  ? 'bg-red-700 text-white'
                  : 'bg-gray-100 text-gray-600 hover:bg-gray-200'
              }`"
            >
              <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m22 2-7 20-4-9-9-4Z"></path>
                <path d="M22 2 11 13"></path>
              </svg>
              Keluar
            </button>
          </div>

          <!-- Search Input - Moved to filter area -->
          <div class="relative">
            <input
              type="text"
              placeholder="Cari pesan..."
              class="w-full rounded-lg border border-gray-300 py-2 pl-4 pr-10 text-sm focus:border-red-700 focus:outline-none focus:ring-1 focus:ring-red-700"
              v-model="searchQuery"
            />
            <button 
              v-if="searchQuery"
              class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600"
              @click="searchQuery = ''"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
          </div>
        </div>
      </div>
      <!-- Messages Container -->
      <div class="flex-grow p-6">
        <div v-if="filteredPesan.length === 0" class="flex flex-col items-center justify-center h-64 text-gray-500">
          <svg xmlns="http://www.w3.org/2000/svg" class="mb-4 text-gray-300" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
          <p class="text-lg">Tidak ada pesan ditemukan</p>
          <p v-if="searchQuery" class="mt-2 text-sm">
            Coba ubah kata kunci pencarian Anda
          </p>
        </div>

        <transition-group 
          name="fade" 
          tag="div" 
          class="space-y-4"
          v-else
        >
          <div
            v-for="item in filteredPesan"
            :key="item.id"
            :class="`relative w-full rounded-lg p-4 shadow-sm transition-all hover:shadow border-l-4 ${
              item.asal === 'admin'
                ? 'border-red-400 bg-red-50'
                : 'border-blue-400 bg-blue-50'
            }`"
          >
            <div class="flex items-start justify-between">
              <div class="flex items-center">
                <svg v-if="item.asal === 'admin'" xmlns="http://www.w3.org/2000/svg" class="text-red-700 mr-2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path></svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="text-blue-500 mr-2" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path></svg>
                <p class="font-medium text-gray-800">
                  {{ item.asal === 'admin' ? 'Pesan Masuk' : 'Pesan Keluar' }}
                </p>
              </div>
              <button
                @click="showConfirmModal(item.id)"
                class="text-gray-400 hover:text-red-700 transition-colors"
                aria-label="Delete message"
              >
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
              </button>
            </div>
            <p class="mt-2 text-gray-700">{{ item.pesan }}</p>
            <div class="mt-3 flex items-center justify-between">
              <p class="text-xs text-gray-500">
                {{ formatDate(item.created_at) }}
              </p>
              <button 
                v-if="item.asal === 'admin'"
                class="flex items-center text-xs font-medium text-red-700 hover:text-red-700"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path><path d="M15 3h6v6"></path><path d="m10 14 11-11"></path></svg>
                Lihat Detail
              </button>
            </div>
          </div>
        </transition-group>
      </div>
      
    
    </div>
    <!-- Modal -->
<div v-if="messageModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
  <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-md relative">
    <!-- Close button -->
    <button @click="messageModal = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl font-bold">&times;</button>

    <!-- Modal content -->
    <h2 class="text-lg font-semibold mb-4">Kirim Pesan Ke Admin Baru</h2>
    
    <textarea
      v-model="formData.pesan"
      class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-red-700"
      rows="5"
      placeholder="Tulis pesan Anda di sini..."
    ></textarea>

    <button
      @click="submitMessage"
      class="mt-4 w-full bg-red-700 hover:bg-red-600 text-white py-2 rounded-lg font-medium transition-colors"
    >
      Kirim Pesan
    </button>
  </div>
</div>

<SuccessModal
      :show="showSuccessModal"
      title="Pesan Terkirim"
    />
    <!-- Confirmation Modal -->
    <ConfirmModal
      v-if="modalVisible"
      title="Konfirmasi Hapus"
      message="Apakah Anda yakin ingin menghapus pesan ini?"
      @close="modalVisible = false"
      @confirm="hapusPesan"
    />
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { router } from "@inertiajs/vue3";
import ConfirmModal from "../components/ConfirmModal.vue";
import SuccessModal from "../components/SuccessModal.vue";
import AppLayout from "../layouts/AppLayout.vue";
import axios from 'axios';
defineOptions({
  layout: AppLayout,
});

const props = defineProps({
  title: String,
  pesan: Array,
  user: Object,
});

 const formData = ref({
      pesan: '',
      asal: 'user'
    });

const modalVisible = ref(false);
const selectedPesanId = ref(null);
const searchQuery = ref("");
const activeFilter = ref("all");
const messageModal = ref(false);
const showSuccessModal = ref(false);

onMounted(() => {
  document.title = "Notifikasi";
});

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

const submitMessage = async ()=> {
try {
        await axios.post('/pesan', {
          ...formData.value,
          id_user: props.user.id
        });
        formData.value.pesan = '';
        showSuccessModal.value = true;
        setTimeout(() => {
          document.location.href = '/pesan';
        }, 2000);
      } catch (error) {
        console.error('Error sending message:', error);
        alert('Gagal mengirim pesan. Silakan coba lagi.');
      } 
}

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

const filteredPesan = computed(() => {
  return props.pesan.filter(p => {
    const matchesFilter = 
      activeFilter.value === "all" || 
      (activeFilter.value === "incoming" && p.asal === "admin") || 
      (activeFilter.value === "outgoing" && p.asal !== "admin");
    
    const matchesSearch = 
      searchQuery.value === "" || 
      p.pesan.toLowerCase().includes(searchQuery.value.toLowerCase());
    
    return matchesFilter && matchesSearch;
  });
});
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: all 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>