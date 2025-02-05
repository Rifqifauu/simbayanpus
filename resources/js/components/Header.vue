<template>
    <header>
      <nav class="bg-gradient-to-r from-red-600 to-red-800 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <!-- Rest of the navigation structure remains the same until the modal -->
          <div class="flex justify-between items-center h-16">
            <!-- Logo/Brand -->
            <div class="flex justify-between items-center h-16">
              <div class="flex-shrink-0 p-2">
                <a href="../../../storage/asset/logo-removebg-preview.png" class="text-white text-lg font-bold hover:text-gray-200 transition">
                  <img src="../../../storage/asset/logo-removebg-preview.png" alt="Logo" class="w-14 h-auto">
                </a>
              </div>
            </div>
  
            <!-- Desktop Navigation -->
            <div class="relative hidden lg:flex lg:items-center lg:space-x-8 ml-auto pe-4">
              <a href="/home" class="text-lg text-white hover:text-gray-200 transition px-3 py-2">
                Beranda
              </a>
              <a href="/divisi" class="text-lg text-white hover:text-gray-200 transition px-3 py-2">
                Penugasan
              </a>
              <a v-if="user" href="/permohonan" class="text-lg text-white hover:text-gray-200 transition px-3 py-2">
                Permohonan
              </a>
              <a href="/kontak" class="text-white text-lg hover:text-gray-200 transition px-3 py-2">
                Kontak
              </a>
            <a href="https://drive.google.com/file/d/1lcD5gla1hGP0cl3CGGxYt1nZms-3fZ6C/view?pli=1" class="text-white text-lg hover:text-gray-200 transition px-3 py-2 relative group" target="_blank">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="currentColor" class="text-white">
    <path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.9 2 1.99 2h12c1.1 0 1.99-.9 1.99-2V8l-6-6zm0 2v6h6l-6-6z"/>
  </svg>
  <span class="absolute left-1/2 transform -translate-x-1/2 translate-y-6 opacity-0 group-hover:opacity-100 text-sm text-white bg-red-800 p-1 rounded transition-opacity z-10">Pedoman Magang</span>
</a>



<a v-if="user" href="/pesan" class="text-white text-lg hover:text-gray-200 transition px-3 py-2 relative group">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
    <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
    <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
  </svg>
  <span class="absolute left-1/2 transform -translate-x-1/2 translate-y-6 opacity-0 group-hover:opacity-100 text-sm text-white bg-red-00 p-1 rounded transition-opacity z-10">Pesan</span>
</a>
            </div>
  
            <!-- User Menu (Desktop) -->
            <div class="hidden lg:flex items-center relative">
              <div v-if="!user" class="relative">
                <a 
                  href="/login"     
                  class="relative overflow-hidden text-lg px-6 py-2 rounded-xl text-white 
                  group transition-all duration-500 ease-in-out hover:scale-105 hover:shadow-lg transform hover:border-red-400">
                  <div class="absolute inset-0 bg-gradient-to-r from-red-800 to-red-600 transition-opacity duration-500 ease-in-out"></div>
                  <div class="absolute inset-0 bg-gradient-to-l from-red-800 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-500 ease-in-out"></div>
                  <span class="relative">Masuk</span>
              </a>
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
                  class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-30"
                >
                  <a
                    href="/profile"
                    class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100"
                  >
                    Profile
              </a>
                  <button
                    @click="showLogoutConfirm"
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
  <div v-show="menuOpen" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-start pt-10">
    <div class="relative w-11/12 max-w-sm bg-red-800 text-white rounded-lg shadow-lg">
      <!-- Tombol Close -->
      <button 
        @click="toggleMenu" 
        class="absolute top-2 right-2 text-white hover:text-gray-300 transition"
        aria-label="Close menu"
      >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
          <path fill-rule="evenodd" d="M6.707 6.707a1 1 0 010-1.414L11.293 1 6.707 6.707zM17.293 17.293a1 1 0 01-1.414 0L12 13.414l-3.879 3.879a1 1 0 11-1.414-1.414L10.586 12 6.707 8.121a1 1 0 011.414-1.414L12 10.586l3.879-3.879a1 1 0 011.414 1.414L13.414 12l3.879 3.879a1 1 0 010 1.414z" clip-rule="evenodd" />
        </svg>
      </button>

      <div class="px-4 pt-10 pb-3 justify space-y-2">
        <a
          href="/home"
          class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
        >
          Beranda
      </a>
        <a
          href="/divisi"
          class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
        >
          Penugasan
    </a>
        <a
          v-if="user"
          href="/permohonan"
          class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
        >
          Permohonan
  </a>
        <a
          href="/kontak"
          class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
        >
          Kontak
</a>
        <a v-if="user"
          href="/pesan"
          class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
        >
          Pesan
</a>
        <template v-if="user">
          <a
            href="/profile"
            class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
          >
            Profile
        </a>
          <button
            @click="showLogoutConfirm"
            class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
          >
            Logout
          </button>
        </template>
        <a
          v-else
          href="/login"
          class="block w-full text-left px-3 py-2 hover:bg-red-700 rounded-md"
        >
          Login
      </a>
      </div>
    </div>
  </div>
</transition>

        </div>
      </nav>
  
      <!-- Logout Confirmation Modal -->
      <ConfirmModal
        v-if="showLogoutModal"
        :show="showLogoutModal"
        title="Konfirmasi Logout"
        message="Apakah Anda yakin ingin keluar dari aplikasi?"
        @confirm="handleLogout"
@close="showLogoutModal = false"
        />
    </header>
  </template>
  
  <script>
  import { ref } from 'vue';
  import axios from 'axios';
  import ConfirmModal from './ConfirmModal.vue';
  
  export default {
    name: 'Header',
    components: {
      ConfirmModal
    },
    props: {
      user: {
        type: Object,
        default: null
      }
    },
    setup() {
      const dropdownOpen = ref(false);
      const menuOpen = ref(false);
      const showLogoutModal = ref(false);
      const dropdownTimeout = ref(null);
  
      return {
        dropdownOpen,
        menuOpen,
        showLogoutModal,
        dropdownTimeout
      };
    },
    methods: {
      showLogoutConfirm() {
        this.showLogoutModal = true;
        this.dropdownOpen = false;
        this.menuOpen = false; 
      },
      async handleLogout() {
        try {
          await axios.post('/logout');
          window.location.href = '/login';
        } catch (error) {
          console.error('Logout failed:', error);
        }
      },
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
      }
    },
    created() {
      document.addEventListener('click', this.handleClickOutside);
    },
    beforeDestroy() {
      document.removeEventListener('click', this.handleClickOutside);
    }
  };
  </script>
  
  <style scoped>
  .dropdown-menu {
    z-index: 50;
  }
  
  .transition {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 150ms;
  }
  
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