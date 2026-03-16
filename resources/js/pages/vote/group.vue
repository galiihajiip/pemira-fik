<script lang="ts" setup>
import { Button } from "@/components/ui/button";
import {
    Card,
    CardContent,
    CardDescription,
    CardHeader,
    CardTitle,
} from "@/components/ui/card";
import { Link, useForm } from "@inertiajs/vue3";
import { computed, ref } from "vue";

const props = defineProps<{
    organization: Organization;
    group: Group;
    candidates: Candidate[];
    ballotDetails: BallotDetail[] | null;
}>();

const form = useForm({
    candidate_ids: null,
});

const selected = ref(
    props.ballotDetails?.map((detail) => detail.candidate_id) ?? [],
);

const isBemFasilkom = computed(() => {
    const groupName = props.group.name.toLowerCase();
    return (
        (groupName.includes("ketua") &&
            groupName.includes("wakil") &&
            groupName.includes("bem")) ||
        groupName.includes("bem fasilkom")
    );
});

const isBlmSainsData = computed(() =>
    props.group.name.toLowerCase().includes("blm sains data"),
);

const displayCandidates = computed(() => {
    const items: Array<Candidate | null> = [...props.candidates];

    if (isBlmSainsData.value && items.length === 0) {
        items.push(null);
    }

    if (isBemFasilkom.value && items.length < 2) {
        items.push(null);
    }

    return items;
});

const select = (id: number) => {
    if (selected.value.includes(id)) {
        selected.value = selected.value.filter((value) => value !== id);
    } else if (props.group.min_candidates === 1) {
        selected.value = [id];
    } else if (selected.value.length < props.group.min_candidates) {
        selected.value.push(id);
    }
};

const submit = () => {
    if (!selected.value) {
        return;
    }
    if (
        selected.value.length < props.group.min_candidates &&
        props.candidates.length >= props.group.min_candidates
    ) {
        form.setError(
            "candidate_ids",
            `Pilihlah minimal ${props.group.min_candidates} kandidat!`,
        );
        return;
    }
    useForm({
        candidate_ids: selected.value,
    }).post(
        route("vote.group.store", {
            organization: props.organization.id,
            group: props.group.id,
        }),
        {
            preserveState: false,
        },
    );
};
</script>

<template>
    <div class="min-h-dvh flex justify-center p-4">
        <div class="max-w-screen-xl w-full space-y-4">
            <Card>
                <CardHeader class="text-center">
                    <CardTitle>{{ group.name }}</CardTitle>
                    <CardDescription>
                        Pilihlah {{ group.min_candidates }} kandidat di bawah
                        ini!
                    </CardDescription>
                    <div class="flex justify-center gap-2">
                        <Link
                            :href="
                                route('vote.group.previous', {
                                    organization: organization.id,
                                    group: group.id,
                                })
                            "
                        >
                            <Button variant="outline">Kembali</Button>
                        </Link>
                        <Button :disabled="!selected" @click="submit">
                            Selanjutnya
                        </Button>
                    </div>
                    <div
                        v-if="form.errors.candidate_ids"
                        class="text-destructive text-sm font-medium"
                    >
                        {{ form.errors.candidate_ids }}
                    </div>
                </CardHeader>
                <CardContent>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <Card
                            v-for="(candidate, number) in displayCandidates"
                            :key="candidate?.id ?? `empty-${number}`"
                            class="aspect-square overflow-hidden"
                            :class="[
                                {
                                    outline:
                                        candidate &&
                                        selected.includes(candidate.id),
                                },
                                candidate
                                    ? 'cursor-pointer'
                                    : 'empty-candidate-card border-cyan-200/30',
                            ]"
                            @click="candidate ? select(candidate.id) : null"
                        >
                            <div v-if="candidate" class="size-full grid grid-cols-2 divide-x">
                                <div>
                                    <div class="relative">
                                        <div
                                            class="absolute bottom-4 left-4 size-8 flex items-center justify-center shadow bg-primary text-primary-foreground border-0 rounded-full text-lg font-bold"
                                        >
                                            {{ number + 1 }}
                                        </div>
                                        <img
                                            :src="`/storage/${candidate.picture}`"
                                        />
                                    </div>
                                    <CardHeader class="p-4 text-sm">
                                        <CardTitle class="leading-normal">
                                            {{ candidate.name_1 }}
                                            <template v-if="candidate.name_2">
                                                <br />
                                                &
                                                <br />
                                                {{ candidate.name_2 }}
                                            </template>
                                        </CardTitle>
                                    </CardHeader>
                                </div>
                                <div class="overflow-y-auto">
                                    <CardHeader class="p-4">
                                        <CardDescription
                                            class="text-foreground text-xs"
                                        >
                                            Visi
                                        </CardDescription>
                                        <pre
                                            class="font-sans text-xs text-muted-foreground text-wrap"
                                            >{{ candidate.vision }}</pre
                                        >
                                    </CardHeader>
                                    <CardContent class="px-4 pb-4">
                                        <CardDescription
                                            class="text-foreground text-xs"
                                        >
                                            Misi
                                        </CardDescription>
                                        <pre
                                            class="font-sans text-xs text-muted-foreground text-wrap"
                                            >{{ candidate.mission }}</pre
                                        >
                                    </CardContent>
                                </div>
                            </div>
                            <div
                                v-else
                                class="empty-candidate-content size-full p-6 flex flex-col items-center justify-center text-center gap-3"
                            >
                                <div class="empty-candidate-bubble empty-candidate-bubble--a" />
                                <div class="empty-candidate-bubble empty-candidate-bubble--b" />
                                <div
                                    class="size-12 flex items-center justify-center rounded-full text-lg font-bold bg-primary/20 text-primary border border-primary/40 shadow-lg"
                                >
                                    {{ number + 1 }}
                                </div>
                                <CardTitle class="text-base tracking-wide text-cyan-50">
                                    Kotak Kosong
                                </CardTitle>
                                <CardDescription
                                    class="text-xs text-cyan-100/75 max-w-[18ch]"
                                >
                                    {{
                                        isBlmSainsData
                                            ? "Belum ada kandidat di kelompok ini."
                                            : "Slot kandidat kedua belum terisi."
                                    }}
                                </CardDescription>
                            </div>
                        </Card>
                    </div>
                </CardContent>
            </Card>
        </div>
    </div>
