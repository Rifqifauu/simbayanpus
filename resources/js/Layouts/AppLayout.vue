<template>
  <div class="min-h-screen flex flex-col">
    <header>
      <nav class="bg-gradient-to-r from-red-600 to-red-700 text-white ">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex justify-between items-center h-16">
  <!-- Logo/Brand -->
  <div class="flex-shrink-0 p-2">
  <a href="../../../storage/asset/logo-removebg-preview.png" class="text-white text-lg font-bold hover:text-gray-200 transition">
    <img src="../../../storage/asset/logo-removebg-preview.png" alt="Logo" class="w-14 h-auto">
  </a>
</div>

</div>
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8 ml-auto pe-4  ">
              <button @click="home" class="text-lg text-white hover:text-gray-200 transition px-3 py-2">
                Beranda
              </button>
              <button @click="divisi" class="text-lg text-white hover:text-gray-200 transition px-3 py-2">
                Divisi
              </button>
              <button v-if="user" @click="permohonan" class="text-lg text-white hover:text-gray-200 transition px-3 py-2">
                Permohonan
              </button>
              <button @click="kontak" class="text-white text-lg hover:text-gray-200 transition px-3 py-2">
                Kontak
              </button>
              <button v-if="user" @click="pesan" class="text-white text-lg hover:text-gray-200 transition px-3 py-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
  <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
</svg>
              </button>
            </div>

            <!-- User Menu (Desktop) -->
            <div class="hidden lg:flex items-center relative">
              <div v-if="!user" class="relative">
                <button 
    @click="login"     
    class="relative overflow-hidden text-lg px-6 py-2 rounded-xl text-white 
    group transition-all duration-500 ease-in-out hover:scale-105 hover:shadow-lg transform hover:border-red-400">
    <div class="absolute inset-0 bg-gradient-to-r from-red-800 to-red-600 transition-opacity duration-500 ease-in-out"></div>
    <div class="absolute inset-0 bg-gradient-to-l from-red-800 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out"></div>
    <span class="relative">Login</span>
