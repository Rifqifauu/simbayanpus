<template>
    <div class="container mx-auto px-8 py-8" style="max-width: 210mm;">
      <div ref="pdfContent" class="bg-white shadow-md p-12 px-20 text-sm" style="min-height: 297mm;">
        <!-- Header -->
        <div class="text-center mb-6">
          <h2 class="font-bold text-lg leading-loose tracking-wide mb-10">
            Surat Pernyataan Kesanggupan Mengikuti Magang <br> di Balai Layanan Perpustakaan DPAD DIY
          </h2>
        </div>
  
        <!-- Opening -->
        <p class="mb-4 leading-loose">Yang bertanda tangan di bawah ini:</p>
  
       <!-- Personal Information -->
       <div class="space-y-4 mb-12 ml-8">
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Nama Lengkap</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ user.name }}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Nama Panggilan</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{userDetail.panggilan}}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Jenis Kelamin</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ userDetail.jenis_kelamin }}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">NIS/NIM/NIP</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">H1D022074</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Asal</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ userDetail.program_studi }} , {{ userDetail.institusi }}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Nomor HP</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ userDetail.nomor_hp }}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Alamat (KTP)</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ userDetail.alamat }}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Alamat (Domisili)</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ userDetail.domisili }}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Agama</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ userDetail.agama }}</div>
          </div>
          <div class="grid grid-cols-12 gap-4 leading-relaxed">
            <div class="col-span-4">Media Sosial</div>
            <div class="col-span-1">:</div>
            <div class="col-span-7">{{ userDetail.medsos }}</div>
          </div>
        </div>
  
        <!-- Statement -->
        <div class="mb-12 leading-loose text-justify">
          <p class="mb-6">
            Dengan ini menyatakan kesanggupan dan bersedia mengikuti kegiatan Magang yang
            ditetapkan oleh Balai Layanan Perpustakaan DPAD DIY sesuai dengan Tata Tertib yang berlaku, selama
            30 hari, mulai tanggal <b>{{ formatDate(permohonan.tgl_masuk) }}</b> sampai dengan tanggal <b>{{ formatDate(permohonan.tgl_keluar) }}</b>.
          </p>
  
          <p class="">
            Demikian surat pernyataan ini saya buat untuk dapat dipergunakan sebagaimana mestinya.
          </p>
        </div>
  
        <!-- Signature -->
        <div class="text-right mt-12 leading-loose">
          <p class="">Yogyakarta, {{formatDate(today)}}</p>
          <div class="h-20"></div>
          <p class="font-bold">{{ user.name }}</p>
        </div>
      </div>
  
      <!-- Button Export PDF -->
      <div class="text-center mt-6">
        <button @click="exportToPDF" class="bg-blue-500 text-white px-4 py-2 rounded-md shadow-md">
          Export ke PDF
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import { jsPDF } from "jspdf";
  import html2canvas from "html2canvas";
  import AppLayout from "@/Layouts/AppLayout.vue";
  
  export default {
    props: {
      user: Object,
      userDetail: Object,
      permohonan: Object
    },
    layout: AppLayout,
    data() {
      return {
        today: new Date().toISOString().split('T')[0]
      };
    },
    methods: {
      async exportToPDF() {
        const element = this.$refs.pdfContent;
        
        // Optimized html2canvas settings
        const canvas = await html2canvas(element, {
          scale: 1.5,
          useCORS: true,
          logging: false,
          imageTimeout: 0,
          removeContainer: true,
          backgroundColor: '#ffffff'
        });
        
        // Compress the image data
        const imgData = canvas.toDataURL("image/jpeg", 0.8); // Using JPEG instead of PNG with 0.8 quality
        
        // Create PDF with compression
        const pdf = new jsPDF({
          orientation: "portrait",
          unit: "mm",
          format: "a4",
          compress: true
        });
        
        const imgWidth = 210; // A4 width
        const pageHeight = 297; // A4 height
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        
        // Add image with compression
        pdf.addImage(imgData, "JPEG", 0, 0, imgWidth, imgHeight, undefined, 'FAST');
        
        // Save with optimized settings
        pdf.save("Surat_Pernyataan.pdf");
      },
      formatDate(dateString) {
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        const date = new Date(dateString);
        return `${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
      }
    }
  };
  </script>