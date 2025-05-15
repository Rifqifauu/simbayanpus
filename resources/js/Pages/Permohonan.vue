<template>
    <div class="status-page">
        <!-- Header with updated styling -->
        <header class="header mt-4">
            <h1 v-if="status !== 'default' && status !== null && status !== 'ditolak' && status !== 'selesai'" class="text-3xl pb-4 sm:text-3xl md:text-4xl font-bold mb-2 text-red-800">Status Permohonan</h1>
            <img v-if="status !== 'default' && status !==null  && status !== 'ditolak' && status !== 'selesai'" :src="currentStatus.image" alt="" class="mx-auto max-w-18 pt-2 h-auto">
        </header>

        <template v-if="status !== 'default'  && status !== 'ditolak' && status !== 'selesai' && status !==null ">
            <!-- Updated Progress Bar -->
            <div class="progress-container" aria-live="polite">
                <div class="progress-bar">
                    <div
                        v-for="(step, index) in steps"
                        :key="step.id"
                        class="progress-step"
                        :class="{
                            active: isActive(step.id),
                            completed: isCompleted(step.id),
                        }"
                        :aria-label="step.label"
                    >
                        <div class="step-indicator">
                            <span
                                v-if="!isCompleted(step.id)"
                                class="step-number"
                                >{{ index + 1 }}</span
                            >
                            <svg
                                v-else
                                class="check-icon"
                                xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M19.916 4.626a.75.75 0 01.208 1.04l-9 13.5a.75.75 0 01-1.154.114l-6-6a.75.75 0 011.06-1.06l5.353 5.353 8.493-12.739a.75.75 0 011.04-.208z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                        </div>
                        <span class="step-label">{{ step.label }}</span>
                        <span class="step-description">{{
                            step.description
                        }}</span>
                    </div>
                </div>
            </div>

            <!-- Status Content with icons and layout -->
            <div class="status-content" :class="status">
                <div class="status-card">
                    <h2 class="status-title">{{ currentStatus.title }}</h2>
                    <p class="status-description">
                        {{ currentStatus.description }}
                    </p>
                    <div class="action-buttons">
                        <div class="flex flex-col md:flex-row gap-2">
                            <a
                            v-if="status === 'diterima'"
                           :href="`/view/sk_diterima`"
                            class="button print-button" target="_blank"
                        >
                            <!-- Print Icon -->
                            <svg
                                class="button-icon"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"
                                />
                            </svg>
                            Surat Keterangan Diterima
                        </a>
                            <a
                            v-if="status === 'diterima'"
                            href="/view/surat-pernyataan"
                            class="button print-button" target="_blank"
                        >
                            <!-- Print Icon -->
                            <svg
                                class="button-icon"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z"
                                />
                            </svg>
                            Surat Pernyataan
                        </a>
                    </div>
                    </div>
                </div>
            </div>
        </template>

        <div v-if="status === 'default' || status === null || status === 'ditolak' || status === 'selesai'" class="">
        <div class="inset-0 bg-black bg-opacity-50"></div>
        <div class="inset-0 overflow-y-auto">
            <div class="w-full px-8 flex min-h-full items-center justify-center text-center">
            <div class="w-full rounded-2xl bg-white p-8 text-left align-middle shadow-2xl transition-all">
                <!-- Gambar -->
                <div class="w-full flex justify-center">
                    <img src="storage/permohonan-exception.jpg" alt="Illustration" class="w-62 h-52 object-contain">
                </div>
                
                <!-- Judul -->
                <h3 class="text-2xl font-semibold text-gray-900 text-center mt-4">
                    {{ getTitle() }}
                </h3>
                
                <!-- Pesan -->
                <div class="mt-4">
                    <p class="text-lg text-gray-600 text-center">
                        {{ getMessage() }}
                    </p>
                </div>
                
                <!-- Tombol -->
                <div class="mt-6 text-center">
                    <button
                        type="button"
                        class="inline-flex justify-center rounded-lg border border-transparent bg-red-600 px-6 py-3 text-lg font-medium text-white hover:bg-red-700 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2"
                        @click="handleAction"
                    >
                        {{ getButtonText() }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import axios from "axios";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import AppLayout from "../layouts/AppLayout.vue";

export default defineComponent({
    mounted() {
    document.title = 'Permohonan';
  },
    name: "StatusPage",

    components: {
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
    },

    layout: AppLayout,

    props: {
        status: {
            type: String,
            required: true,
            validator: (value) =>
                [null,"default", "pending", "diproses", "diterima","ditolak","selesai"].includes(value),
            default: null,
        },
        user: {
            type: Object,
        },
    },

    data() {
        return {
            steps: [
                {
                    id: "pending",
                    label: "Dikirim",
                    description: "Permohonan dikirim",
                },
                {
                    id: "diproses",
                    label: "Diproses",
                    description: "Sedang diproses",
                },
                {
                    id: "diterima",
                    label: "Diterima",
                    description: "Permohonan diterima",
                },
            ],
            statusContent: {
                pending: {
                    image: '/storage/pending.svg',
                    title: "Permohonan Dikirim",
                    description:
                        "Permohonan Anda sedang dikirim ke sistem kami. Apabila dalam 7 hari belum ada perubahan status, silahkan hubungi melalui WhatsApp yang tertera di kontak.",
                },
                diproses: {
                    image: 'storage/diproses.svg',
                    title: "Sedang Diproses",
                    description:
                        "Tim kami sedang memproses permohonan Anda. Kami akan memberikan update secara berkala.",
                },
                diterima: {
                    image: 'storage/diterima.svg',
                    title: "Permohonan diterima",
                    description:
                        "Selamat! Permohonan magang Anda telah diterima. Silakan unduh atau cetak dokumen Anda.",
                },
            },
        };
    },

    computed: {
        currentStatus() {
            return this.statusContent[this.status];
        },
   
    },

    methods: {           
        isActive(step) {
            const steps = this.steps.map((s) => s.id);
            return steps.indexOf(step) <= steps.indexOf(this.status);
        },

        isCompleted(stepId) {
            const steps = this.steps.map((s) => s.id);
            return (
                steps.indexOf(stepId) < steps.indexOf(this.status) ||
                (this.status === "diterima" && stepId === "diterima")
            );
        },
        getTitle() {
            if (this.status === 'default') return 'Belum Ada Permohonan';
            if (this.status === 'ditolak') return 'Permohonan Anda Ditolak';
            if (this.status === 'selesai') return 'Periode Magang Anda Selesai';
            if (this.status === null) return 'Belum Ada Data Profil';
            return '';
        },
        getMessage() {
            if (this.status === 'default') {
                return 'Anda belum mengajukan permohonan apapun. Silakan mulai dengan mengajukan permohonan melalui tombol di bawah ini.';
            }
            if (this.status === 'ditolak') {
                return 'Mohon maaf, permohonan Anda belum bisa kami terima. Silahkan mengecek pesan masuk untuk mengetahui lebih detail. Untuk mengajukan ulang, silahkan klik tombol di bawah ini.';
            }
            if (this.status === null) {
                return 'Anda belum mengisi data profil. Silahkan isi terlebih dahulu.';
            }
            if (this.status === 'selesai') {
                return 'Periode magang Anda telah selesai. Terimakasih atas kerjasamanya selama magang.';
            }
            return '';
        },
        getButtonText() {
            if (this.status === 'default') return 'Buat Permohonan Baru';
            if (this.status === null) return 'Ke halaman profil';
            if (this.status === 'ditolak') return 'Buat Permohonan Ulang';
            if (this.status === 'selesai') return 'Surat Keterangan Selesai';
            return '';
        },
        handleAction() {
            if (this.status === 'default') {
                this.handleNewSubmission();
            } else if (this.status === null) {
                this.profil();
            } else if (this.status === 'ditolak'){
                this.deletePermohonan(this.user.id);
            } else if (this.status === 'selesai'){
                this.suratSelesai(this.user.id)
            }
        },

        handleSupport() {
            this.$emit("support-requested");
        },

        handleUpdate() {
            this.$emit("update-requested");
        },

        handlePrint() {
            this.$emit("print-requested");
        },

        closeModal() {
            // Handle modal close if needed
        },

        handleNewSubmission() {
            window.location.href = "/permohonan/create";
        },
        profil() {
            window.location.href = "/profile";
        },
        suratSelesai(id) {
            window.open(`/view/sk_selesai`, '_blank');
        },
        async deletePermohonan(id) {
    try {
        const response = await axios.delete(`/permohonan/delete/${id}`);

        console.log("Full Response Object:", response); // Debugging lengkap
        console.log("Response Data:", response.data); // Lihat response.data

        // Cek apakah response.data ada sebelum mengaksesnya
        if (response.data.success) {
            window.location.href = '/permohonan/create';
        } else {
            console.error("Response data tidak sesuai:", response);
        }
    } catch (error) {
        console.error("Request Failed:", error);
        if (error.response?.data) {
            console.error("Server Error:", error.response.data);
        } else if (error.request) {
            console.error("No Response from Server:", error.request);
        } else {
            console.error("Error Message:", error.message);
        }
    }
}
    },
});
</script>

<style scoped>
.status-page {
    @apply min-h-screen  py-4 px-4 sm:px-6 lg:px-8;
}

.header {
    @apply max-w-4xl mx-auto text-center mb-12;
}

.title {
    @apply text-4xl font-extrabold text-red-800 mb-2;
}

.subtitle {
    @apply text-lg text-gray-700;
}

.progress-container {
    @apply max-w-4xl mx-auto mb-12;
}

.progress-bar {
    @apply flex justify-between items-center relative;
}

.progress-bar::before {
    @apply content-[''] absolute top-1/4 left-0 w-full h-1 bg-red-100;
    z-index: 0;
}

.progress-step {
    @apply flex flex-col items-center relative z-10;
    flex: 1;
}

.step-indicator {
    @apply w-14 h-14 rounded-full bg-white border-2 border-red-400 flex items-center justify-center mb-2;
    transition: all 0.3s ease;
}

.step-number {
    @apply text-red-500 font-semibold;
}

.check-icon {
    @apply w-6 h-6 text-white;
}

.progress-step.active .step-indicator {
    @apply bg-red-600 border-red-600;
}

.progress-step.active .step-number {
    @apply text-white;
}

.progress-step.completed .step-indicator {
    @apply bg-green-500 border-green-500;
}

.progress-step.completed .step-number {
    @apply text-white;
}

.step-label {
    @apply text-sm font-medium text-gray-800;
}

.step-description {
    @apply text-xs text-gray-500 mt-1;
}

.status-content {
  @apply max-w-4xl mx-auto px-4 py-4 bg-red-800 rounded-lg shadow-md border-2 border-red-200 shadow-red-300;
}

.status-title {
    @apply text-2xl font-semibold text-gray-800;
}

.status-description {
    @apply  text-lg text-gray-600 mt-2;
}

.action-buttons {
    @apply mt-6 flex justify-center gap-4;
}

.button {
    @apply inline-flex items-center justify-center px-6 py-3 rounded-lg text-white font-semibold;
}

.support-button {
    @apply bg-blue-600 hover:bg-blue-700;
}

.update-button {
    @apply bg-yellow-600 hover:bg-yellow-700;
}

.print-button {
    @apply bg-green-600 hover:bg-green-700;
}

.button-icon {
    @apply w-5 h-5 mr-2;
}

.status-icon {
    @apply mb-6 flex justify-center items-center;
}

.status-card {
    @apply  p-6 bg-white rounded-lg shadow-md;
}

.dialog-panel {
    @apply w-full max-w-md p-6 bg-white rounded-lg shadow-md;
}

.dialog-title {
    @apply text-lg font-medium text-gray-900;
}

.dialog-button {
    @apply mt-4 inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700;
}
</style>
