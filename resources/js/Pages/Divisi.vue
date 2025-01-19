<template>
    <h3 class="text-center text-3xl font-bold mt-5 text-red-600 mb-6">Daftar Divisi Magang</h3>
    <div class="">
      <!-- Cards Container -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2 p-8">
            <!-- Tim IT -->
            <div  v-for="(item, index) in divisi" :key="index" c class="bg-red-700 text-white p-6 rounded-lg shadow-lg">
                <h4 class="text-xl text-white font-bold mb-4">{{ item.nama_divisi }}</h4>
                <p class="mb-4 text-white">{{ item.keterangan }}</p>
                <p class="font-bold mb-4">Kuota tersedia: {{ item.kuota }}</p>
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


/* Hover effects */
.hover\:bg-red-50:hover {
  background-color: #f8d7da; /* Soft red background on hover */
}
</style>
