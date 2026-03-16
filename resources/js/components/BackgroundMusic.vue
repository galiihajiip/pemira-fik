<script setup lang="ts">
import { computed, onMounted, ref } from "vue";

const useYoutubeSource = true;
const youtubeVideoId = "ULkUwh9uKe0";

const audioRef = ref<HTMLAudioElement | null>(null);
const isPlaying = ref(false);
const waitingForInteraction = ref(false);
const volume = ref(0.35);

const youtubeSrc = computed(() => {
    if (!isPlaying.value || !useYoutubeSource) {
        return "";
    }

    return `https://www.youtube.com/embed/${youtubeVideoId}?autoplay=1&loop=1&playlist=${youtubeVideoId}&controls=0&disablekb=1&modestbranding=1&rel=0`;
});

const buttonLabel = computed(() => {
    if (waitingForInteraction.value) {
        return "Nyalakan Musik";
    }

    return isPlaying.value ? "Musik: ON" : "Musik: OFF";
});

const applyVolume = () => {
    if (useYoutubeSource) {
        return;
    }

    if (!audioRef.value) {
        return;
    }

    audioRef.value.volume = volume.value;
};

const playAudio = async () => {
    if (useYoutubeSource) {
        isPlaying.value = true;
        waitingForInteraction.value = false;
        return;
    }

    if (!audioRef.value) {
        return;
    }

    try {
        await audioRef.value.play();
        isPlaying.value = true;
        waitingForInteraction.value = false;
    } catch {
        isPlaying.value = false;
        waitingForInteraction.value = true;
    }
};

const pauseAudio = () => {
    if (useYoutubeSource) {
        isPlaying.value = false;
        return;
    }

    if (!audioRef.value) {
        return;
    }

    audioRef.value.pause();
    isPlaying.value = false;
};

const toggleAudio = async () => {
    if (isPlaying.value) {
        pauseAudio();
        return;
    }

    await playAudio();
};

onMounted(async () => {
    applyVolume();

    if (useYoutubeSource) {
        waitingForInteraction.value = true;
        return;
    }

    await playAudio();
});
</script>

<template>
    <div class="bgm-panel">
        <audio
            v-if="!useYoutubeSource"
            ref="audioRef"
            loop
            preload="metadata"
            src="/audio/pemira-bgm.mp3"
            @play="isPlaying = true"
            @pause="isPlaying = false"
        />

        <iframe
            v-if="useYoutubeSource && youtubeSrc"
            class="yt-audio-frame"
            :src="youtubeSrc"
            title="Background music"
            allow="autoplay; encrypted-media"
            referrerpolicy="strict-origin-when-cross-origin"
        />

        <button class="bgm-toggle" type="button" @click="toggleAudio">
            {{ buttonLabel }}
        </button>

        <input
            v-if="!useYoutubeSource"
            class="bgm-volume"
            type="range"
            min="0"
            max="1"
            step="0.01"
            v-model.number="volume"
            @input="applyVolume"
            aria-label="Volume musik latar"
        />

        <span v-if="useYoutubeSource" class="bgm-source">YouTube</span>
    </div>
</template>

<style scoped>
.bgm-panel {
    position: fixed;
    left: 14px;
    bottom: 14px;
    z-index: 30;
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 10px;
    border-radius: 999px;
    background: rgba(2, 6, 23, 0.7);
    border: 1px solid rgba(148, 221, 255, 0.35);
    backdrop-filter: blur(8px);
    pointer-events: auto;
}

.bgm-toggle {
    border: none;
    border-radius: 999px;
    padding: 7px 12px;
    font-size: 12px;
    font-weight: 700;
    color: #e0f2fe;
    background: linear-gradient(135deg, #0284c7, #0369a1);
    cursor: pointer;
}

.bgm-volume {
    width: 88px;
    accent-color: #38bdf8;
}

.yt-audio-frame {
    position: absolute;
    width: 1px;
    height: 1px;
    opacity: 0;
    pointer-events: none;
    border: 0;
}

.bgm-source {
    font-size: 11px;
    font-weight: 700;
    color: #bae6fd;
    background: rgba(14, 116, 144, 0.5);
    padding: 5px 8px;
    border-radius: 999px;
}

@media (max-width: 768px) {
    .bgm-panel {
        left: 10px;
        right: 10px;
        bottom: 10px;
        justify-content: space-between;
        border-radius: 14px;
    }

    .bgm-volume {
        width: 110px;
    }
}
</style>
