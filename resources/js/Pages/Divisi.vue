<template>
    <h3 class="text-center text-3xl font-bold mt-5 text-red-600 mb-6">Daftar Divisi Magang</h3>
    <div class="container mx-auto px-4">
      <!-- Cards Container -->
      <div v-for="(item, index) in divisi" :key="index" class="card max-w-sm mx-auto bg-white rounded-lg shadow-xl overflow-hidden mb-8 transform transition duration-500 hover:scale-105 hover:shadow-2xl hover:bg-red-50">
        <div class="p-6">
          <h2 class="text-2xl font-semibold text-red-700 mb-2">{{ item.nama_divisi }}</h2>
          <p class="text-gray-600 mb-4">{{ item.keterangan }}</p>
          
          <div class="flex justify-between items-center mt-4">
            <span class="text-lg font-medium text-gray-700">Kuota:</span>
            <span class="text-xl font-bold text-red-600">{{ item.kuota }}</span>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import AppLayout from '../layouts/AppLayout.vue';

export default {
  props: {
    title: String,
    divisi: {
      type: Array,
      required: true,
      validator(value) {
        return Array.isArray(value) && value.every(item => item.nama_divisi && item.keterangan && item.kuota);
      },
    },
  },
  layout: AppLayout,
};
</script>

<style scoped>
/* Custom styling for the container */
h3 {
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  color: #e74c3c; /* Red color for the title */
  margin-bottom: 20px;
}

/* Flexbox styling for the card container */
.container {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1.5rem; /* Spacing between cards */
}

.card {
  transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out; /* Smooth transition for animation */
}

.card:hover {
  transform: translateY(-10px); /* Slightly raise the card on hover */
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
  background-color: #f8d7da; /* Light red background on hover */
}

h2 {
  color: #c0392b; /* Darker red for the divisi name */
}

p {
  color: #7f8c8d;
  font-size: 14px;
}

.text-lg {
  font-size: 18px;
}

.text-xl {
  font-size: 22px;
}

/* Flexbox styling for card content */
.flex {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.text-red-600 {
  color: #e74c3c; /* Red color for Kuota */
}

.text-red-700 {
  color: #c0392b; /* Darker red for the divisi name */
}

/* Hover effects */
.hover\:bg-red-50:hover {
  background-color: #f8d7da; /* Soft red background on hover */
}
</style>
