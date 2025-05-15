<template>
  <div class="min-h-screen bg-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-red-600">Daftar Magang</h1>
        <p class="text-gray-600 text-sm sm:text-base">Isi data diri Anda di bawah ini!</p>
      </div>

      <!-- Form Container -->
      <div class="bg-red-600 rounded-lg shadow-lg p-4 sm:p-6 text-white">
        <form @submit.prevent="submitForm" class="space-y-6">
          <!-- Period Selection -->
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-yellow-300 mb-2 text-sm">Tanggal Mulai Magang<span class="text-yellow-200">*</span></label>
              <input 
                type="date" 
                v-model="formData.startDate"
                class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm"
              >
            </div>

            <div>
              <label class="block text-yellow-300 mb-2 text-sm">Tanggal Selesai Magang<span class="text-yellow-200">*</span></label>
              <input 
                type="date" 
                v-model="formData.endDate"
                class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm"
              >
            </div>

            <div class="sm:col-span-2">
              <label class="block text-yellow-300 mb-2 text-sm">Pilihan Divisi<span class="text-yellow-200">*</span></label>
              <select
                v-model="formData.division"
                class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm"
              >
                <option disabled value="">Pilih Divisi</option>
                <option 
                  v-for="(item, index) in divisiList" 
                  :key="index" 
                  :value="item.nama_divisi"
                >
                  {{ item.nama_divisi }}
                </option>
              </select>
            </div>
          </div>

          <!-- File Uploads -->
          <div 
            v-for="(label, key) in fileUploadFields" 
            :key="key"
            class="space-y-1"
          >
            <label class="block text-yellow-300 mb-2 text-sm">{{ label }}</label>
            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0">
              <input 
                type="file"
                :ref="setFileInputReference(key)"
                :data-key="key"
                @change="handleFileUpload($event)"
                class="hidden"
                accept=".pdf,.doc,.docx"
              >
              <button 
                type="button"
                @click="triggerFileInput(key)"
                class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm"
              >
                Pilih File
              </button>
              <span class="text-sm break-all">{{ formData[key] ? formData[key].name : 'Tidak ada file yang dipilih.' }}</span>
            </div>
          </div>

          <!-- Submit Button -->
          <button 
            type="submit"
            :disabled="!isFormValid"
            :class="[ 
              'w-full py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-300 text-sm font-semibold',
              isFormValid ? 'bg-yellow-400 hover:bg-yellow-500' : 'bg-gray-400 cursor-not-allowed'
            ]"
          >
            Daftar
          </button>
        </form>
      </div>
    </div>

    <!-- Modals -->
    <ErrorModal 
      :show="showErrorModal"
      :message="errorMessage"
      title="Pendaftaran Gagal"
      @close="showErrorModal = false"
    />
    <SuccessModal
      :show="showSuccessModal"
      title="Pendaftaran Berhasil"
      @close="showSuccessModal = false"
    />
  </div>
</template>

<script>
import FilePreview from '@/components/FilePreview.vue';
import { reactive, ref, computed } from 'vue';
import AppLayout from '../layouts/AppLayout.vue';
import axios from 'axios';
import SuccessModal from '@/components/SuccessModal.vue';
import ErrorModal from '@/components/ErrorModal.vue';

