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
            <!-- Division Selection -->
            <div>
              <label class="block text-yellow-300 mb-2">Divisi</label>
              <select 
                v-model="formData.division"
                class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300"
              >
                <option value="" disabled>Pilih...</option>
                <option v-for="div in divisions" :key="div.id" :value="div.nama_divisi">
                  {{ div.nama_divisi }}
                </option>
              </select>
            </div>
            <!-- Period Selection -->
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-yellow-300 mb-2">Periode Mulai</label>
                <input 
                  type="date" 
                  v-model="formData.startDate"
                  class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300"
                >
              </div>
              <div>
                <label class="block text-yellow-300 mb-2">Periode Berakhir</label>
                <input 
                  type="date" 
                  v-model="formData.endDate"
                  class="w-full px-3 py-2 rounded-md text-gray-700 focus:outline-none focus:ring-2 focus:ring-yellow-300"
                >
              </div>
            </div>
  
            <!-- File Uploads -->
            <div v-for="(label, key) in fileUploadFields" :key="key">
              <label class="block text-yellow-300 mb-2">{{ label }}</label>
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
            </div>
  
            <!-- Submit Button -->
            <button 
              type="submit"
              class="w-full bg-yellow-400 text-white py-2 px-4 rounded-md hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-300"
            >
              Daftar
            </button>
          </form>
        </div>
      </div>
  
      <!-- Modal for Error Message -->
      <div v-if="errorMessage" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-sm w-full text-center">
          <p class="text-red-500">{{ errorMessage }}</p>
          <button 
            @click="errorMessage = null"
            class="mt-4 bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600"
          >
            Tutup
          </button>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import { reactive, ref } from 'vue';
  import AppLayout from '../layouts/AppLayout.vue';
  import axios from 'axios';
  
  export default {
    name: 'InternshipForm',
    props: {
      divisions: {
        type: Array,
        required: true
      }
    },
    layout: AppLayout,
    setup(props) {
      // Reactive data
      const fileUploadFields = {
        cv: 'CV / Daftar Riwayat Hidup',
        coverLetter: 'Surat Pengantar Magang',
        proposal: 'Proposal Magang',
        guidelines: 'Pedoman Magang dari Universitas'
      };
  
      const formData = reactive({
        division: '',
        isFlexibleDivision: false,
        startDate: '',
        endDate: '',
        cv: null,
        coverLetter: null,
        proposal: null,
        guidelines: null
      });
  
      // Object to store file input references
      const fileInputs = ref({});
      const errorMessage = ref(null); // To store error messages
  
      // Set ref dynamically for each file input
      const setFileInputReference = (key) => {
        return (el) => {
          fileInputs.value[key] = el;
        };
      };
  
      // Handle file uploads
      const handleFileUpload = (event) => {
        const file = event.target.files[0];
        const key = event.target.dataset.key; // Get the key from data attribute
        if (file) {
          formData[key] = file;
        }
      };
  
      // Trigger file input click
      const triggerFileInput = (key) => {
        const inputElement = fileInputs.value[key];
        if (inputElement) {
          inputElement.click();
        } else {
          console.error('File input reference not found.');
        }
      };
  
      // Submit form
      const submitForm = async () => {
        try {
          const formDataToSend = new FormData();
  
          // Append form fields
          formDataToSend.append('division', formData.division);
          formDataToSend.append('isFlexibleDivision', formData.isFlexibleDivision);
          formDataToSend.append('startDate', formData.startDate);
          formDataToSend.append('endDate', formData.endDate);
  
          // Append files if they exist
          Object.keys(fileUploadFields).forEach((key) => {
            if (formData[key]) {
              formDataToSend.append(key, formData[key]);
            }
          });
  
          // Send request
          const response = await axios.post('/permohonan/create', formDataToSend, {
            headers: {
              'Content-Type': 'multipart/form-data'
            }
          });
  
          if (response.data.success) {
            alert('Pendaftaran berhasil!');
            // Reset form or redirect
            router.visit('/permohonan');
            
          }
        } catch (error) {
          console.error('Error submitting form:', error);
  
          // Display the error message if the user has already applied
          if (error.response && error.response.data && error.response.data.message) {
            errorMessage.value = error.response.data.message;
          } else {
            errorMessage.value = 'Terjadi kesalahan. Silakan coba lagi.';
          }
        }
      };
  
      return {
        divisions: props.divisions,
        fileUploadFields,
        formData,
        fileInputs,
        setFileInputReference,
        handleFileUpload,
        triggerFileInput,
        submitForm,
        errorMessage // Include errorMessage in the return
      };
    }
  };
  </script>
  