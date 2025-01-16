<template>
  <div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden">
      <!-- Form Header -->
      <div class="bg-green-600 text-white flex justify-between items-center p-4 rounded-2xl">
        <h2 class="text-lg font-semibold">Create Profile</h2>
        <button
          @click="handleSubmit"
          class="flex items-center bg-white text-green-600 px-4 py-2 rounded-lg hover:bg-gray-100 transition-colors"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
          Buat
        </button>
      </div>

      <form @submit.prevent="handleSubmit" class="md:flex">
        <!-- Sidebar -->
        <aside class="md:w-2/5 p-6 bg-gray-50">
          <!-- Profile Photo -->
          <div class="text-center mb-6">
            <div class="w-70 h-60 mx-auto rounded overflow-hidden border-4 border-white shadow-lg relative group">
              <img
                v-if="preview"
                :src="preview"
                alt="Foto Profil"
                class="w-full h-full object-cover"
              />
              <div v-else class="w-full h-full p-8 bg-gray-200 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <label class="cursor-pointer bg-white text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-100">
                  <input
                    type="file"
                    class="hidden"
                    accept="image/*"
                    @change="handleImageChange"
                  >
                  Upload Foto
                </label>
              </div>
            </div>

            <!-- Basic Info -->
            <div class="mt-4 space-y-4">
              <FormInput
                v-model="formData.panggilan"
                label="Nama Panggilan"
                placeholder="Masukkan nama panggilan"
              />
            </div>
          </div>

          <!-- Contact Info -->
          <div class="space-y-4">
            <h2 class="text-xl font-semibold text-green-600">Kontak</h2>
            <FormInput
              v-model="formData.nomor_hp"
              type="tel"
              label="Nomor HP"
              placeholder="Masukkan nomor HP"
            />
            <FormInput
              v-model="formData.medsos"
              label="Media Sosial"
              placeholder="Link media sosial"
            />
          </div>
        </aside>

        <!-- Main Content -->
        <main class="md:w-3/5 p-6">
          <h2 class="text-2xl font-semibold text-green-600 mb-4">Biodata</h2>
          <div class="space-y-4">
            <FormInput
              v-model="formData.nim"
              label="NIM"
              placeholder="Masukkan NIM"
              required
            />
            <FormInput
              v-model="formData.nik"
              label="NIK"
              placeholder="Masukkan NIK"
              required
            />
            <FormInput
              v-model="formData.program_studi"
              label="Program Studi"
              placeholder="Masukkan program studi"
              required
            />
            <FormInput
              v-model="formData.institusi"
              label="Institusi"
              placeholder="Masukkan institusi"
              required
            />
            <FormTextarea
              v-model="formData.alamat"
              label="Alamat"
              placeholder="Masukkan alamat lengkap"
              rows="3"
            />
            <FormSelect
              v-model="formData.jenis_kelamin"
              label="Jenis Kelamin"
              :options="[
                { value: 'Laki-laki', label: 'Laki-laki' },
                { value: 'Perempuan', label: 'Perempuan' }
              ]"
              required
            />
          </div>
        </main>
      </form>
    </div>
  </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

// Form Input Component
const FormInput = defineComponent({
  props: {
    modelValue: String,
    label: String,
    type: {
      type: String,
      default: 'text',
    },
    placeholder: String,
    required: Boolean,
  },
  emits: ['update:modelValue'],
  template: `
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ label }}
        <span v-if="required" class="text-red-500">*</span>
      </label>
      <input
        :type="type"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        :required="required"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
      >
    </div>
  `,
});

// Form Textarea Component
const FormTextarea = defineComponent({
  props: {
    modelValue: String,
    label: String,
    placeholder: String,
    rows: {
      type: [Number, String],
      default: 3,
    },
  },
  emits: ['update:modelValue'],
  template: `
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ label }}
      </label>
      <textarea
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        :rows="rows"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
      ></textarea>
    </div>
  `,
});

// Form Select Component
const FormSelect = defineComponent({
  props: {
    modelValue: String,
    label: String,
    options: Array,
    required: Boolean,
  },
  emits: ['update:modelValue'],
  template: `
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">
        {{ label }}
        <span v-if="required" class="text-red-500">*</span>
      </label>
      <select
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :required="required"
        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500"
      >
        <option value="">Pilih {{ label }}</option>
        <option 
          v-for="option in options" 
          :key="option.value"
          :value="option.value"
        >
          {{ option.label }}
        </option>
      </select>
    </div>
  `,
});


export default {
  name: 'CreateProfile',
  layout: AppLayout,
  components: { FormInput, FormTextarea, FormSelect },
  setup() {
    const formData = ref({
      panggilan: '',
      nomor_hp: '',
      medsos: '',
      nim: '',
      nik: '',
      program_studi: '',
      institusi: '',
      alamat: '',
      jenis_kelamin: '',
      foto: null,
    });

    const preview = ref(null);

    const handleImageChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        preview.value = URL.createObjectURL(file);
        formData.value.foto = file;
      }
    };

    const handleSubmit = () => {
  // Daftar field wajib
  const requiredFields = [
    'panggilan',
    'nomor_hp',
    'nim',
    'nik',
    'program_studi',
    'institusi',
    'jenis_kelamin',
  ];

  // Periksa apakah ada field yang kosong
  const emptyFields = requiredFields.filter((field) => !formData.value[field]);
  if (emptyFields.length > 0) {
    alert(`Harap lengkapi semua field wajib: ${emptyFields.join(', ')}`);
    return;
  }

  // Periksa apakah foto sudah diunggah
  if (!formData.value.foto) {
    alert('Harap unggah foto profil!');
    return;
  }

  try {
    const form = new FormData();
    Object.entries(formData.value).forEach(([key, value]) => {
      if (value !== null && value !== undefined) {
        form.append(key, value);
      }
    });

    router.post('/profile/store', form, {
      onSuccess: () => {
        // Handle success - perhaps show a success message
        console.log('Profile created successfully');
        router.get('/home')     
 },
      onError: (errors) => {
        // Handle validation errors
        console.error('Validation errors:', errors);
      },
    });
  } catch (error) {
    console.error('Error creating profile:', error);
  }
};


    return { formData, preview, handleImageChange, handleSubmit };
  },
};
</script>
