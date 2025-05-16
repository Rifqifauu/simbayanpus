<template>
  <div class="py-8 px-12 text-sm max-w-[650px] mx-auto bg-white" ref="printArea">
    <!-- Judul -->
    <h1 class="text-center text-base font-bold mb-12 uppercase  leading-tight tracking-wide">
      Lampiran Penilaian Pelaksanaan  <br> Kegiatan Magang
    </h1>
<p>Telah dilaksanakan penilaian hasil magang mahasiswa sebagai berikut.</p>
    <!-- Informasi Mahasiswa -->
    <div class="my-6">
      <p class="mb-1 flex"><span class="w-32 font-medium">Nama</span>: {{ user.name }}</p>
      <p class="mb-1 flex"><span class="w-32 font-medium">NIM</span>: {{ userDetail.nim }}</p>
      <p class="mb-1 flex"><span class="w-32 font-medium">Jurusan</span>: {{ userDetail.program_studi }}</p>
    </div>
<p>Setelah menyelesaikan kegiatan magang selama periode yang ditentukan, berikut adalah nilai yang diberikan :</p>
    <!-- Tabel Penilaian -->
    <table class="w-full border border-black text-xs my-6">
      <thead>
        <tr class="bg-gray-100">
          <th class="border border-black px-2 py-2 w-8 text-center">No</th>
          <th class="border border-black px-3 py-2 text-left">Komponen Penilaian</th>
          <th class="border border-black px-2 py-2 w-20 text-center">Nilai</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="border border-black px-2 py-2 text-center">1.</td>
          <td class="border border-black px-3 py-2">Kesesuaian dengan Rencana Kerja</td>
          <td class="border border-black px-2 py-2 text-center">{{ nilai.rencana_kerja }}</td>
        </tr>
        <tr>
          <td class="border border-black px-2 py-2 text-center">2.</td>
          <td class="border border-black px-3 py-2">Kehadiran di lokasi</td>
          <td class="border border-black px-2 py-2 text-center">{{ nilai.kehadiran }}</td>
        </tr>
        <tr>
          <td class="border border-black px-2 py-2 text-center">3.</td>
          <td class="border border-black px-3 py-2">Kedisiplinan, Etika, dan Tingkah Laku</td>
          <td class="border border-black px-2 py-2 text-center">{{ nilai.disiplin_dan_etika }}</td>
        </tr>
        <tr>
          <td class="border border-black px-2 py-2 text-center">4.</td>
          <td class="border border-black px-3 py-2">Keaktifan dan Kreativitas</td>
          <td class="border border-black px-2 py-2 text-center">{{ nilai.keaktifan_kreativitas }}</td>
        </tr>
        <tr>
          <td class="border border-black px-2 py-2 text-center">5.</td>
          <td class="border border-black px-3 py-2">Kecermatan</td>
          <td class="border border-black px-2 py-2 text-center">{{ nilai.kecermatan }}</td>
        </tr>
        <tr>
          <td class="border border-black px-2 py-2 text-center">6.</td>
          <td class="border border-black px-3 py-2">Tanggung Jawab</td>
          <td class="border border-black px-2 py-2 text-center">{{ nilai.tanggung_jawab }}</td>
        </tr>
        <tr>
          <td class="border border-black px-2 py-2 text-center"></td>
          <td class="border border-black px-3 py-2 font-bold">Huruf Mutu</td>
          <td class="border border-black px-2 py-2 text-center font-bold">{{ nilai.huruf_mutu }}</td>
        </tr>
      </tbody>
    </table>

    <!-- Keterangan -->
    <div class="text-xs mb-6 leading-normal border-t border-b border-gray-200 py-3">
      <p class="font-semibold mb-2">Keterangan:</p>
      <div class="grid grid-cols-2 gap-x-4">
        <ul class="list-disc ml-6">
          <li>A. Nilai ≥ 80</li>
          <li>AB. 75 ≤ Nilai &lt; 79,99</li>
          <li>B. 70 ≤ Nilai &lt; 74,99</li>
          <li>BC. 65 ≤ Nilai &lt; 69,99</li>
        </ul>
        <ul class="list-disc ml-6">
          <li>C. 60 ≤ Nilai &lt; 64,99</li>
          <li>CD. 55 ≤ Nilai &lt; 59,99</li>
          <li>D. 46 ≤ Nilai &lt; 54,99</li>
          <li>E. &lt; 46</li>
        </ul>
      </div>
    </div>

  

    <!-- Tanda Tangan -->
    <div class="flex justify-between text-xs mt-8">
      <div>
        <p class="font-medium">Pembimbing Teknis Lapangan:</p>
        <p class="mt-16 font-semibold underline">..........................................</p>
      </div>
      <div class="text-center">
        <p>{{ new Date().toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) }}</p>
        <p class="mt-16">.........</p>
      </div>
    </div>
  </div>
  
  <!-- Tombol Cetak di Tengah -->
  <div class="text-center my-6">
    <button
      @click="printToPDF"
      class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 shadow-sm font-medium"
    >
      Cetak PDF
    </button>
  </div>
</template>

<script>
import { jsPDF } from "jspdf";
import html2canvas from "html2canvas";
import AppLayout from "@/Layouts/AppLayout.vue";

export default {
  layout: AppLayout,
  props: {
    user: Object,
    userDetail: Object,
    nilai: Object,
  },
   mounted(){
      document.title = 'Nilai Magang';
  },
  methods: {
    async printToPDF() {
      const element = this.$refs.printArea;
      
      // Konfigurasi html2canvas untuk kualitas menengah
      const canvas = await html2canvas(element, {
        scale: 1.5, // Meningkatkan sedikit dari sebelumnya untuk kualitas lebih baik
        useCORS: true,
        logging: false, // Nonaktifkan logging untuk performa
        backgroundColor: "#ffffff" // Pastikan background putih
      });

      // Optimasi kualitas JPEG
      const imgData = canvas.toDataURL("image/jpeg", 0.92); // Tingkatkan kualitas kompresi ke 92%
      
      const pdf = new jsPDF("p", "mm", "a4");
      const pageWidth = pdf.internal.pageSize.getWidth();
      const pageHeight = pdf.internal.pageSize.getHeight();
      
      const imgProps = pdf.getImageProperties(imgData);
      const ratio = Math.min(pageWidth / imgProps.width, pageHeight / imgProps.height);
      
      const imgWidth = imgProps.width * ratio;
      const imgHeight = imgProps.height * ratio;
      
      // Posisikan gambar di tengah halaman
      const x = (pageWidth - imgWidth) / 2;
      pdf.addImage(imgData, "JPEG", x, 0, imgWidth, imgHeight);
      
      pdf.save("penilaian-kerja-praktik.pdf");
    },
  },
};
</script>