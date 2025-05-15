<template>
  <div class="min-h-screen flex flex-col p-4">
    <!-- Header -->
    <div class="flex flex-col md:flex-row items-center justify-between mb-6" 
         data-aos="fade-down" 
         data-aos-duration="800">
      <h1 class="text-2xl md:text-3xl font-bold text-red-800 mb-4 md:mb-0 text-center md:text-left">
        Daftar Hadir Peserta Magang
      </h1>
      <button type="button" @click="openCreateModal()"
        class="w-full md:w-auto flex items-center justify-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg text-sm px-4 py-2 transition"
        data-aos="fade-left" 
        data-aos-delay="200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        <span>Isi Kehadiran</span>
      </button>
    </div>

    <!-- Mobile View -->
    <div class="md:hidden space-y-4">
      <div v-if="attendance.length">
        <div v-for="(item, idx) in attendance" :key="item.id"
          class="bg-white rounded-lg shadow border border-gray-200 p-4"
          data-aos="fade-up"
          :data-aos-delay="idx * 100">
          <div class="flex justify-between items-center mb-3 pb-2 border-b border-gray-200">
            <span class="font-bold text-red-800">{{formatTanggal(item.tanggal)}}</span>
          </div>

          <div class="divide-y divide-gray-200 text-sm">
            <div class="py-2 grid grid-cols-2 gap-2">
              <div class="font-medium text-gray-600">Waktu Datang:</div>
              <div>{{ item.waktu_masuk }} </div>
            </div>

          <div class="divide-y divide-gray-200 text-sm">
            <div class="py-2 grid grid-cols-2 gap-2">
              <div class="font-medium text-gray-600">Status</div>
              <div>{{ item.status }}</div>
            </div>
            </div>
            <div class="py-2 grid grid-cols-2 gap-2">
              <div class="font-medium text-gray-600">Waktu Pulang:</div>
              <div>{{ item.waktu_keluar }} </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="bg-white rounded-lg shadow p-4 text-center text-gray-500"
           data-aos="zoom-in">
        Anda belum mengisi daftar hadir.
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
                        <th class="bg-red-700 sticky top-0 px-6 py-3 text-start">Status</th>
            <th class="bg-red-700 sticky top-0 px-6 py-3 text-start">Waktu Datang</th>
            <th class="bg-red-700 sticky top-0 px-6 py-3 text-start">Waktu Pulang</th>

          </tr>
        </thead>
        <tbody>
          <template v-if="attendance.length">
            <tr v-for="(item, idx) in attendance" :key="item.id" 
                class="odd:bg-white even:bg-gray-50"
                data-aos="fade-right"
                :data-aos-delay="idx * 50"
                data-aos-offset="-100">
              <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ idx + 1 }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{formatTanggal(item.tanggal)}}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ item.status }}</td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ item.waktu_masuk }} </td>
              <td class="px-6 py-4 text-sm text-gray-800">{{ item.waktu_keluar }} </td>
            </tr>
          </template>
          <tr v-else class="bg-white" data-aos="zoom-in">
            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
              Anda belum mengisi daftar hadir.
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Modal for OTP -->
    <transition name="modal">
      <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
<div class="bg-white rounded-lg shadow-lg w-full max-w-xs p-6 mx-auto"
             data-aos="zoom-in"
             data-aos-duration="400">
          <button class="absolute top-2 right-2 text-gray-500 hover:text-red-600" @click="closeModal">
            ✕
          </button>
          <div class="text-lg text-red-800 font-bold pb-4">
            Masukkan Kode OTP
          </div>
          <form @submit.prevent="submitOtp">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2">Kode OTP</label>
              <input
                v-model="form.otp"
                type="text"
                maxlength="6"
                class="w-full border rounded px-3 py-2"
                placeholder="Masukkan 6 digit kode"
                required
              />
            </div>
            <div class="flex justify-end">
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                Verifikasi
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
  <ErrorModal :show="showErrorModal" :message="errorMessage" title="Gagal Membuat Catatan"
    @close="showErrorModal = false" />
  <SuccessModal :show="showSuccessModal" :title="successModalTitle" :message="successMessage" @close="showSuccessModal = false" />
  <ConfirmModal
    v-if="showDeleteModal"
    :show="showDeleteModal"
    title="Konfirmasi Hapus"
    message="Apakah Anda yakin ingin menghapus data ini?"
    @confirm="deleteAttendance"
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
    attendance: {
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
      successMessage: '',
      form: {
        otp: '',
      },
    };
  },

  mounted() {
    document.title = "Daftar Hadir";
    
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
    formatTanggal(tanggalStr) {
      if (!tanggalStr) return '-';

      const [day, month, year] = tanggalStr.split('-');
      const namaBulan = [
        '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
      ];

      const angkaBulan = parseInt(month, 10);
      const bulan = namaBulan[angkaBulan] || '-';

      return `${parseInt(day)} ${bulan} ${year}`;
    },
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
        otp: '',
      };
    },

    async submitOtp() {
      try {
        const response = await axios.post('/attendance', { otp: this.form.otp });
        console.log('OTP terverifikasi:', response.data);

        if (response.status === 200) {
          this.successModalTitle = "Berhasil";
          this.successMessage = "Kehadiran berhasil dicatat";
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

    async deleteAttendance() {
      if (!this.deleteID) return;
      
      try {
        const response = await axios.delete(`/attendance/${this.deleteID}`);
        
        if (response.status === 200) {
          this.successModalTitle = "Berhasil Dihapus";
          this.successMessage = "Data kehadiran berhasil dihapus";
          this.showSuccessModal = true;
          setTimeout(() => {
            this.showSuccessModal = false;
            // Refresh data after deletion
            window.location.reload();
          }, 2000);
        }
      } catch (error) {
        this.handleError(error);
      } finally {
        this.showDeleteModal = false;
        this.deleteID = null;
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