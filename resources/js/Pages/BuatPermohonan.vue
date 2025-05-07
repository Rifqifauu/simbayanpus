<template>
  <div class="min-h-screen bg-gray-100 py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-2xl mx-auto">
      <!-- Header -->
      <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-red-600">Daftar Magang</h1>
        <p class="text-gray-600">Isi data diri Anda di bawah ini!</p>
      </div>

      <!-- Form Container -->
      <div class="bg-red-600 rounded-lg shadow-lg p-6 text-white">
        <form @submit.prevent="submitForm" class="space-y-6">


          <!-- Period Selection -->
          <div class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-yellow-300 mb-2">Tanggal Mulai Magang<span class="text-yellow-200">*</span></label>
              <input 
                type="date" 
                v-model="formData.startDate"
                class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300"
              >
            </div>
            <div>
              <label class="block text-yellow-300 mb-2">Tanggal Selesai Magang<span class="text-yellow-200">*</span></label>
              <input 
                type="date" 
                v-model="formData.endDate"
                class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300"
              >
            </div>
          </div>

          <!-- File Uploads -->
          <div v-for="(label, key) in fileUploadFields" :key="key">
      <label class="block text-yellow-300 mb-2">{{ label }} <span class="text-yellow-200"></span></label>
      <div class="flex items-center space-x-2">
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
          class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300"
        >
          Pilih File
        </button>
        <span class="text-sm">{{ formData[key] ? formData[key].name : 'Tidak ada file yang dipilih.' }}</span>
      </div>
      
      <!-- Add FilePreview component -->
      <FilePreview
        v-if="formData[key] && formData[key].type === 'application/pdf'"
        :file="formData[key]"
        class="mt-4"
      />
    </div>

          <!-- Submit Button -->
          <button 
            type="submit"
            :disabled="!isFormValid"
            :class="[
              'w-full py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-yellow-300',
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
    user: {
      type: Object,
    },
    userDetail: {
      type: Object,
    }
  },
  components: {
    SuccessModal,
    ErrorModal,
    FilePreview
  },
  
  layout: AppLayout,
  setup(props) {
    // Reactive data
    const fileUploadFields = {
      cv: 'CV / Daftar Riwayat Hidup*',
      coverLetter: 'Surat Pengantar Magang*',
      proposal: 'Proposal Magang*',
      guidelines: 'Pedoman Magang dari Universitas'
    };
    
    console.log("User:", props.user);
    console.log("User Detail:", props.userDetail);
    
    const formData = reactive({
      division: 'default',
      startDate: '',
      endDate: '',
      cv: null,
      coverLetter: null,
      proposal: null,
      guidelines: null
    });

    // Refs
    const fileInputs = ref({});
    const showErrorModal = ref(false);
    const errorMessage = ref('');
    const showSuccessModal = ref(false);

    // Computed
    const isFormValid = computed(() => {
      return formData.startDate && 
             formData.endDate && 
             formData.cv && 
             formData.coverLetter && 
             formData.proposal && 
             new Date(formData.startDate) <= new Date(formData.endDate);
    });

    // Methods
    const setFileInputReference = (key) => {
      return (el) => {
        fileInputs.value[key] = el;
      };
    };

    const handleFileUpload = (event) => {
      const file = event.target.files[0];
      const key = event.target.dataset.key;
      
      if (file) {
        // Validate file type
        const validTypes = ['.pdf', '.doc', '.docx'];
        const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
        
        if (!validTypes.includes(fileExtension)) {
          errorMessage.value = 'Format file tidak valid. Gunakan PDF, DOC, atau DOCX.';
          showErrorModal.value = true;
          event.target.value = ''; // Clear the input
          return;
        }

        // Validate file size (max 2MB)
        if (file.size > 2 * 1024 * 1024) {
          errorMessage.value = 'Ukuran file maksimal 2MB';
          showErrorModal.value = true;
          event.target.value = ''; // Clear the input
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
      // Validate division

      // Validate dates
      if (!formData.startDate || !formData.endDate) {
        errorMessage.value = 'Periode magang wajib diisi';
        showErrorModal.value = true;
        return false;
      }

      // Validate date range
      if (new Date(formData.startDate) > new Date(formData.endDate)) {
        errorMessage.value = 'Tanggal mulai tidak boleh lebih besar dari tanggal selesai';
        showErrorModal.value = true;
        return false;
      }

      // Validate files
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
    if (!validateForm()) {
      return;
    }

    const formDataToSend = new FormData();
    formDataToSend.append("division", formData.division);
    formDataToSend.append("startDate", formData.startDate);
    formDataToSend.append("endDate", formData.endDate);

    Object.keys(fileUploadFields).forEach((key) => {
      if (formData[key]) {
        formDataToSend.append(key, formData[key]);
      }
    });

    // Kirim request ke server
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
    console.error("Error:", error);
    console.error("Error Response:", error.response);

    if (error.response) {
      if (error.response.status === 400) {
        // Tangkap error Laravel
        errorMessage.value = error.response.data.error || "Terjadi kesalahan.";
      } else if (error.response.data.errors) {
        // Tangkap error validasi (422)
        errorMessage.value = Object.values(error.response.data.errors)
          .flat()
          .join(", ");
      } else {
        errorMessage.value =
          error.response.data.message || "Terjadi kesalahan tak terduga.";
      }
    } else {
      errorMessage.value = "Gagal menghubungkan ke server.";
    }

    // Paksa modal error muncul
    showErrorModal.value = true;

    // Debug apakah nilai berubah
    console.log("showErrorModal:", showErrorModal.value);
    console.log("errorMessage:", errorMessage.value);

    setTimeout(() => {
      showErrorModal.value = false;
    }, 3000);
  }
};


    return {
      fileUploadFields,
      formData,
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