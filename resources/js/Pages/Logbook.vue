<template>
  <div class="min-h-screen flex flex-col p-4">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6" 
         data-aos="fade-down" 
         data-aos-duration="800">
      <h1 class="text-2xl md:text-3xl font-bold text-red-800 mb-4 md:mb-0 text-center md:text-left">
        Logbook Harian Peserta Magang
      </h1>
      <button type="button" @click="openCreateModal()"
        class="w-full md:w-auto flex items-center justify-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-4 py-2 transition"
        data-aos="fade-left" 
        data-aos-delay="200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Buat Catatan Baru</span>
      </button>
    </div>

    <!-- Mobile View -->
    <div class="md:hidden space-y-4">
      <div v-if="logbook.length">
        <div v-for="(item, idx) in logbook" :key="item.id"
          class="bg-white rounded-lg shadow border border-gray-200 p-4"
          data-aos="fade-up"
          :data-aos-delay="idx * 100">
          <div class="flex justify-between items-center mb-3 pb-2 border-b border-gray-200">
            <span class="font-bold text-red-800">Hari Ke - #{{ idx + 1 }} Magang</span>
          </div>

          <div class="divide-y divide-gray-200 text-sm">
            <div class="py-2 grid grid-cols-2 gap-2">
              <div class="font-medium text-gray-600">Tanggal:</div>
              <div>{{ item.tanggal }}</div>
            </div>
            <div class="py-2 grid grid-cols-2 gap-2">
              <div class="font-medium text-gray-600">Aktivitas:</div>
              <div>{{ item.aktivitas }}</div>
            </div>
            <div class="py-2 grid grid-cols-2 gap-2">
              <div class="font-medium text-gray-600">Verifikasi:</div>
              <div>{{ item.verifikasi }}</div>
            </div>
            <div class="py-2 grid grid-cols-2 gap-2">
              <div class="font-medium text-gray-600">Catatan Pembimbing:</div>
              <div>{{ item.catatan_pembimbing }}</div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="bg-white rounded-lg shadow p-4 text-center text-gray-500"
           data-aos="zoom-in">
        Anda belum membuat log.
      </div>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden md:block overflow-auto border border-gray-200 rounded-lg"
         data-aos="fade-up"
         data-aos-duration="1000"
         style="max-height: calc(100vh - 150px)">
      <table class="min-w-full table-fixed border-collapse">
        <thead>
          <tr class="text-white uppercase text-xs font-medium">
            <th class="bg-red-700 sticky top-0 px-6 py-3 text-start">No</th>
            <th class="bg-red-700 sticky top-0 px-6 py-3 text-start">Tanggal</th>
            <th class="bg-red-700 sticky top-0 px-6 py-3 text-start">Aktivitas</th>
            <th class="bg-red-700 sticky top-0 px-6 py-3 text-end">Verifikasi</th>
            <th class="bg-red-700 sticky top-0 px-6 py-3 text-end">Catatan Pembimbing</th>
          </tr>
        </thead>
        <tbody>
          <template v-if="logbook.length">
            <tr v-for="(item, idx) in logbook" :key="item.id" 
                class="odd:bg-white even:bg-gray-50"
                data-aos="fade-right"
                :data-aos-delay="idx * 50"
                data-aos-offset="-100">
              <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ idx + 1 }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ item.tanggal }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ item.aktivitas }}</td>
              <td class="px-6 py-4 text-sm text-gray-800 text-end">{{ item.verifikasi }}</td>
              <td class="px-6 py-4 text-sm text-gray-800 text-end">{{ item.catatan_pembimbing }}</td>
            </tr>
          </template>
          <tr v-else class="bg-white" data-aos="zoom-in">
            <td colspan="9" class="px-6 py-4 text-center text-sm text-gray-500">
              Anda belum membuat log.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal -->
    <transition name="modal">
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative"
             data-aos="zoom-in"
             data-aos-duration="400">
          <button class="absolute top-2 right-2 text-gray-500 hover:text-red-600" @click="closeModal">
            ✕
          </button>
          <div class="text-lg text-red-800 font-bold pb-4">
            {{ isEdit ? 'Edit Catatan' : 'Buat Catatan Baru' }}
          </div>
          <form @submit.prevent="submitLogbook">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Tanggal</label>
              <input v-model="form.tanggal" type="date" class="w-full border rounded px-3 py-2" required />
            </div>
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Aktivitas</label>
              <textarea v-model="form.aktivitas" class="w-full border rounded px-3 py-2" rows="3" required></textarea>
            </div>
            <div class="flex justify-end">
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Simpan
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
  <ErrorModal :show="showErrorModal" :message="errorMessage" title="Gagal Membuat Catatan"
    @close="showErrorModal = false" />
  <SuccessModal :show="showSuccessModal" :title="successModalTitle" @close="showSuccessModal = false" />
  <ConfirmModal
    v-if="showDeleteModal"
    :show="showDeleteModal"
    title="Konfirmasi Hapus"
    message="Apakah Anda yakin ingin menghapus data ini?"
    @confirm="deleteLogbook"
    @close="showDeleteModal = false"
  />
