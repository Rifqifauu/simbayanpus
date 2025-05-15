<template>
  <div class="contact-page min-h-screen py-10 px-4">
    <h1 class="text-center text-3xl md:text-4xl font-bold text-red-800 mb-10 drop-shadow-md">
      {{ title }}
    </h1>

    <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto w-full">
      <!-- Kartu Informasi -->
      <div
        class="bg-red-800 p-6 rounded-2xl shadow-xl text-white space-y-6 hover:shadow-red-400 transition"
      >
        <div>
          <h2 class="text-xl font-semibold flex items-center gap-2 mb-2">
            <i class="fas fa-map-marker-alt text-white"></i> Alamat
          </h2>
          <p>
            Jl. Raya Mayjen Sungkono No.KM 5, Dusun 2, Blater, Kec. Kalimanah,
            Kabupaten Purbalingga, Jawa
          </p>
        </div>
        <!-- Email -->
        <div>
          <h2 class="text-xl font-semibold flex items-center gap-2 mb-2">
            <i class="fas fa-envelope text-white"></i> Email
          </h2>
          <a
            href="mailto:rifqi.fauzi@mhs.unsoed.ac.id"
            class="text-white hover:text-yellow-500 font-medium"
            >rifqi.fauzi@mhs.unsoed.ac.id</a
          ><br />
          <a
            href="mailto:ifan.maulana@mhs.unsoed.ac.id"
            class="text-white hover:text-yellow-500 font-medium"
            >ifan.maulana@mhs.unsoed.ac.id</a
          >
        </div>
        <!-- WhatsApp -->
        <div>
          <h2 class="text-xl font-semibold flex items-center gap-2 mb-2">
            <i class="fab fa-whatsapp text-white"></i> Whatsapp
          </h2>
          <a
            href="https://wa.me/6281325243608"
            target="_blank"
            rel="noopener noreferrer"
            class="text-white hover:text-yellow-500 font-medium"
            >+6281325243608</a
          >
          ||
          <a
            href="https://wa.me/6281325243608"
            target="_blank"
            rel="noopener noreferrer"
            class="text-white hover:text-yellow-500 font-medium"
            >+6281325243608</a
          >
        </div>
        <!-- Map -->
        <div>
          <h2 class="text-xl font-semibold flex items-center gap-2 mb-2">
            <i class="fas fa-map text-white"></i> Peta
          </h2>
          <div class="rounded-lg overflow-hidden shadow-lg">
            <iframe
              class="w-full"
              height="200"
              style="border:0;"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63307.59932438935!2d109.24036995260114!3d-7.384688193885435!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6559814ade5b79%3A0xaef1b7bab5cba0f0!2sFaculty%20of%20Engineering%20Unsoed!5e0!3m2!1sen!2sid!4v1747283644258!5m2!1sen!2sid"
            ></iframe>
          </div>
        </div>
      </div>
      <!-- Form Kontak -->
      <div
        class="bg-red-800 p-6 rounded-2xl shadow-xl text-white hover:shadow-red-800 transition"
      >
        <form @submit.prevent="submitForm">
          <!-- Nama -->
          <div class="mb-4">
            <label class="block text-lg font-semibold mb-2">Nama</label>
            <input
              type="text"
              :value="user ? user.name : 'Nama Pengguna'"
              class="w-full px-4 py-2 bg-gray-100 text-red-900 rounded-lg text-sm md:text-base"
              disabled
            />
          </div>
          <!-- Email -->
          <div class="mb-4">
            <label class="block text-lg font-semibold mb-2">Email</label>
            <input
              type="email"
              :value="user ? user.email : 'Email'"
              class="w-full px-4 py-2 bg-gray-100 text-red-900 rounded-lg text-sm md:text-base"
              disabled
            />
          </div>
          <!-- Pesan -->
          <div class="mb-6">
            <label class="block text-lg font-semibold mb-2">Tulis Pesan</label>
            <textarea
              v-model="formData.pesan"
              class="w-full px-4 py-2 bg-gray-100 text-gray-800 h-32 rounded-lg text-sm md:text-base"
              :placeholder="user ? 'Tulis pesan di sini...' : 'Silahkan login terlebih dahulu...'"
              :disabled="!user"
              required
            ></textarea>
          </div>

          <!-- Tombol -->
          <button
            type="submit"
            class="w-full bg-yellow-400 hover:bg-yellow-500 text-white font-bold py-3 px-4 rounded-lg transition duration-300 disabled:opacity-50"
            :disabled="isSubmitting || !user"
          >
            {{ isSubmitting ? 'Mengirim...' : 'Kirim Pesan' }}
          </button>
        </form>
      </div>
    </div>

    <SuccessModal :show="showSuccessModal" title="Pesan Terkirim" />
  </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import AppLayout from "../layouts/AppLayout.vue";
import SuccessModal from "../components/SuccessModal.vue";

export default {
  name: "ContactPage",
  layout: AppLayout,
  components: {
    SuccessModal,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    user: {
      type: Object,
      default: null,
    },
  },

  setup(props) {
    const isSubmitting = ref(false);

    const formData = ref({
      pesan: "",
      asal: "user",
    });
    const showSuccessModal = ref(false);

    const redirectToLogin = () => {
      window.location.href = "/login";
    };

    const submitForm = async () => {
      if (!props.user) {
        alert("Anda harus login untuk mengirim pesan.");
        return;
      }
      try {
        isSubmitting.value = true;
        await axios.post("/pesan", {
          ...formData.value,
          id_user: props.user.id,
        });
        formData.value.pesan = "";
        showSuccessModal.value = true;
        setTimeout(() => {
          document.location.href = "/pesan";
        }, 2000);
      } catch (error) {
        console.error("Error sending message:", error);
        alert("Gagal mengirim pesan. Silakan coba lagi.");
      } finally {
        isSubmitting.value = false;
      }
    };

    return {
      formData,
      isSubmitting,
      submitForm,
      redirectToLogin,
      showSuccessModal,
    };
  },

  mounted() {
    document.title = this.title;
  },
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
