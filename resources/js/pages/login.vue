<script setup lang="ts">
import Flash from "@/components/Flash.vue";
import { PageProps } from "@/types";
import { Icon } from "@iconify/vue";
import { usePage } from "@inertiajs/vue3";

const page = usePage<PageProps>();
</script>

<template>
    <div class="min-h-dvh flex items-center justify-center p-4 relative overflow-hidden"
        style="background: linear-gradient(180deg, #03103b 0%, #04195a 50%, #062a7a 100%); font-family: 'Geist', sans-serif;">

        <!-- Bubbles background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                v-for="i in 14"
                :key="i"
                class="absolute rounded-full"
                :style="{
                    width: (8 + (i * 9) % 28) + 'px',
                    height: (8 + (i * 9) % 28) + 'px',
                    left: ((i * 43 + 10) % 95) + '%',
                    bottom: ((i * 47) % 80) + '%',
                    background: 'rgba(144,224,239,0.10)',
                    border: '1px solid rgba(144,224,239,0.18)',
                    animation: `floatUp ${6 + (i % 5)}s ease-in-out infinite`,
                    animationDelay: (i * 0.5) + 's',
                }"
            />
        </div>

        <!-- Radial glow -->
        <div class="absolute pointer-events-none"
            style="width:500px;height:500px;top:50%;left:50%;transform:translate(-50%,-50%);
                   background:radial-gradient(circle, rgba(249,115,22,0.10) 0%, transparent 65%);"/>

        <!-- Bottom wave decoration -->
        <div class="absolute bottom-0 left-0 right-0 pointer-events-none">
            <svg viewBox="0 0 1440 100" preserveAspectRatio="none" class="w-full h-20" xmlns="http://www.w3.org/2000/svg">
                <path d="M0,50 C360,100 1080,0 1440,50 L1440,100 L0,100 Z"
                    fill="rgba(2,13,46,0.6)"/>
            </svg>
        </div>

        <!-- Card -->
        <div class="relative z-10 w-full max-w-sm rounded-3xl overflow-hidden"
            style="background:rgba(255,255,255,0.04); border:1px solid rgba(144,224,239,0.15); backdrop-filter:blur(20px); box-shadow: 0 30px 80px rgba(0,0,0,0.5);">

            <!-- Card Header -->
            <div class="px-8 pt-10 pb-7 text-center"
                style="border-bottom:1px solid rgba(144,224,239,0.1);">
                <!-- Logo glow wrapper -->
                <div class="relative inline-block mb-5">
                    <div class="absolute inset-0 rounded-full"
                        style="background:radial-gradient(circle, rgba(249,115,22,0.35) 0%, transparent 70%); transform:scale(1.4); filter:blur(10px);"/>
                    <img
                        src="/logo.svg"
                        alt="Logo PEMIRA FIK 2026"
                        class="relative w-24 h-24 object-contain"
                        style="filter: drop-shadow(0 0 16px rgba(249,115,22,0.6));"
                    />
                </div>

                <h1 class="text-3xl font-extrabold tracking-tight"
                    style="background:linear-gradient(135deg,#fde68a,#f97316,#fb923c); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;">
                    PEMIRA
                </h1>
                <p class="font-bold mt-1" style="color:#90e0ef;">
                    Fakultas Ilmu Komputer 2026
                </p>
                <p class="text-xs mt-1.5" style="color:rgba(144,224,239,0.5);">
                    Universitas Pembangunan Nasional "Veteran" Jawa Timur
                </p>
            </div>

            <!-- Card Body -->
            <div class="px-8 py-7" style="border-bottom:1px solid rgba(144,224,239,0.1);">
                <p class="text-xs text-center font-semibold mb-5 uppercase tracking-widest"
                    style="color:rgba(144,224,239,0.45);">
                    Masuk untuk memilih
                </p>

                <a :href="route('auth.redirect')" class="block">
                    <button
                        class="w-full flex items-center justify-center gap-3 font-bold py-3.5 rounded-2xl text-base transition-all active:scale-95 hover:opacity-90"
                        style="background:linear-gradient(135deg,#f97316,#eab308); color:white; box-shadow:0 8px 24px rgba(249,115,22,0.4);"
                    >
                        <Icon icon="fa6-brands:google" class="text-lg" />
                        Masuk dengan Google
                    </button>
                </a>

                <Flash class="mt-4" />

                <p class="text-xs text-center mt-5 leading-relaxed" style="color:rgba(144,224,239,0.4);">
                    Gunakan akun
                    <span style="color:#90e0ef; font-weight:600;">@student.upnjatim.ac.id</span>
                    <br/>untuk mengakses sistem pemilihan
                </p>
            </div>

            <!-- Card Footer -->
            <div class="px-8 py-5 flex items-center justify-between">
                <a href="/" class="flex items-center gap-1.5 text-xs transition-opacity hover:opacity-80"
                    style="color:rgba(144,224,239,0.45);">
                    <Icon icon="mdi:arrow-left" />
                    Kembali
                </a>
                <a
                    href="https://wa.me/628819305047"
                    target="_blank"
                    class="text-xs transition-opacity hover:opacity-80"
                    style="color:rgba(144,224,239,0.45);"
                >
                    Butuh bantuan?
                    <span style="color:#f97316; text-decoration:underline;">Hubungi kami</span>
                </a>
            </div>
        </div>

        <!-- Float-up bubble animation -->
        <style>
        @keyframes floatUp {
            0%   { transform: translateY(0) scale(1);   opacity: 0; }
            10%  { opacity: 1; }
            90%  { opacity: 0.7; }
            100% { transform: translateY(-130px) scale(0.6); opacity: 0; }
        }
        </style>
    </div>
</template>
