<script setup lang="ts">
import { ref, onMounted, onUnmounted, computed } from "vue";
import { Icon } from "@iconify/vue";

// Ganti tanggal pemira sesuai jadwal asli
const eventDate = new Date("2026-04-20T08:00:00");

const now = ref(new Date());
let timer: ReturnType<typeof setInterval>;

onMounted(() => {
    timer = setInterval(() => {
        now.value = new Date();
    }, 1000);
});

onUnmounted(() => clearInterval(timer));

const diff = computed(() => {
    const ms = eventDate.getTime() - now.value.getTime();
    if (ms <= 0) return { days: 0, hours: 0, minutes: 0, seconds: 0, started: true };
    return {
        days: Math.floor(ms / (1000 * 60 * 60 * 24)),
        hours: Math.floor((ms / (1000 * 60 * 60)) % 24),
        minutes: Math.floor((ms / (1000 * 60)) % 60),
        seconds: Math.floor((ms / 1000) % 60),
        started: false,
    };
});

const pad = (n: number) => String(n).padStart(2, "0");

const features = [
    { icon: "mdi:shield-check-outline", title: "Aman & Terpercaya", desc: "Sistem voting terenkripsi dan terverifikasi untuk menjaga kerahasiaan suaramu" },
    { icon: "mdi:lightning-bolt-outline", title: "Cepat & Mudah", desc: "Proses pemilihan yang simpel hanya dalam hitungan menit dari mana saja" },
    { icon: "mdi:chart-bar", title: "Hasil Transparan", desc: "Rekap hasil pemilihan dapat dipantau secara real-time setelah voting ditutup" },
];

const timeline = [
    { date: "26 Feb – 7 Mar 2026", label: "Pendaftaran Kandidat", icon: "mdi:account-plus-outline", done: true },
    { date: "Maret 2026", label: "Verifikasi & Kampanye", icon: "mdi:bullhorn-outline", done: false },
    { date: "April 2026", label: "Verifikasi Pemilih", icon: "mdi:account-check-outline", done: false },
    { date: "20 April 2026", label: "Hari Pemilihan", icon: "mdi:vote-outline", done: false },
    { date: "21 April 2026", label: "Pengumuman Hasil", icon: "mdi:trophy-outline", done: false },
];
</script>

