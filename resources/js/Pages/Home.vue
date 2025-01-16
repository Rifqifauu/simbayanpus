<template>
  <!-- Hero Section -->
  <section class="bg-cover bg-center h-96" style="background-image: url('https://i.ytimg.com/vi/u8F9u7ntfTQ/maxresdefault.jpg')" data-aos="fade-up">
    <div class="bg-black bg-opacity-50 h-full flex flex-col justify-center items-center text-center text-white">
      <h2 class="text-3xl font-bold lg:text-4xl" data-aos="fade-up" data-aos-delay="100">Selamat Datang di Website Magang Balai Yanpus DPAD DIY</h2>
      <p class="mt-4 text-lg" data-aos="fade-up" data-aos-delay="200">Portal resmi bagi calon pemagang yang ingin mendaftar di Balai Layanan Perpustakaan DPAD DIY</p>
      <button @click='gotopengajuan'class="mt-6 bg-red-600 px-6 py-3 rounded hover:bg-red-700 transition transform hover:scale-105 animate-bounce" data-aos="fade-up" data-aos-delay="300">Daftar Sekarang</button>
    </div>
  </section>

  <!-- About Section -->
  <section class="container mx-auto py-16 px-6 md:px-16 lg:px-24" data-aos="fade-up">
    <h3 class="text-2xl lg:text-3xl font-bold text-center mb-10" data-aos="fade-up">Tentang Balai Layanan Perpustakaan DPAD DIY</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
      <img src="https://sippn.menpan.go.id/images/article/large/banner-ruang-sekretariat-balai-yanpus-sisi-timur.jpg" alt="About" class="rounded-lg shadow-md w-full h-86 object-cover" data-aos="slide-right">
      <div data-aos="slide-left">
        <p class="text-justify text-gray-700 leading-relaxed">
          Sejarah terbentuknya Balai Layanan Perpustakaan tidak dapat dipisahkan dengan peresmian gedung Grhatama Pustaka oleh Gubernur DIY Sultan Hamengku Buwono X pada Senin wage, 21 Desember 2015. Grhatama Pustaka merupakan nama Gedung layanan perpustakaan milik Pemerintah Daerah Daerah Istimewa Yogyakarta. Nama tersebut diberikan langsung oleh Gubernur DIY untuk perpustakaan yang beralamat di Jalan Janti Banguntapan Bantul. Gedung layanan perpustakaan ini merupakan perpaduan konsep modern dan tradisional. Kemegahan dan berbagai fasilitas mengakomodir kebutuhan masyarakat modern akan kemudahan dan kenyamanan. Terdiri dari 3 lantai Grhatama Pustaka menjadi destinasi rekreatif edukatif bagi masyarakat DIY dan sekitarnya.        </p>
      </div>
    </div>
  </section>

  <!-- Benefits Section -->
  <section class="bg-yellow-50 py-16 px-6" data-aos="fade-up">
    <h3 class="text-2xl lg:text-3xl font-bold text-center mb-10" data-aos="fade-up">Keuntungan Magang di Balai Yanpus DPAD DIY</h3>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-red-600 p-8 rounded-lg shadow-md text-center" data-aos="zoom-in" data-aos-delay="100">
        <svg class="mx-auto mb-4 w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825l6.126-6.126a3 3 0 10-4.243-4.243l-1.415 1.414a1.5 1.5 0 01-2.121 0l-1.415-1.414a3 3 0 00-4.243 4.243l6.126 6.126a1.5 1.5 0 002.121 0z" />
        </svg>
        <h4 class="text-white text-lg font-bold mb-4">Pengembangan</h4>
        <p class="text-white">Kesempatan untuk mengasah keterampilan profesional melalui pengalaman langsung di bidang perpustakaan dan manajemen informasi.</p>
      </div>
      <div class="bg-red-600 p-8 rounded-lg shadow-md text-center" data-aos="zoom-in" data-aos-delay="200">
        <svg class="mx-auto mb-4 w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v18m9-9H3" />
        </svg>
        <h4 class="text-white text-lg font-bold mb-4">Pengalaman</h4>
        <p class="text-white">Ikut terlibat dalam operasional harian yang mendukung peningkatan literasi masyarakat.</p>
      </div>
      <div class="bg-red-600 p-8 rounded-lg shadow-md text-center" data-aos="zoom-in" data-aos-delay="300">
        <svg class="mx-auto mb-4 w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a4 4 0 00-8 0v2m1 4h6m4 4H5a2 2 0 01-2-2V9a2 2 0 012-2h14a2 2 0 012 2v6a2 2 0 01-2 2z" />
        </svg>
        <h4 class="text-white text-lg font-bold mb-4">Relasi</h4>
        <p class="text-white">Bangun jaringan profesional dengan pegawai perpustakaan dan peserta magang lainnya.</p>
      </div>
    </div>
  </section>

   <!-- Requirements Section -->
