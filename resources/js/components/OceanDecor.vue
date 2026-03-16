<script setup lang="ts">
import { computed, onMounted, onUnmounted, ref, type CSSProperties } from "vue";

const mouseX = ref(0);
const mouseY = ref(0);
const scrollY = ref(0);

const updateMouse = (event: MouseEvent) => {
    const width = window.innerWidth || 1;
    const height = window.innerHeight || 1;

    mouseX.value = (event.clientX / width) * 2 - 1;
    mouseY.value = (event.clientY / height) * 2 - 1;
};

const updateScroll = () => {
    scrollY.value = Math.min(window.scrollY, 640);
};

const decorStyle = computed<CSSProperties>(() => {
    const mx = mouseX.value;
    const my = mouseY.value;
    const sy = scrollY.value;

    return {
        "--mx-s": `${(mx * 3).toFixed(2)}px`,
        "--mx-m": `${(mx * 6).toFixed(2)}px`,
        "--mx-l": `${(mx * 10).toFixed(2)}px`,
        "--my-s": `${(my * 2).toFixed(2)}px`,
        "--my-m": `${(my * 5).toFixed(2)}px`,
        "--my-l": `${(my * 8).toFixed(2)}px`,
        "--sy-s": `${(sy * 0.03).toFixed(2)}px`,
        "--sy-m": `${(sy * 0.06).toFixed(2)}px`,
    };
});

onMounted(() => {
    updateScroll();
    window.addEventListener("mousemove", updateMouse, { passive: true });
    window.addEventListener("scroll", updateScroll, { passive: true });
});

onUnmounted(() => {
    window.removeEventListener("mousemove", updateMouse);
    window.removeEventListener("scroll", updateScroll);
});
</script>

<template>
    <div class="ocean-decor" :style="decorStyle" aria-hidden="true">
        <div class="sun-glow" />

        <div class="seagull seagull--one">
            <span class="wing wing-left" />
            <span class="wing wing-right" />
        </div>
        <div class="seagull seagull--two">
            <span class="wing wing-left" />
            <span class="wing wing-right" />
        </div>
        <div class="seagull seagull--three">
            <span class="wing wing-left" />
            <span class="wing wing-right" />
        </div>

        <div class="fish fish--one fish-orange" />
        <div class="fish fish--two fish-blue" />
        <div class="fish fish--three fish-mint" />
        <div class="fish fish--four fish-yellow" />
        <div class="fish fish--five fish-coral" />
        <div class="fish fish--six fish-violet" />

        <div class="float-ring" />

        <div class="palm palm--left">
            <span class="leaf leaf-a" />
            <span class="leaf leaf-b" />
            <span class="leaf leaf-c" />
        </div>

        <div class="palm palm--right">
            <span class="leaf leaf-a" />
            <span class="leaf leaf-b" />
            <span class="leaf leaf-c" />
        </div>

        <div class="shore" />
        <div class="foam foam-a" />
        <div class="foam foam-b" />
    </div>
</template>

<style scoped>
.ocean-decor {
    position: fixed;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    overflow: hidden;
}

.sun-glow {
    position: absolute;
    top: 6%;
    right: 10%;
    width: 220px;
    height: 220px;
    border-radius: 999px;
    background: radial-gradient(
        circle,
        rgba(250, 204, 21, 0.28) 0%,
        rgba(250, 204, 21, 0) 70%
    );
    animation: sunPulse 4.8s ease-in-out infinite;
}

.seagull {
    position: absolute;
    width: 42px;
    height: 16px;
    transform-origin: center;
}

.wing {
    position: absolute;
    top: 4px;
    width: 22px;
    height: 8px;
    border-top: 2px solid rgba(255, 255, 255, 0.88);
    border-radius: 999px;
}

.wing-left {
    left: 0;
    transform-origin: right center;
}

.wing-right {
    right: 0;
    transform-origin: left center;
}

.seagull::after {
    content: "";
    position: absolute;
    top: 6px;
    left: 18px;
    width: 6px;
    height: 4px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.9);
}

.seagull--one {
    left: -12%;
    top: 18%;
    animation: gullFlyRight 24s linear infinite;
}

.seagull--two {
    left: -18%;
    top: 24%;
    transform: scale(0.85);
    animation: gullFlyRight 30s linear infinite;
    animation-delay: 4s;
}

.seagull--three {
    right: -16%;
    top: 16%;
    transform: scaleX(-1) scale(0.78);
    animation: gullFlyLeft 26s linear infinite;
    animation-delay: 1.4s;
}

.seagull .wing-left,
.seagull .wing-right {
    animation: flap 1.1s ease-in-out infinite;
}

.seagull .wing-right {
    animation-delay: 0.08s;
}