<template>
    <div class="min-h-dvh overflow-x-hidden" style="background: #03103b; color: white; font-family: 'Geist', sans-serif;">

        <!-- ═══════════════════════════════════════════
             NAVBAR
        ═══════════════════════════════════════════ -->
        <nav class="sticky top-0 z-50 backdrop-blur-md border-b" style="background: rgba(3,16,59,0.85); border-color: rgba(255,255,255,0.08);">
            <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="/logo.svg" alt="Logo" class="h-9 w-9 object-contain drop-shadow" />
                    <span class="font-bold text-lg tracking-tight text-white">
                        PEMIRA <span style="color:#f97316">FIK</span>
                    </span>
                </div>
                <a :href="route('login')">
                    <button
                        class="font-bold px-5 py-2 rounded-full text-sm transition-all active:scale-95"
                        style="background: linear-gradient(135deg,#f97316,#eab308); color:white; box-shadow: 0 4px 15px rgba(249,115,22,0.4);"
                    >
                        Masuk
                    </button>
                </a>
            </div>
        </nav>

        <!-- ═══════════════════════════════════════════
             HERO
        ═══════════════════════════════════════════ -->
        <section class="relative min-h-screen flex flex-col items-center justify-center text-center px-6 pt-10 pb-32 overflow-hidden">

            <!-- Ocean depth gradient bg -->
            <div class="absolute inset-0 -z-10" style="background: linear-gradient(180deg, #03103b 0%, #04195a 40%, #062a7a 70%, #073590 100%);"/>

            <!-- Bubbles decorative -->
            <div class="absolute inset-0 -z-10 pointer-events-none overflow-hidden">
                <div v-for="i in 18" :key="i"
                    class="absolute rounded-full"
                    :style="{
                        width: (8 + (i * 7) % 24) + 'px',
                        height: (8 + (i * 7) % 24) + 'px',
                        left: ((i * 37 + 5) % 95) + '%',
                        bottom: ((i * 53) % 85) + '%',
                        background: 'rgba(144,224,239,0.12)',
                        border: '1px solid rgba(144,224,239,0.2)',
                        animation: `floatUp ${5 + (i % 5)}s ease-in-out infinite`,
                        animationDelay: (i * 0.4) + 's',
                    }"
                />
            </div>

            <!-- Radial glow behind logo -->
            <div class="absolute rounded-full -z-10"
                style="width:400px;height:400px;top:50%;left:50%;transform:translate(-50%,-60%);
                       background:radial-gradient(circle, rgba(249,115,22,0.12) 0%, transparent 70%);"/>

            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-semibold mb-8"
                style="background:rgba(249,115,22,0.15); border:1px solid rgba(249,115,22,0.4); color:#fb923c;">
                <Icon icon="mdi:calendar-star" class="text-base" />
                Pemilihan Umum Raya · FIK UPN Veteran Jatim · 2026
            </div>

            <!-- Logo -->
            <img src="/logo.svg" alt="Logo PEMIRA" class="w-32 h-32 mb-6 drop-shadow-xl" style="filter: drop-shadow(0 0 24px rgba(249,115,22,0.5));" />

            <!-- Title -->
            <h1 class="text-6xl sm:text-7xl font-extrabold tracking-tight mb-3" style="background:linear-gradient(135deg,#fde68a,#f97316,#fb923c); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                PEMIRA
            </h1>
            <p class="text-2xl sm:text-3xl font-bold mb-2" style="color: #90e0ef;">
                Fakultas Ilmu Komputer 2026
            </p>
            <p class="text-sm mb-8" style="color:rgba(144,224,239,0.7);">
                Universitas Pembangunan Nasional "Veteran" Jawa Timur
            </p>

            <p class="max-w-md mx-auto text-sm leading-relaxed mb-10" style="color:rgba(202,240,248,0.75);">
                Gunakan hak pilihmu! Pilih pemimpin terbaik untuk membawa
                Fasilkom UPN Veteran Jawa Timur ke arah yang lebih baik.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a :href="route('login')">
                    <button
                        class="flex items-center gap-2 font-bold px-8 py-3.5 rounded-full text-base transition-all active:scale-95"
                        style="background:linear-gradient(135deg,#f97316,#eab308); color:white; box-shadow:0 8px 30px rgba(249,115,22,0.45);"
                    >
                        <Icon icon="fa6-brands:google" />
                        Masuk dengan Google
                    </button>
                </a>
                <a href="#info">
                    <button
                        class="flex items-center gap-2 font-semibold px-8 py-3.5 rounded-full text-base transition-all active:scale-95"
                        style="border:1.5px solid rgba(144,224,239,0.35); color:#90e0ef; background:rgba(144,224,239,0.07);"
                    >
                        <Icon icon="mdi:chevron-down" />
                        Pelajari Lebih Lanjut
                    </button>
                </a>
            </div>

            <!-- Bottom wave -->
            <div class="absolute bottom-0 left-0 right-0 -z-0 pointer-events-none">
                <svg viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full h-24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,60 C240,110 480,10 720,60 C960,110 1200,10 1440,60 L1440,120 L0,120 Z"
                        fill="rgba(4,28,90,1)"/>
                </svg>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════
             COUNTDOWN
        ═══════════════════════════════════════════ -->
        <section style="background: #04285a; position:relative; padding: 5rem 1.5rem;">

            <!-- Top wave -->
            <div class="absolute top-0 left-0 right-0 pointer-events-none" style="transform:translateY(-99%);">
                <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,30 C360,60 1080,0 1440,30 L1440,60 L0,60 Z" fill="#04285a"/>
                </svg>
            </div>

            <div class="max-w-3xl mx-auto text-center">
                <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:rgba(144,224,239,0.6);">
                    🗳️ Waktu Menuju Hari Pemilihan
                </p>
                <h2 class="text-2xl font-extrabold mb-10" style="color:white;">
                    {{ diff.started ? "Pemilihan Sedang Berlangsung! 🎉" : "Hitung Mundur" }}
                </h2>

                <div v-if="!diff.started" class="flex justify-center gap-4 sm:gap-6">
                    <div
                        v-for="(item) in [
                            { val: diff.days, label: 'Hari' },
                            { val: diff.hours, label: 'Jam' },
                            { val: diff.minutes, label: 'Menit' },
                            { val: diff.seconds, label: 'Detik' },
                        ]"
                        :key="item.label"
                        class="flex flex-col items-center"
                    >
                        <div class="flex items-center justify-center w-20 h-20 sm:w-24 sm:h-24 rounded-2xl"
                            style="background:rgba(255,255,255,0.07); border:1px solid rgba(144,224,239,0.2); box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);">
                            <span class="tabular-nums text-3xl sm:text-4xl font-extrabold"
                                style="background:linear-gradient(135deg,#fde68a,#f97316); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                                {{ pad(item.val) }}
                            </span>
                        </div>
                        <span class="text-xs font-semibold mt-2 uppercase tracking-widest" style="color:rgba(144,224,239,0.6);">
                            {{ item.label }}
                        </span>
                    </div>
                </div>

                <div v-else class="text-3xl font-extrabold animate-pulse" style="color:#fbbf24;">
                    🗳️ Ayo segera berikan suaramu!
                </div>
            </div>

            <!-- Bottom wave -->
            <div class="absolute bottom-0 left-0 right-0 pointer-events-none" style="transform:translateY(99%);">
                <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,30 C360,0 1080,60 1440,30 L1440,0 L0,0 Z" fill="#04285a"/>
                </svg>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════
             FEATURES
        ═══════════════════════════════════════════ -->
        <section id="info" class="max-w-5xl mx-auto px-6 py-28">
            <div class="text-center mb-14">
                <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:rgba(144,224,239,0.5);">
                    Platform Digital
                </p>
                <h2 class="text-3xl sm:text-4xl font-extrabold" style="color:white;">
                    Kenapa PEMIRA Digital?
                </h2>
                <p class="mt-3 text-sm" style="color:rgba(144,224,239,0.6);">
                    Platform voting modern untuk seluruh mahasiswa FIK UPN Veteran Jatim
                </p>
            </div>
            <div class="grid sm:grid-cols-3 gap-6">
                <div
                    v-for="f in features"
                    :key="f.title"
                    class="rounded-2xl p-6 text-center transition-all hover:-translate-y-1"
                    style="background:rgba(255,255,255,0.04); border:1px solid rgba(144,224,239,0.12); backdrop-filter:blur(10px);"
                >
                    <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl mb-5"
                        style="background:rgba(249,115,22,0.15); border:1px solid rgba(249,115,22,0.3);">
                        <Icon :icon="f.icon" class="text-3xl" style="color:#f97316;" />
                    </div>
                    <h3 class="font-bold text-base mb-2" style="color:white;">{{ f.title }}</h3>
                    <p class="text-sm leading-relaxed" style="color:rgba(144,224,239,0.65);">{{ f.desc }}</p>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════
             TIMELINE
        ═══════════════════════════════════════════ -->
        <section style="background:#04285a; position:relative; padding:5rem 1.5rem 6rem;">

            <!-- Top wave -->
            <div class="absolute top-0 left-0 right-0 pointer-events-none" style="transform:translateY(-99%);">
                <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,0 C480,60 960,0 1440,60 L1440,60 L0,60 Z" fill="#04285a"/>
                </svg>
            </div>

            <div class="max-w-2xl mx-auto">
                <div class="text-center mb-14">
                    <p class="text-xs font-bold uppercase tracking-widest mb-3" style="color:rgba(144,224,239,0.5);">
                        Rangkaian Acara
                    </p>
                    <h2 class="text-3xl sm:text-4xl font-extrabold" style="color:white;">
                        Jadwal Kegiatan
                    </h2>
                </div>

                <div class="relative">
                    <!-- Vertical line -->
                    <div class="absolute left-5 top-0 bottom-0 w-px" style="background:linear-gradient(180deg, transparent, rgba(144,224,239,0.3) 10%, rgba(144,224,239,0.3) 90%, transparent);"/>

                    <div class="space-y-6">
                        <div
                            v-for="(item, i) in timeline"
                            :key="i"
                            class="relative flex gap-5 items-start"
                        >
                            <!-- Circle icon -->
                            <div
                                class="relative z-10 flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                                :style="item.done
                                    ? 'background:linear-gradient(135deg,#f97316,#eab308); box-shadow:0 0 12px rgba(249,115,22,0.5);'
                                    : 'background:rgba(255,255,255,0.06); border:1.5px solid rgba(144,224,239,0.25);'"
                            >
                                <Icon :icon="item.icon" class="text-lg" :style="item.done ? 'color:white' : 'color:rgba(144,224,239,0.7)'" />
                            </div>

                            <!-- Content card -->
                            <div class="flex-1 rounded-2xl p-4 transition-all"
                                :style="item.done
                                    ? 'background:rgba(249,115,22,0.1); border:1px solid rgba(249,115,22,0.3);'
                                    : 'background:rgba(255,255,255,0.04); border:1px solid rgba(144,224,239,0.1);'">
                                <p class="text-xs font-semibold mb-0.5"
                                    :style="item.done ? 'color:#fb923c' : 'color:rgba(144,224,239,0.5)'">
                                    {{ item.date }}
                                </p>
                                <p class="font-bold" style="color:white;">{{ item.label }}</p>
                                <span v-if="item.done"
                                    class="inline-flex items-center gap-1 text-xs font-semibold mt-1.5 px-2 py-0.5 rounded-full"
                                    style="background:rgba(249,115,22,0.2); color:#fb923c;">
                                    <Icon icon="mdi:check-circle" class="text-xs"/>
                                    Selesai
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom wave -->
            <div class="absolute bottom-0 left-0 right-0 pointer-events-none" style="transform:translateY(99%);">
                <svg viewBox="0 0 1440 60" preserveAspectRatio="none" class="w-full h-16" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0,60 C480,0 960,60 1440,0 L1440,0 L0,0 Z" fill="#04285a"/>
                </svg>
            </div>
        </section>

        <!-- ═══════════════════════════════════════════
             CTA
        ═══════════════════════════════════════════ -->
        <section class="max-w-3xl mx-auto px-6 py-32 text-center">
            <p class="text-xs font-bold uppercase tracking-widest mb-4" style="color:rgba(144,224,239,0.5);">
                Siap Berpartisipasi?
            </p>
            <h2 class="text-3xl sm:text-5xl font-extrabold mb-5 leading-tight" style="color:white;">
                Berikan <span style="background:linear-gradient(135deg,#fde68a,#f97316); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">Suaramu</span> Sekarang
            </h2>
            <p class="text-sm leading-relaxed mb-10 max-w-md mx-auto" style="color:rgba(144,224,239,0.65);">
                Login menggunakan akun Google mahasiswa UPN Veteran Jawa Timur
                (<span style="color:#90e0ef; font-weight:600;">@student.upnjatim.ac.id</span>)
                untuk mulai memilih.
            </p>
            <a :href="route('login')">
                <button
                    class="inline-flex items-center gap-3 font-bold px-10 py-4 rounded-full text-lg transition-all active:scale-95"
                    style="background:linear-gradient(135deg,#f97316,#eab308); color:white; box-shadow:0 12px 40px rgba(249,115,22,0.45);"
                >
                    <Icon icon="fa6-brands:google" class="text-xl" />
                    Masuk dengan Google
                </button>
            </a>
            <p class="text-xs mt-5" style="color:rgba(144,224,239,0.3);">
                Hanya untuk mahasiswa aktif FIK UPN Veteran Jatim
            </p>
        </section>

        <!-- ═══════════════════════════════════════════
             FOOTER
        ═══════════════════════════════════════════ -->
        <footer style="background:#020d2e; border-top:1px solid rgba(144,224,239,0.08); padding:2.5rem 1.5rem;">
            <div class="max-w-5xl mx-auto flex flex-col items-center gap-3 text-center">
                <div class="flex items-center gap-2">
                    <img src="/logo.svg" alt="Logo" class="h-7 w-7 object-contain opacity-70" />
                    <span class="font-bold" style="color:rgba(255,255,255,0.7);">PEMIRA FIK 2026</span>
                </div>
                <p class="text-xs" style="color:rgba(144,224,239,0.35);">
                    Universitas Pembangunan Nasional "Veteran" Jawa Timur
                </p>
                <p class="text-xs" style="color:rgba(144,224,239,0.35);">
                    Butuh bantuan?
                    <a href="https://wa.me/628819305047" target="_blank"
                        style="color:#f97316; text-decoration:underline;">
                        Hubungi kami disini
                    </a>
                </p>
                <div class="flex items-center gap-4 mt-1">
                    <a href="https://instagram.com/pemirafik26" target="_blank"
                        class="transition-opacity hover:opacity-100"
                        style="color:rgba(144,224,239,0.4);">
                        <Icon icon="mdi:instagram" class="text-xl" />
                    </a>
                </div>
            </div>
        </footer>

        <!-- Float-up animation style -->
        <style>
        @keyframes floatUp {
            0%   { transform: translateY(0) scale(1);   opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.8; }
            100% { transform: translateY(-120px) scale(0.7); opacity: 0; }
        }
        </style>

    </div>
</template>
