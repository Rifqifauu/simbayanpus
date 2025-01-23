<template>
    <div class="h-screen flex">
      <!-- Left side with illustration -->
      <div
        class="w-1/2 bg-red-700 p-14 hidden md:block relative bg-gradient-to-l from-red-700 to-red-800"
        style="border-top-right-radius: 2rem; border-bottom-right-radius: 2rem;"
      >
        <h1 class="text-4xl font-bold text-white mb-4">
          Ayo Mulai Magang Sekarang!
        </h1>
        <p class="text-lg text-white mb-10">
          Daftarkan akun Anda untuk mendaftar magang dan mengakses semua fitur.
        </p>
        <img src="../../../storage/asset/Element/undraw_post_eok2.svg" alt="Illustration" class="w-100" />
      </div>
  
      <!-- Right side with registration form -->
      
      <div class="w-full md:w-1/2 p-8 flex flex-col justify-center">
        <div class="max-w-md w-full mx-auto">
          <h2 class="text-3xl font-bold mb-4 text-red-700">Daftar</h2>
          <p class="text-gray-600 mb-6">
            Silakan isi formulir di bawah ini untuk membuat akun baru.
          </p>
  
          <form @submit.prevent="handleRegister">
            <div class="space-y-4">
              <!-- Name -->
              <div>
                <input
                  type="text"
                  v-model="form.name"
                  placeholder="Masukkan Nama Lengkap Anda"
                  class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-700 focus:border-red-700"
                />
                <p v-if="errors.name" class="text-red-500 text-sm mt-1">
                  {{ errors.name }}
                </p>
              </div>
  
              <!-- Email -->
              <div>
                <input
                  type="email"
                  v-model="form.email"
                  placeholder="Masukkan Email Anda"
                  class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-700 focus:border-red-700"
                />
                <p v-if="errors.email" class="text-red-500 text-sm mt-1">
                  {{ errors.email }}
                </p>
              </div>
  
              <!-- Password -->
              <div class="relative">
                <input
                  :type="showPassword ? 'text' : 'password'"
                  v-model="form.password"
                  placeholder="Masukkan Kata Sandi Anda"
                  class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-700 focus:border-red-700"
                />
                <button
                  type="button"
                  @click="showPassword = !showPassword"
                  class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"
                >
                  👁
                </button>
                <p v-if="errors.password" class="text-red-500 text-sm mt-1">
                  {{ errors.password }}
                </p>
              </div>
  
              <!-- Confirm Password -->
              <div class="relative">
                <input
                  :type="showConfirmPassword ? 'text' : 'password'"
                  v-model="form.password_confirmation"
                  placeholder="Konfirmasi Kata Sandi Anda"
                  class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-700 focus:border-red-700"
                />
                <button
                  type="button"
                  @click="showConfirmPassword = !showConfirmPassword"
                  class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"
                >
                  👁
                </button>
              </div>
  
              <!-- Submit Button -->
              <button
                type="submit"
                class="w-full bg-red-700 text-white py-3 rounded-full hover:bg-red-800 transition-colors"
              >
                Daftar
              </button>
            </div>
          </form>
  
          <div class="mt-4 text-center">
            <p class="text-gray-600">
              Sudah Punya Akun?
              <a href="/login" class="text-red-700 hover:underline">Masuk Sekarang</a>
            </p>
          </div>
        </div>
      </div>
    </div>

        <!-- Modal for Error Messages -->
        <div v-if="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-80">
        <div class="flex justify-between items-center">
          <h3 class="text-xl font-semibold text-red-700">Error</h3>
        </div>
        <div class="mt-4">
          <p class="text-gray-800">{{ errorMessage }}</p>
        </div>
        <div class="mt-6 text-center">
          <button @click="closeModal" class="px-4 py-2 bg-red-700 text-white rounded-lg hover:bg-red-800">
            Close
          </button>
        </div>
      </div>
    </div>

    <!-- Modal for Success Messages -->
    <div v-if="showSuccessModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-80">
        <div class="text-center">
          <h3 class="text-xl font-semibold text-green-700">Daftar Berhasil</h3>
        </div>
        <div class="mt-6 text-center">
        <img src="../../../storage/asset/daftarberhasil.gif" alt="Success Illustration" class="mx-auto mb-50 w-40 h-50">
        <p class="text-gray-800">{{ successMessage }}</p>
      </div>
      </div>
    </div>
  </template>
  
  <script>
  import { ref } from "vue";
  import axios from "axios";
  import { router } from "@inertiajs/vue3";
  
  export default {
    setup() {
      const form = ref({
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
      });
  
      const errors = ref({});
      const showPassword = ref(false);
      const showConfirmPassword = ref(false);
      const showModal = ref(false);
      const errorMessage = ref('');
      const showSuccessModal = ref(false);
      const successMessage = ref('Pendaftaran Akun Anda Berhasil');


      const handleRegister = async () => {
      try {
        console.log('Register attempted with:', form.value);
        // Menggunakan axios untuk POST request
        const response = await axios.post('/register', form.value);
        console.log('Register successful:', response.data);
        // Jika login berhasil, tampilkan modal sukses
        showSuccessModal.value = true;
        showModal.value = false;
        document.location.href = '/login';

      } catch (error) {
        if (error.response && error.response.data.errors) {
          // Capture error message dan tampilkan modal error
          errorMessage.value = error.response.data.errors.email[0]; // Assuming error is related to email
          showModal.value = true;
        } else {
          console.error('An unexpected error occurred:', error);
        }
      }
    };
      const closeModal = () => {
        showModal.value = false;
      };
      const closeSuccessModal = () => {
        showSuccessModal.value = false;
        document.location.href = '/login';
      };
      return {
        form,
        errors,
        showPassword,
        showConfirmPassword,
        handleRegister,
        showModal,
        errorMessage,
        showSuccessModal,
        successMessage,
        closeModal,
        closeSuccessModal
      };
    },
  };
  </script>
  
  <style scoped>

  </style>
  