.shore {
    position: absolute;
    left: -12%;
    right: -12%;
    bottom: -56px;
    height: 170px;
    border-radius: 50% 50% 0 0;
    background: linear-gradient(
        180deg,
        rgba(244, 190, 120, 0.95),
        rgba(222, 158, 98, 0.94)
    );
    box-shadow: inset 0 8px 22px rgba(255, 255, 255, 0.26);
    transform: translate(var(--mx-s), calc(var(--sy-s) * -1));
}

.foam {
    position: absolute;
    left: -8%;
    right: -8%;
    border-radius: 999px;
    background: rgba(226, 245, 255, 0.6);
    filter: blur(0.4px);
}

.foam-a {
    bottom: 102px;
    height: 24px;
    opacity: 0.75;
    animation: waveMotion 6.2s ease-in-out infinite;
}

.foam-b {
    bottom: 86px;
    height: 16px;
    opacity: 0.55;
    animation: waveMotion 7.8s ease-in-out infinite reverse;
}

.float-ring {
    position: absolute;
    bottom: 112px;
    right: 18%;
    width: 88px;
    height: 88px;
    border-radius: 999px;
    border: 12px solid #f97316;
    box-shadow:
        inset 0 0 0 8px rgba(255, 255, 255, 0.9),
        0 14px 24px rgba(2, 6, 23, 0.4);
    opacity: 0.75;
    animation: ringFloat 5.2s ease-in-out infinite;
}