</template>

<style scoped>
.empty-candidate-card {
    position: relative;
    border-style: solid;
    background:
        linear-gradient(145deg, rgba(186, 230, 253, 0.14), rgba(8, 47, 73, 0.28)),
        radial-gradient(circle at 15% 20%, rgba(125, 211, 252, 0.24), transparent 45%),
        rgba(14, 116, 144, 0.1);
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, 0.28),
        inset 0 -14px 26px rgba(8, 47, 73, 0.28),
        0 18px 38px rgba(2, 6, 23, 0.5),
        0 0 24px rgba(56, 189, 248, 0.18);
    backdrop-filter: blur(7px);
    transition: transform 0.28s ease, box-shadow 0.28s ease;
}

.empty-candidate-card::before {
    content: "";
    position: absolute;
    inset: 8px;
    border-radius: 0.7rem;
    border: 1px solid rgba(186, 230, 253, 0.35);
    pointer-events: none;
}

.empty-candidate-card::after {
    content: "";
    position: absolute;
    top: 0;
    left: 10%;
    width: 80%;
    height: 40%;
    border-radius: 0 0 999px 999px;
    background: linear-gradient(
        to bottom,
        rgba(224, 242, 254, 0.28),
        rgba(224, 242, 254, 0)
    );
    pointer-events: none;
}

.empty-candidate-card:hover {
    transform: translateY(-3px) scale(1.01);
    box-shadow:
        inset 0 1px 0 rgba(255, 255, 255, 0.3),
        inset 0 -16px 28px rgba(8, 47, 73, 0.3),
        0 22px 44px rgba(2, 6, 23, 0.55),
        0 0 28px rgba(103, 232, 249, 0.24);
}

.empty-candidate-content {
    position: relative;
    z-index: 1;
}

.empty-candidate-bubble {
    position: absolute;
    border-radius: 999px;
    border: 1px solid rgba(186, 230, 253, 0.5);
    background: rgba(186, 230, 253, 0.1);
    box-shadow: inset 0 1px 2px rgba(255, 255, 255, 0.3);
    animation: driftBubble 4.8s ease-in-out infinite;
}

.empty-candidate-bubble--a {
    width: 28px;
    height: 28px;
    top: 12%;
    left: 12%;
}

.empty-candidate-bubble--b {
    width: 18px;
    height: 18px;
    right: 13%;
    bottom: 16%;
    animation-delay: 0.9s;
}

@keyframes driftBubble {
    0%,
    100% {
        transform: translateY(0);
        opacity: 0.55;
    }
    50% {
        transform: translateY(-7px);
        opacity: 0.9;
    }
}
</style>
