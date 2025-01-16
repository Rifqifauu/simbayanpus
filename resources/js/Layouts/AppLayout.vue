<template>
  <div class="min-h-screen flex flex-col">
    <header>
      <nav class="bg-red-600 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex justify-between items-center h-16">
  <!-- Logo/Brand -->
  <div class="flex-shrink-0 p-2">
  <a href="storage/logo-balaiyanpus.svg" class="text-white text-lg font-bold hover:text-gray-200 transition">
    <img src="storage/logo-balaiyanpus.svg" alt="Logo" class="w-14 h-auto">
  </a>
</div>

</div>
            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8 ml-auto pe-4">
              <button @click="home" class="text-white hover:text-gray-200 transition px-3 py-2">
                Beranda
              </button>
              <button @click="divisi" class="text-white hover:text-gray-200 transition px-3 py-2">
                Divisi
              </button>
              <button v-if="user" @click="permohonan" class="text-white hover:text-gray-200 transition px-3 py-2">
                Permohonan
              </button>
              <button @click="kontak" class="text-white hover:text-gray-200 transition px-3 py-2">
                Kontak
              </button>
            </div>

            <!-- User Menu (Desktop) -->
            <div class="hidden lg:flex items-center relative">
              <div v-if="!user" class="relative">
                <button 
                  @click="login"
                  class="bg-red-700 px-6 py-2 rounded-full text-white border-2 border-white hover:bg-red-800 transition"
                >
                  Login
                </button>
              </div>

              <div v-else class="relative">
                <button 
                  @click="toggleDropdown"
                  class="flex items-center space-x-2 bg-red-700 px-4 py-2 rounded-full text-white border-2 border-white hover:bg-red-800 transition"
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
                class="text-white hover:text-gray-200 focus:outline-none"
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
                  class="block w-full text-left px-3 py-2 text-white hover:bg-red-700 rounded-md"
                >
                  Beranda
                </button>
                <button
                  @click="divisi"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-red-700 rounded-md"
                >
                  Divisi
                </button>
                <button
                  v-if="user"
                  @click="permohonan"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-red-700 rounded-md"
                >
                  Permohonan
                </button>
                <button
                  @click="kontak"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-red-700 rounded-md"
                >
                  Kontak
                </button>
                <template v-if="user">
                  <button
                    @click="profile"
                    class="block w-full text-left px-3 py-2 text-white hover:bg-red-700 rounded-md"
                  >
                    Profile
                  </button>
                  <button
                    @click="logout"
                    class="block w-full text-left px-3 py-2 text-white hover:bg-red-700 rounded-md"
                  >
                    Logout
                  </button>
                </template>
                <button
                  v-else
                  @click="login"
                  class="block w-full text-left px-3 py-2 text-white hover:bg-red-700 rounded-md"
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

    <footer class="bg-orange-100 py-8 px-4 md:px-8">
      <div class="max-w-6xl mx-auto flex flex-col md:flex-row justify-between">
        <div class="mb-6 md:mb-0">
          <div class="flex items-center gap-4">
            <img src="/placeholder-logo.png" alt="Balai Logo" class="w-12 h-12 rounded-full" />
            <h2 class="text-red-600 font-medium">Balai Layanan Perpustakaan DPAD DIY</h2>
          </div>
          <div class="flex gap-4 mt-4">
            <!-- Social Media Icons here -->
          </div>
        </div>

        <div class="mb-6 md:mb-0">
          <h3 class="text-red-600 font-medium mb-4">Tautan Cepat</h3>
          <ul class="space-y-2">
            <li><a href="#" class="text-red-600 hover:text-red-800">Beranda</a></li>
            <li><a href="#" class="text-red-600 hover:text-red-800">Divisi</a></li>
            <li><a href="#" class="text-red-600 hover:text-red-800">Permohonan</a></li>
            <li><a href="#" class="text-red-600 hover:text-red-800">Kontak</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-red-600 font-medium mb-4">Hubungi Kami</h3>
          <ul class="space-y-2">
            <li class="text-red-600">Telp. (0274) 4536234;</li>
            <li><a href="#" class="text-red-600">www.balaiperpus.jogjaprov.go.id</a></li>
            <li class="text-red-600">
              @Hatama Pustaka, Jalan Raya Janti,<br />
              Banguntapan, Bantul, DIY
            </li>
          </ul>
        </div>
      </div>
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