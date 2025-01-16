<template>
    <div class="contact-page">
      <h1 class="text-center text-3xl font-bold text-red-600 mb-8">{{ title }}</h1> <!-- Display the title prop -->
  
      <div class="grid md:grid-cols-2 gap-6 max-w-6xl mx-auto px-4">
        <!-- Contact Information Card -->
        <div class="bg-red-600 rounded-lg p-6 text-white">
          <div class="mb-6">
            <h2 class="flex items-center gap-2 text-xl font-semibold mb-2">
              <i class="fas fa-map-marker-alt"></i> Alamat
            </h2>
            <p>Ghatama Pustaka, Jalan Raya Janti, Banguntapan, Bantul, DIY</p>
          </div>
  
          <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Email</h2>
            <p>balaiyanpus@jogjaprov.go.id</p> <!-- Display the email from the user prop -->
          </div>
  
          <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Whatsapp</h2>
            <p>0881-295-8112</p>
          </div>
  
          <div class="mb-6">
            <h2 class="text-xl font-semibold mb-2">Telepon</h2>
            <p>(0274) 4469024</p>
          </div>
  
          <div>
            <h2 class="flex items-center gap-2 text-xl font-semibold mb-2">
              <i class="fas fa-map"></i> Peta
            </h2>
            <div class="rounded-lg overflow-hidden">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7905.805142211918!2d110.409016!3d-7.800138999999999!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5756951cdd8d%3A0x476c4fa152e22651!2sDiorama%20Arsip%20Jogja!5e0!3m2!1sen!2sus!4v1736836306636!5m2!1sen!2sus"
                width="100%"
                height="250"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
              ></iframe>
            </div>
          </div>
        </div>
  
        <!-- Contact Form Card -->
        <div class="bg-red-600 rounded-lg p-6 text-white">
          <form @submit.prevent="submitForm">
            <div class="mb-4">
              <label class="block text-xl font-semibold mb-2">Nama</label>
              <input
                v-model="formData.nama"
                type="text"
                class="w-full px-4 py-2 rounded-lg text-gray-900"
                required
              />
            </div>
  
            <div class="mb-4">
              <label class="block text-xl font-semibold mb-2">Email</label>
              <input
                v-model="formData.email"
                type="email"
                class="w-full px-4 py-2 rounded-lg text-gray-900"
                required
              />
            </div>
  
            <div class="mb-6">
              <label class="block text-xl font-semibold mb-2">Tulis Pesan</label>
              <textarea
                v-model="formData.pesan"
                class="w-full px-4 py-2 rounded-lg text-gray-900 h-32"
                placeholder="Tulis pesan disini..."
                required
              ></textarea>
            </div>
  
            <button
              type="submit"
              class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300"
            >
              Kirim
            </button>
          </form>
        </div>
      </div>
    </div>
  </template>
  
  <script>
import AppLayout from '../layouts/AppLayout.vue';

  export default {
    mounted(){
        document.title = this.title;
    },
    layout: AppLayout,
    props: {
      title: {
        type: String,
        required: true
      },
      user: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        formData: {
          nama: '',
          email: '',
          pesan: ''
        }
      };
    },
    methods: {
      submitForm() {
        // Handle form submission here
        console.log('Form submitted:', this.formData);
        // Reset form after submission
        this.formData = {
          nama: '',
          email: '',
          pesan: ''
        };
      }
    }
  };
  </script>
  
  <style scoped>
  .contact-page {
    padding: 2rem 1rem;
  }
  
  @media (min-width: 768px) {
    .contact-page {
      padding: 3rem 2rem;
    }
  }
  </style>
  