<section class="py-10 bg-red-500">
  <div class="container mx-auto px-2">
    <h2 class="text-3xl font-bold text-center mb-12 text-white">
      Apa saja persyaratan yang harus dipenuhi untuk magang<br />
      di Balai Yanpus DPAD DIY?
    </h2>
    <div class="max-w-3xl mx-auto space-y-4">
      <div class="bg-white rounded-lg p-4 shadow" data-aos="fade-up" data-aos-delay="100">
        <div class="flex items-center">
          <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-4">1</span>
          <p>Pengajuan magang dengan mengajukan surat izin magang atau surat permohonan magang.</p>
        </div>
      </div>
      <div class="bg-white rounded-lg p-4 shadow" data-aos="fade-up" data-aos-delay="200">
        <div class="flex items-center">
          <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-4">2</span>
          <p>Pengajuan setidaknya 14 hari sebelum periode magang berlangsung.</p>
        </div>
      </div>
      <div class="bg-white rounded-lg p-4 shadow" data-aos="fade-up" data-aos-delay="300">
        <div class="flex items-center">
          <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-4">3</span>
          <p>Pengajuan dilampiri dengan draft proposal magang.</p>
        </div>
      </div>
      <div class="bg-white rounded-lg p-4 shadow" data-aos="fade-up" data-aos-delay="400">
        <div class="flex items-center">
          <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center mr-4">4</span>
          <p>Pengajuan akan diproses berdasarkan ketersediaan kuota magang yang ditentukan oleh Balai Layanan Perpustakaan.</p>
        </div>
      </div>
      <!-- Additional requirement items -->
    </div>
  </div>
</section>


  <!-- Locations Section -->
  <section class="bg-gray-100 py-16 px-6" data-aos="fade-up">
    <h3 class="text-2xl lg:text-3xl font-bold text-center mb-10">Lokasi Magang</h3>
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">
      <div class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg transition duration-300" data-aos="fade-up">
        <img src="https://www.ha-fizh.com/wp-content/uploads/2018/07/grhtm-fzh.jpg" alt="Grhatama Pustaka" class="rounded mb-4 w-full h-48 object-cover">
        <h4 class="font-bold">Grhatama Pustaka</h4>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="100">
        <img src="https://www.bulaksumurugm.com/wp-content/uploads/2018/04/6.-Bijog2_Rahma-1620x1080.jpg" alt="Jogja Library Center" class="rounded mb-4 w-full h-48 object-cover">
        <h4 class="font-bold">Jogja Library Center</h4>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="200">
        <img src="https://dpad.jogjaprov.go.id/public/article/845/1452812532_845.jpg" alt="Rumah Belajar Modern" class="rounded mb-4 w-full h-48 object-cover">
        <h4 class="font-bold">Rumah Belajar Modern</h4>
      </div>
      <div class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg transition duration-300" data-aos="fade-up" data-aos-delay="300">
        <img src="https://www.infopublik.id/resources/album/pelayanan-publik/1_antarafoto-perpustakaan-keliling-monika-di-yogyakrta-140723-afa-3.jpg" alt="Perpustakaan Keliling" class="rounded mb-4 w-full h-48 object-cover">
        <h4 class="font-bold">Perpustakaan Keliling</h4>
      </div>
    </div>
  </section>
</template>

<script>
import AOS from 'aos';
import 'aos/dist/aos.css';
import AppLayout from '../layouts/AppLayout.vue';

export default {
  methods:{
    gotopengajuan(){
      window.location.href='/permohonan/create'
    }
  },
  props: {
    title: String,
  },
  mounted() {
    document.title = this.title;
    AOS.init({
      duration: 1000, // Durasi animasi
      easing: 'ease-in-out', // Jenis easing
      once: true, // Animasi hanya terjadi sekali
    });
  },
  layout: AppLayout,
  data() {
    return {
      status: this.$page.props.flash?.status || null,
    };
  },
};
</script>

<style scoped>
/* Animasi Fade-in saat elemen muncul di viewport */
@keyframes fadeIn {
  from { opacity: 0; }
  to { opacity: 1; }
}
@keyframes fadeInDelay {
  from { opacity: 0; }
  50% { opacity: 0; }
  to { opacity: 1; }
}
@keyframes bounce {
  0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
  40% { transform: translateY(-10px); }
  60% { transform: translateY(-5px); }
}
@keyframes slideInLeft {
  from { transform: translateX(-100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}
@keyframes slideInRight {
  from { transform: translateX(100%); opacity: 0; }
  to { transform: translateX(0); opacity: 1; }
}
@keyframes zoomIn {
  from { transform: scale(0.5); opacity: 0; }
  to { transform: scale(1); opacity: 1; }
}

.animate-fade-in {
  animation: fadeIn 1s ease-in-out;
}
.animate-fade-in-delay {
  animation: fadeInDelay 1.5s ease-in-out;
}
.animate-bounce {
  animation: bounce 1s infinite;
}
.animate-slide-in-left {
  animation: slideInLeft 1s ease-in-out;
}
.animate-slide-in-right {
  animation: slideInRight 1s ease-in-out;
}
.animate-zoom-in {
  animation: zoomIn 1s ease-in-out;
}

/* Image Standardization */
img {
  object-fit: cover;

  width: 100%;
}

/* Hover Effects */
img:hover {
  transform: scale(1.05);
  transition: transform 0.3s ease-in-out;
}
</style>