.palm {
    position: absolute;
    bottom: 88px;
    width: 22px;
    height: 180px;
    border-radius: 999px;
    background: linear-gradient(180deg, #8b5e34 0%, #6b4226 100%);
    transform-origin: bottom center;
}

.palm--left {
    left: 6%;
    animation: palmSwayLeft 5s ease-in-out infinite;
}

.palm--right {
    right: 8%;
    animation: palmSwayRight 5.4s ease-in-out infinite;
}

.leaf {
    position: absolute;
    top: -24px;
    width: 118px;
    height: 24px;
    border-radius: 999px;
    background: linear-gradient(90deg, #3f9f5f 0%, #1f7a43 100%);
    box-shadow: inset 0 2px 5px rgba(255, 255, 255, 0.26);
}

.palm--left .leaf-a,
.palm--right .leaf-a {
    left: -6px;
    transform: rotate(-22deg);
}

.palm--left .leaf-b,
.palm--right .leaf-b {
    left: -52px;
    transform: rotate(-56deg);
}

.palm--left .leaf-c,
.palm--right .leaf-c {
    left: -34px;
    top: -40px;
    transform: rotate(-90deg);
}

.fish {
    --fish-main: #fb923c;
    --fish-mid: #f97316;
    --fish-tail: #facc15;

    position: absolute;
    width: 42px;
    height: 18px;
    border-radius: 999px;
    background: linear-gradient(
        90deg,
        var(--fish-main) 0%,
        var(--fish-mid) 65%,
        var(--fish-tail) 100%
    );
    opacity: 0.84;
}

.fish::before {
    content: "";
    position: absolute;
    right: -8px;
    top: 3px;
    width: 0;
    height: 0;
    border-top: 6px solid transparent;
    border-bottom: 6px solid transparent;
    border-left: 10px solid var(--fish-main);
}

.fish::after {
    content: "";
    position: absolute;
    left: 8px;
    top: 6px;
    width: 4px;
    height: 4px;
    border-radius: 999px;
    background: rgba(255, 255, 255, 0.95);
}

.fish-orange {
    --fish-main: #fb923c;
    --fish-mid: #f97316;
    --fish-tail: #facc15;
}

.fish-blue {
    --fish-main: #38bdf8;
    --fish-mid: #0ea5e9;
    --fish-tail: #93c5fd;
}

.fish-mint {
    --fish-main: #34d399;
    --fish-mid: #10b981;
    --fish-tail: #86efac;
}

.fish-yellow {
    --fish-main: #fde047;
    --fish-mid: #facc15;
    --fish-tail: #fb923c;
}

.fish-coral {
    --fish-main: #fb7185;
    --fish-mid: #f43f5e;
    --fish-tail: #fdba74;
}

.fish-violet {
    --fish-main: #a78bfa;
    --fish-mid: #8b5cf6;
    --fish-tail: #67e8f9;
}

.fish--one {
    left: -10%;
    top: 40%;
    animation: swimRight 14s linear infinite;
}

.fish--two {
    right: -12%;
    top: 54%;
    transform: scaleX(-1);
    animation: swimLeft 16s linear infinite;
}

.fish--three {
    left: -16%;
    top: 28%;
    transform: scale(0.85);
    animation: swimRightSmall 18s linear infinite;
    animation-delay: 2.4s;
}

.fish--four {
    left: -14%;
    top: 62%;
    transform: scale(0.78);
    animation: swimRightSmall 20s linear infinite;
    animation-delay: 5.2s;
}

.fish--five {
    right: -18%;
    top: 34%;
    transform: scaleX(-1) scale(0.9);
    animation: swimLeft 22s linear infinite;
    animation-delay: 1.6s;
}

.fish--six {
    left: -20%;
    top: 49%;
    transform: scale(0.66);
    animation: swimRight 24s linear infinite;
    animation-delay: 8.5s;
}

@keyframes swimRight {
    0% {
        transform: translateX(0) translateY(0);
    }
    25% {
        transform: translateX(35vw) translateY(calc(-10px + var(--my-s)));
    }
    50% {
        transform: translateX(70vw) translateY(calc(8px + var(--my-s)));
    }
    100% {
        transform: translateX(120vw) translateY(calc(-2px + var(--my-s)));
    }
}

@keyframes swimRightSmall {
    0% {
        transform: scale(0.82) translateX(0) translateY(0);
    }
    50% {
        transform: scale(0.82) translateX(62vw) translateY(calc(9px + var(--my-s)));
    }
    100% {
        transform: scale(0.82) translateX(120vw) translateY(calc(-4px + var(--my-s)));
    }
}

@keyframes swimLeft {
    0% {
        transform: scaleX(-1) translateX(0) translateY(0);
    }
    25% {
        transform: scaleX(-1) translateX(-30vw) translateY(calc(8px + var(--my-s)));
    }
    50% {
        transform: scaleX(-1) translateX(-65vw) translateY(calc(-6px + var(--my-s)));
    }
    100% {
        transform: scaleX(-1) translateX(-120vw) translateY(calc(2px + var(--my-s)));
    }
}

@keyframes gullFlyRight {
    0% {
        transform: translateX(0) translateY(0);
        opacity: 0.8;
    }
    50% {
        transform: translateX(70vw) translateY(calc(-20px + var(--my-s)));
        opacity: 1;
    }
    100% {
        transform: translateX(130vw) translateY(calc(6px + var(--my-s)));
        opacity: 0.85;
    }
}

@keyframes gullFlyLeft {
    0% {
        transform: scaleX(-1) translateX(0) translateY(0);
        opacity: 0.85;
    }
    50% {
        transform: scaleX(-1) translateX(-70vw) translateY(calc(-16px + var(--my-s)));
        opacity: 1;
    }
    100% {
        transform: scaleX(-1) translateX(-130vw) translateY(calc(6px + var(--my-s)));
        opacity: 0.86;
    }
}

@keyframes flap {
    0%,
    100% {
        transform: rotate(0deg);
    }
    50% {
        transform: rotate(12deg);
    }
}

@keyframes ringFloat {
    0%,
    100% {
        transform: translate(var(--mx-m), calc(var(--my-s) + var(--sy-s))) rotate(-7deg);
    }
    50% {
        transform: translate(var(--mx-m), calc(var(--my-s) + var(--sy-s) - 8px)) rotate(7deg);
    }
}

@keyframes palmSwayLeft {
    0%,
    100% {
        transform: translate(var(--mx-l), calc(var(--my-s) + var(--sy-s))) rotate(-8deg);
    }
    50% {
        transform: translate(var(--mx-l), calc(var(--my-s) + var(--sy-s))) rotate(-2deg);
    }
}

@keyframes palmSwayRight {
    0%,
    100% {
        transform: translate(var(--mx-l), calc(var(--my-s) + var(--sy-s))) rotate(8deg);
    }
    50% {
        transform: translate(var(--mx-l), calc(var(--my-s) + var(--sy-s))) rotate(2deg);
    }
}

@keyframes sunPulse {
    0%,
    100% {
        transform: translate(var(--mx-s), var(--my-s)) scale(1);
        opacity: 0.72;
    }
    50% {
        transform: translate(var(--mx-s), var(--my-s)) scale(1.08);
        opacity: 0.95;
    }
}

@keyframes waveMotion {
    0%,
    100% {
        transform: translateX(calc(var(--mx-s) * 0.5));
    }
    50% {
        transform: translateX(calc(18px + var(--mx-s) * 0.5));
    }
}

@media (max-width: 768px) {
    .palm {
        height: 128px;
    }

    .leaf {
        width: 86px;
    }

    .float-ring {
        right: 10%;
        width: 68px;
        height: 68px;
        border-width: 10px;
    }

    .sun-glow {
        width: 160px;
        height: 160px;
    }

    .seagull {
        opacity: 0.78;
    }
}
</style>