export default {
  name: 'InternshipForm',
  props: {
    user: Object,
    userDetail: Object,
    divisi: {
      type: Array,
      required: true
    },
    title: String
  },
  components: {
    SuccessModal,
    ErrorModal,
    FilePreview
  },
  mounted(){
    document.title = this.title;
  },
  layout: AppLayout,
  setup(props) {
    const fileUploadFields = {
      cv: 'CV / Daftar Riwayat Hidup*',
      coverLetter: 'Surat Pengantar Magang*',
      proposal: 'Proposal Magang*',
      guidelines: 'Pedoman Magang dari Universitas'
    };

    const params = new URLSearchParams(window.location.search);
    const defaultDivisi = params.get('divisi') || '';

    const formData = reactive({
      division: defaultDivisi,
      startDate: '',
      endDate: '',
      cv: null,
      coverLetter: null,
      proposal: null,
      guidelines: null
    });

    const divisiList = props.divisi;

    const fileInputs = ref({});
    const showErrorModal = ref(false);
    const errorMessage = ref('');
    const showSuccessModal = ref(false);

    const isFormValid = computed(() => {
      return formData.startDate && 
             formData.endDate && 
             formData.cv && 
             formData.coverLetter && 
             formData.proposal && 
             new Date(formData.startDate) <= new Date(formData.endDate);
    });

    const setFileInputReference = (key) => {
      return (el) => {
        fileInputs.value[key] = el;
      };
    };

    const handleFileUpload = (event) => {
      const file = event.target.files[0];
      const key = event.target.dataset.key;

      if (file) {
        const validTypes = ['.pdf', '.doc', '.docx'];
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

        if (!validTypes.includes(fileExtension)) {
          errorMessage.value = 'Format file tidak valid. Gunakan PDF, DOC, atau DOCX.';
          showErrorModal.value = true;
          event.target.value = '';
          return;
        }

        if (file.size > 2 * 1024 * 1024) {
          errorMessage.value = 'Ukuran file maksimal 2MB';
          showErrorModal.value = true;
          event.target.value = '';
          return;
        }

        formData[key] = file;
      }
    };

    const triggerFileInput = (key) => {
      const inputElement = fileInputs.value[key];
      if (inputElement) {
        inputElement.click();
      }
    };

    const validateForm = () => {
      if (!formData.startDate || !formData.endDate) {
        errorMessage.value = 'Periode magang wajib diisi';
        showErrorModal.value = true;
        return false;
      }

      if (new Date(formData.startDate) > new Date(formData.endDate)) {
        errorMessage.value = 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai';
        showErrorModal.value = true;
        return false;
      }

      const requiredFiles = ['cv', 'coverLetter', 'proposal'];
      for (const file of requiredFiles) {
        if (!formData[file]) {
          errorMessage.value = `${fileUploadFields[file]} wajib diupload`;
          showErrorModal.value = true;
          return false;
        }
      }

      return true;
    };

    const submitForm = async () => {
      try {
        if (!validateForm()) return;

        const formDataToSend = new FormData();
        formDataToSend.append("division", formData.division);
        formDataToSend.append("startDate", formData.startDate);
        formDataToSend.append("endDate", formData.endDate);

        Object.keys(fileUploadFields).forEach((key) => {
          if (formData[key]) {
            formDataToSend.append(key, formData[key]);
          }
        });

        const response = await axios.post("/permohonan/create", formDataToSend, {
          headers: { "Content-Type": "multipart/form-data" },
        });

        if (response.data.success) {
          showSuccessModal.value = true;
          setTimeout(() => {
            document.location.href = "/permohonan";
          }, 2000);
        }
      } catch (error) {
        if (error.response) {
          if (error.response.status === 400) {
            errorMessage.value = error.response.data.error || "Terjadi kesalahan.";
          } else if (error.response.data.errors) {
            errorMessage.value = Object.values(error.response.data.errors).flat().join(", ");
          } else {
            errorMessage.value = error.response.data.message || "Terjadi kesalahan tak terduga.";
          }
        } else {
          errorMessage.value = "Gagal menghubungkan ke server.";
        }

        showErrorModal.value = true;
        setTimeout(() => {
          showErrorModal.value = false;
        }, 3000);
      }
    };

    return {
      fileUploadFields,
      formData,
      divisiList,
      fileInputs,
      showErrorModal,
      errorMessage,
      showSuccessModal,
      isFormValid,
      setFileInputReference,
      handleFileUpload,
      triggerFileInput,
      submitForm
    };
  }
};
</script>
