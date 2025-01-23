<template>
  <div class="h-screen flex">
    <!-- Left side with illustration, hidden on mobile -->
    <div 
      class="w-1/2 bg-red-700 p-14 relative hidden md:block inset-0 bg-gradient-to-l from-red-700 to-red-800 transition-opacity duration-500 ease-in-out" 
      style="border-top-right-radius: 2rem; border-bottom-right-radius: 2rem;" 
      data-aos="fade-right" 
      data-aos-duration="1000">
      <h1 class="text-4xl w-[30rem] font-bold text-white mb-4">
        Ayo Mulai Magang Sekarang!
      </h1>
      <p class="text-lg text-white mb-10">Anda Perlu Masuk untuk mendaftar magang dan mengakses semua fitur</p>
      <div class="relative">
        <img
        src="/storage/login.svg"
        alt="Person standing in front of door"
        class="w-100"
        />
      </div>
    </div>

    <!-- Right side with login form -->
    <div class="w-full md:w-1/2 p-8 flex flex-col justify-between" data-aos="fade-left" data-aos-duration="1000">
      <div class="flex justify-between mb-6">
        <img
        src="/storage/bayanpus.svg"
          alt="Balai Yanpus DPAD DIY"
          class="h-8"
        />
        <div class="mt-4 text-center">
    <a href="/" class="inline-flex items-center gap-2 px-4 py-2 bg-red-800 text-white rounded-full hover:bg-white hover:text-red-800 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5">
            <path d="m12 19-7-7 7-7"/>
            <path d="M19 12H5"/>
        </svg>
        Kembali
    </a>
</div>
      </div>

      <div class="max-w-md w-full mx-auto">
        <h2 class="text-3xl font-bold mb-4 text-red-700">Masuk</h2>
        <p class="text-gray-600 mb-6">
          Silakan masukkan alamat email dan kata sandi sesuai dengan data saat pendaftaran.
        </p>

        <form @submit.prevent="handleLogin">
          <div class="space-y-4">
            <div>
              <input
                type="email"
                v-model="form.email"
                placeholder="Masukkan Email Anda"
                class="w-full px-4 py-3 rounded-full border border-gray-300 focus:ring-2 focus:ring-red-700 focus:border-red-700"
              />
            </div>

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
                class="absolute right-4 top-1/2 transform -translate-y-1/2"
              >
                <i class="text-gray-400">👁</i>
              </button>
            </div>

            <div class="flex items-center">
              <input
                type="checkbox"
                v-model="form.remember"
                id="remember"
                class="rounded border-gray-300 text-red-700 focus:ring-red-700"
              />
              <label for="remember" class="ml-2 text-gray-600">
                Ingat Saya
              </label>
            </div>

            <button
              type="submit"
              class="w-full bg-red-700 text-white py-3 rounded-full hover:bg-red-800 transition-colors"
            >
              Masuk
            </button>
          </div>
        </form>

        <div class="mt-4 text-center space-y-2">
          <p class="text-gray-600">
            Belum Punya Akun? 
            <a href="/register" class="text-red-700 hover:underline">Daftar Sekarang</a>
          </p>
        </div>
      </div>
    </div>

    <!-- Modal for Error Messages -->
    <div v-if="showModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex justify-center items-center z-50">
      <div class="bg-white p-6 rounded-lg shadow-lg w-80">
        <div class="flex justify-between items-center">
          <h3 class="text-xl font-semibold text-red-700">Gagal Masuk!</h3>
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
        <h3 class="text-2xl font-semibold text-green-700">Anda Berhasil Masuk</h3>
      </div>
      <div class="mt-6 text-center">
        <img src="../../../storage/asset/berhasil.gif" alt="Success Illustration" class="mx-auto mb-50 w-40 h-50">
        <p class="text-gray-800">{{ successMessage }}</p>
      </div>
      </div>
    </div>
</div>
</template>

<script>
import { ref, onMounted } from 'vue'
import AOS from 'aos'
import axios from 'axios';
import 'aos/dist/aos.css'

export default {
  setup() {
    const form = ref({
      email: '',
      password: '',
      remember: false
    });
    const showPassword = ref(false);
    const showModal = ref(false);
    const errorMessage = ref('');
    const showSuccessModal = ref(false);
    const successMessage = ref('');

    const handleLogin = async () => {
      try {
        console.log('Login attempted with:', form.value);
        // Menggunakan axios untuk POST request
        const response = await axios.post('/login', form.value);
        console.log('Login successful:', response.data);
        // Jika login berhasil, tampilkan modal sukses
        showSuccessModal.value = true;
        showModal.value = false;
        document.location.href = '/home';
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
      document.location.href = '/home';
    };

    onMounted(() => {
      AOS.init(); // Initialize AOS (Animate on Scroll)
      document.title = "Login"; // Set dynamic title
    });

    return {
      form,
      showPassword,
      showModal,
      errorMessage,
      showSuccessModal,
      successMessage,
      handleLogin,
      closeModal,
      closeSuccessModal
    };
  }
};
</script>

<style scoped>
/* Additional custom styles */
</style>