</template>
<script>
import axios from 'axios';
import AppLayout from '../layouts/AppLayout.vue';
import ErrorModal from '@/components/ErrorModal.vue';
import SuccessModal from '@/components/SuccessModal.vue';
import ConfirmModal from '@/components/ConfirmModal.vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

export default {
  layout: AppLayout,
  components: {
    ErrorModal,
    SuccessModal,
    ConfirmModal
  },
  props: {
    title: String,
    logbook: {
      type: Array,
      required: true,
    },
  },

  data() {
    return {
      isEdit: false,
      editId: null,
      showModal: false,
      showSuccessModal: false,
      showErrorModal: false,
      showDeleteModal: false,
      deleteID: null,
      errorMessage: '',
      successModalTitle: '',
      form: {
        tanggal: '',
        aktivitas: '',
      },
    };
  },

  mounted() {
    document.title = this.title;
    
    // Initialize AOS
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true,
      offset: 50,
      delay: 100,
    });
  },

  methods: {
    openCreateModal() {
      this.isEdit = false;
      this.editId = null;
      this.resetForm();
      this.showModal = true;
      
      // Refresh AOS for modal elements
      this.$nextTick(() => {
        AOS.refresh();
      });
    },
    
    showDeleteModalID(id) {
      this.deleteID = id;
      this.showDeleteModal = true;
    },
    
    openEditModal(item) {
      this.isEdit = true;
      this.editId = item.id;
      this.form.tanggal = item.tanggal;
      this.form.aktivitas = item.aktivitas;
      this.showModal = true;
      
      // Refresh AOS for modal elements
      this.$nextTick(() => {
        AOS.refresh();
      });
    },

    closeModal() {
      this.showModal = false;
      this.resetForm();
    },

    resetForm() {
      this.form = {
        tanggal: '',
        aktivitas: '',
      };
    },

    async deleteLogbook() {
      try {
        const id = this.deleteID;
        const response = await axios.delete(`/logbook/${id}`);
        if (response.status === 200) {
          this.successModalTitle = "Berhasil Menghapus Data";
          this.showSuccessModal = true;
          setTimeout(() => {
            this.showSuccessModal = false;
            window.location.reload();
          }, 2000);
        }
      } catch (error) {
        this.handleError(error);
      }
    },

    async submitLogbook() {
      try {
        const formData = new FormData();
        Object.entries(this.form).forEach(([key, value]) => {
          formData.append(key, value);
        });

        let response;

        if (this.isEdit) {
          formData.append('_method', 'PUT');
          response = await axios.post(`/logbook/${this.editId}`, formData);
          this.successModalTitle = "Berhasil Mengubah Catatan";
        } else {
          response = await axios.post('/logbook', formData);
          this.successModalTitle = "Berhasil Membuat Catatan";
        }

        if (response.status === 200) {
          this.showSuccessModal = true;
          setTimeout(() => {
            this.showSuccessModal = false;
            this.closeModal();
            // Refresh data after submission
            window.location.reload();
          }, 2000);
        }
      } catch (error) {
        this.handleError(error);
      }
    },

    handleError(error) {
      if (error.response && error.response.data.errors) {
        console.error('Validation errors:', error);
        this.errorMessage = this.formatErrorMessages(error.response.data.errors);
      } else if (error.response && error.response.data.messages) {
        console.error('Server messages:', error.response.data.messages);
        this.errorMessage = this.formatErrorMessages(error.response.data.messages);
      } else if (error.response && error.response.data.message) {
        console.error('Error message:', error.response.data.message);
        this.errorMessage = error.response.data.message;
      } else {
        console.error('Unexpected error:', error);
        this.errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';
      }

      this.showErrorModal = true;
      setTimeout(() => {
        this.showErrorModal = false;
      }, 2000);
    },

    formatErrorMessages(errors) {
      if (typeof errors === 'string') return errors;

      if (Array.isArray(errors)) {
        return errors.join(', ');
      }

      // Object format
      return Object.values(errors)
        .flat()
        .join(', ');
    }
  }
};
</script>

<style>
/* Optional custom transition effects for modals */
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s, transform 0.3s;
}

.modal-enter-from, .modal-leave-to {
  opacity: 0;
  transform: scale(0.9);
}
</style>