</button>
              </div>

              <div v-else class="relative">
                <button 
                  @click="toggleDropdown"
                  class="flex items-center space-x-2 bg-white px-4 py-2 rounded-full text-red-400 border-white hover:bg-white-800 hover:text-white-600 transition"
                  @blur="closeDropdownDelayed"
                >
                  <span>{{ user.name }}</span>
                  <svg
                    class="w-4 h-4 transition-transform duration-200"
                    :class="{ 'rotate-180': dropdownOpen }"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
                </button>

                <!-- Dropdown Menu -->
                <div 
                  v-show="dropdownOpen"
                  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50"
                >
                  <button
                    @click="profile"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                  >
                    Profile
                  </button>
                  <button
                    @click="logout"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                  >
                    Logout
                  </button>
                </div>
              </div>
            </div>

            <!-- Mobile Menu Button -->
            <div class="lg:hidden">
              <button
                @click="toggleMenu"
                class="text-white-600 hover:text-gray-200 focus:outline-none"
                aria-label="Toggle menu"
              >
                <svg
                  class="h-6 w-6"
                  fill="none"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    v-if="!menuOpen"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"
                  />
                  <path
                    v-else
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18L18 6M6 6l12 12"
                  />
                </svg>
              </button>
            </div>
          </div>

          <!-- Mobile Menu -->
          <transition
            enter-active-class="transition duration-200 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-100 ease-in"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
          >
            <div v-show="menuOpen" class="lg:hidden">
              <div class="px-2 pt-2 pb-3 space-y-1">
                <button
                  @click="home"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-white-700 rounded-md"
                >
                  Beranda
                </button>
                <button
                  @click="divisi"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-white-700 rounded-md"
                >
                  Divisi
                </button>
                <button
                  v-if="user"
                  @click="permohonan"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-white-700 rounded-md"
                >
                  Permohonan
                </button>
                <button
                  @click="kontak"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-white-700 rounded-md"
                >
                  Kontak
                </button>
                <template v-if="user">
                  <button
                    @click="profile"
                    class="block w-full text-left px-3 py-2 text-white-600 hover:bg-white-700 rounded-md"
                  >
                    Profile
                  </button>
                  <button
                    @click="logout"
                    class="block w-full text-left px-3 py-2 text-white-600 hover:bg-white-700 rounded-md"
                  >
                    Logout
                  </button>
                </template>
                <button
                  v-else
                  @click="login"
                  class="block w-full text-left px-3 py-2 text-white-600 hover:bg-white-700 rounded-md"
                >
                  Login
                </button>
              </div>
            </div>
          </transition>
        </div>
      </nav>
    </header>

    <main class="flex-grow">
      <slot></slot>
    </main>

    <footer class="bg-red-50 mt-2">
        <div class="bg-red-700 h-2"></div>
        <div class="pt-8 container mx-auto px-4 flex flex-wrap justify-between items-start bg-red-50">
          <div class="w-full md:w-1/3 text-center md:text-left mb-6 md:mb-0">
            <img src="storage/logo-balaiyanpus.svg" alt="Logo Balai Yanpus" class="w-20 h-20 mx-auto md:mx-0 mb-4">
            <p class="text-red-700 font-bold">Balai Layanan Perpustakaan DPAD DIY</p>
            <div class="flex justify-center md:justify-start mt-4 space-x-4">
              <a href="#" class="text-red-700 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.22 6.22l11.56 11.56m0-11.56L6.22 17.78" />
                </svg>
              </a>
              <a href="#" class="text-red-700 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M24 4.56v14.88c0 2.52-2.048 4.56-4.56 4.56H4.56A4.56 4.56 0 010 19.44V4.56A4.56 4.56 0 014.56 0h14.88A4.56 4.56 0 0124 4.56zM8.64 19.68v-7.2H5.76v7.2h2.88zM7.2 11.76a1.68 1.68 0 100-3.36 1.68 1.68 0 000 3.36zm12.24 7.92v-3.96c0-2.16-2.64-2.52-3.6-2.52-1.92 0-3.12.96-3.12 2.52v3.96h2.88v-3.48c0-.72.48-1.08 1.2-1.08.72 0 1.2.48 1.2 1.08v3.48h2.88z" />
                </svg>
              </a>
              <a href="#" class="text-red-700 hover:text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24">
                  <path d="M22.23 5.924c-.77.344-1.6.578-2.47.684a4.48 4.48 0 001.96-2.484 8.97 8.97 0 01-2.83 1.083 4.47 4.47 0 00-7.6 4.077A12.72 12.72 0 011.64 4.15a4.47 4.47 0 001.38 5.97 4.44 4.44 0 01-2.02-.554v.056a4.47 4.47 0 003.58 4.38 4.48 4.48 0 01-2.02.08 4.47 4.47 0 004.18 3.106 8.95 8.95 0 01-5.53 1.908 9.07 9.07 0 01-1.06-.062 12.69 12.69 0 006.89 2.02c8.28 0 12.81-6.86 12.81-12.81 0-.194-.004-.39-.013-.585A9.18 9.18 0 0024 5.358a8.96 8.96 0 01-2.77.756z" />
                </svg>
              </a>
            </div>
          </div>
      
          <div class="w-full md:w-1/3 text-center md:text-left mb-6 md:mb-0">
            <h4 class="text-red-700 font-bold mb-4">Tautan Cepat</h4>
            <ul class="space-y-2">
              <li><a href="#" class="text-gray-700 hover:text-red-700">Beranda</a></li>
              <li><a href="#" class="text-gray-700 hover:text-red-700">Divisi</a></li>
              <li><a href="#" class="text-gray-700 hover:text-red-700">Permohonan</a></li>
              <li><a href="#" class="text-gray-700 hover:text-red-700">Kontak</a></li>
            </ul>
          </div>
      
          <div class="w-full md:w-1/3 text-center md:text-left">
            <h4 class="text-red-700 font-bold mb-4">Hubungi Kami</h4>
            <ul class="text-gray-700 space-y-2">
              <li>Telp. (0274) 4536234;</li>
              <li><a href="http://www.balaiyanpus.jogjaprov.go.id" class="hover:text-red-700">www.balaiyanpus.jogjaprov.go.id</a></li>
              <li>Grhatama Pustaka, Jalan Raya Janti, Banguntapan, Bantul, DIY</li>
            </ul>
          </div>
        </div>
        <div class="border-t font-medium border-red-1000 mt-8 pt-4 text-center">
    <p class="text-red-600 text-sm">
      &copy; 2025 Balai Layanan Perpustakaan DPAD DIY. Made by IF Unsoed '22.
    </p>
  </div>
        <div class="bg-red-50 py-4"></div>
      </footer>

  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'AppLayout',
  props: {
    user: Object,
  },
  data() {
    return {
      dropdownOpen: false,
      menuOpen: false,
      dropdownTimeout: null,
    };
  },
  created() {
    // Add click outside listener
    document.addEventListener('click', this.handleClickOutside);
  },
  beforeDestroy() {
    // Clean up
    document.removeEventListener('click', this.handleClickOutside);
  },
  methods: {
    toggleDropdown() {
      this.dropdownOpen = !this.dropdownOpen;
    },
    toggleMenu() {
      this.menuOpen = !this.menuOpen;
    },
    closeDropdownDelayed() {
      this.dropdownTimeout = setTimeout(() => {
        this.dropdownOpen = false;
      }, 200);
    },
    handleClickOutside(event) {
      const dropdown = this.$el.querySelector('.dropdown-menu');
      const button = this.$el.querySelector('.user-menu');
      if (dropdown && !dropdown.contains(event.target) && !button.contains(event.target)) {
        this.dropdownOpen = false;
      }
    },
    profile() {
      window.location.href = '/profile';
    },
    home() {
      window.location.href = '/home';
    },
    divisi() {
      window.location.href = '/divisi';
    },
    permohonan() {
      window.location.href = '/permohonan';
    },
    kontak() {
      window.location.href = '/kontak';
    },
    pesan() {
      window.location.href = '/pesan';
    },
    login() {
      window.location.href = '/login';
    },
    async logout() {
      try {
        await axios.post('/logout');
        window.location.href = '/login';
      } catch (error) {
        console.error('Logout failed:', error);
      }
    },
  },
};
</script>

<style scoped>
/* Ensure dropdown menu appears above other content */
.dropdown-menu {
  z-index: 50;
}

/* Smooth transitions for menu items */
.transition {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 150ms;
}

/* Improved mobile menu animation */
.mobile-menu-enter-active,
.mobile-menu-leave-active {
  transition: opacity 0.2s ease, transform 0.2s ease;
}

.mobile-menu-enter-from,
.mobile-menu-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>