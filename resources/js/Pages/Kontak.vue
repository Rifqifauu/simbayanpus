<template>
  <div class="contact-page">
    <h1 class="text-center text-3xl font-bold text-red-600 mb-8">{{ title }}</h1>

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
          <h2 class="flex items-center gap-2 text-xl font-semibold mb-2">
            <i class="fas fa-envelope"></i> Email
          </h2>
          <a href="mailto:balaiyanpus@jogjaprov.go.id" class="hover:text-yellow-200 transition-colors">
            balaiyanpus@jogjaprov.go.id
          </a>
        </div>

        <div class="mb-6">
          <h2 class="flex items-center gap-2 text-xl font-semibold mb-2">
            <i class="fab fa-whatsapp"></i> Whatsapp
          </h2>
          <a href="https://wa.me/628812958112" class="hover:text-yellow-200 transition-colors">
            0881-295-8112
          </a>
        </div>

        <div class="mb-6">
          <h2 class="flex items-center gap-2 text-xl font-semibold mb-2">
            <i class="fas fa-phone"></i> Telepon
          </h2>
          <a href="tel:+62744469024" class="hover:text-yellow-200 transition-colors">
            (0274) 4469024
          </a>
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
              class="border-0"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
          </div>
        </div>
      </div>

      <!-- Contact Form Card -->
      <div class="bg-red-600 rounded-lg p-6 text-white">
        <div v-if="!user" class="text-left">
          <form @submit.prevent="submitForm">
          <div class="mb-4">
            <label for="nama" class="block text-xl font-semibold mb-2">Nama</label>
            <input
              id="nama"
              value="Nama Pengguna"
              type="text"
              class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70"
              disabled
            />
          </div>

          <div class="mb-4">
            <label for="email" class="block text-xl font-semibold mb-2">Email</label>
            <input
              id="email"
              value="Email"
              type="email"
              class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70"
              disabled
            />
          </div>

          <div class="mb-6">
            <label for="pesan" class="block text-xl font-semibold mb-2">Tulis Pesan</label>
            <textarea
              id="pesan"
              class="w-full px-4 py-2 rounded-lg bg-white text-gray-900 h-32 placeholder-gray-500"
              placeholder="Silahkan login untuk mengirim pesan..."
              disabled 
            ></textarea>
          </div>

          <button
            type="submit"
            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
          disabled>         Kirim Pesan </button>
        </form>        </div>

        <form v-else @submit.prevent="submitForm">
          <div class="mb-4">
            <label for="nama" class="block text-xl font-semibold mb-2">Nama</label>
            <input
              id="nama"
              :value="user.name"
              type="text"
              class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70"
              disabled
            />
          </div>

          <div class="mb-4">
            <label for="email" class="block text-xl font-semibold mb-2">Email</label>
            <input
              id="email"
              :value="user.email"
              type="email"
              class="w-full px-4 py-2 rounded-lg bg-white/20 text-white placeholder-white/70"
              disabled
            />
          </div>

          <div class="mb-6">
            <label for="pesan" class="block text-xl font-semibold mb-2">Tulis Pesan</label>
            <textarea
              id="pesan"
              v-model="formData.pesan"
              class="w-full px-4 py-2 rounded-lg bg-white text-gray-900 h-32 placeholder-gray-500"
              placeholder="Tulis pesan disini..."
              required
            ></textarea>
          </div>

          <button
            type="submit"
            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-4 rounded-lg transition duration-300 disabled:opacity-50 disabled:cursor-not-allowed"
            :disabled="isSubmitting"
          >
            {{ isSubmitting ? 'Mengirim...' : 'Kirim' }}
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import AppLayout from '../layouts/AppLayout.vue';

export default {
  name: 'ContactPage',
  layout: AppLayout,
  
  props: {
    title: {
      type: String,
      required: true
    },
    user: {
      type: Object,
      default: null
    }
  },

  setup(props) {
    const isSubmitting = ref(false);
    
    const formData = ref({
      pesan: '',
      asal: 'user'
    });

    const redirectToLogin = () => {
      window.location.href = '/login';
    };

    const submitForm = async () => {
      if (!props.user) {
        alert('Anda harus login untuk mengirim pesan.');
        return;
      }

      try {
        isSubmitting.value = true;
        await axios.post('/pesan', {
          ...formData.value,
          id_user: props.user.id
        });
        formData.value.pesan = '';
        alert('Pesan berhasil dikirim!');
      } catch (error) {
        console.error('Error sending message:', error);
        alert('Gagal mengirim pesan. Silakan coba lagi.');
      } finally {
        isSubmitting.value = false;
      }
    };

    return {
      formData,
      isSubmitting,
      submitForm,
      redirectToLogin
    };
  },

  mounted() {
    document.title = this.title;
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

input:disabled,
textarea:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
</style>